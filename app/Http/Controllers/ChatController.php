<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\ChatSession;
use App\Models\ChatMessage;
use App\Mail\ChatAlert;

class ChatController extends Controller
{
    /**
     * Réponses automatiques du bot.
     * Clé = regex à tester sur le message visiteur.
     * Valeur = texte de réponse + lien optionnel.
     */
    private const BOT_RULES = [
        '/simulat|prêt|taux|mensualit|emprunt|calculat/i' => [
            'body' => 'Bien sûr ! Vous pouvez utiliser notre simulateur gratuit pour calculer vos mensualités et obtenir une estimation personnalisée.',
            'link' => '/simulateur', 'link_label' => 'Ouvrir le simulateur',
        ],
        '/immobilier|appartement|maison|logement|achat immob/i' => [
            'body' => 'Pour un prêt immobilier, nos taux démarrent à 1,9 %. Consultez notre page dédiée pour tous les détails et simuler votre projet.',
            'link' => '/prets/immobilier', 'link_label' => 'Voir le prêt immobilier',
        ],
        '/auto|voiture|véhicule|moto|vehicule/i' => [
            'body' => 'Notre prêt automobile est disponible dès 2,5 % pour l\'achat d\'un véhicule neuf ou d\'occasion.',
            'link' => '/prets/automobile', 'link_label' => 'Voir le prêt auto',
        ],
        '/personnel|consommation|voyage|mariage|étude|travaux/i' => [
            'body' => 'Le prêt personnel KapitalStark couvre vos projets du quotidien à partir de 3,2 %. Simulation gratuite en 2 minutes.',
            'link' => '/prets/personnel', 'link_label' => 'Voir le prêt personnel',
        ],
        '/entreprise|professionnel|société|commerce|activité/i' => [
            'body' => 'Pour financer votre activité professionnelle, nous proposons des solutions sur-mesure. Découvrez notre offre entreprise.',
            'link' => '/prets/entreprise', 'link_label' => 'Voir le prêt entreprise',
        ],
        '/rdv|rendez-vous|rencontre|conseiller|rappel/i' => [
            'body' => 'Vous pouvez prendre rendez-vous avec l\'un de nos conseillers dès maintenant, en ligne ou en agence.',
            'link' => '/contact/rdv', 'link_label' => 'Prendre RDV',
        ],
        '/dossier|demande|soumettre|deposer|document/i' => [
            'body' => 'Créez votre espace client gratuit pour déposer votre dossier en ligne en quelques minutes.',
            'link' => '/espace-client/register', 'link_label' => 'Créer mon espace',
        ],
        '/contact|joindre|telephone|email|adresse/i' => [
            'body' => 'Vous pouvez nous contacter via notre formulaire de contact ou directement par email à contact@kapitalstarks.com.',
            'link' => '/contact', 'link_label' => 'Nous contacter',
        ],
        '/bonjour|salut|hello|bonsoir|coucou/i' => [
            'body' => 'Bonjour ! Je suis le conseiller virtuel KapitalStark. Comment puis-je vous aider aujourd\'hui ? (prêt, simulation, rendez-vous…)',
        ],
        '/merci|parfait|super|excellent|ok|d\'accord/i' => [
            'body' => 'Avec plaisir ! N\'hésitez pas si vous avez d\'autres questions. Nous sommes là pour vous aider.',
        ],
        '/faq|question|aide|comment|quoi|pourquoi/i' => [
            'body' => 'Bonne question ! Consultez notre FAQ pour trouver des réponses aux questions fréquentes, ou posez-moi votre question directement.',
            'link' => '/faq', 'link_label' => 'Voir la FAQ',
        ],
    ];

    /**
     * Envoyer un message (visiteur → serveur).
     * Le serveur tente une réponse bot, sinon envoie un email admin.
     */
    public function store(Request $request)
    {
        $request->validate(['body' => 'required|string|max:2000']);

        $token   = $request->cookie('chat_token') ?? $this->makeToken();
        $session = ChatSession::firstOrCreate(
            ['token' => $token],
            [
                'ip_address' => $request->ip(),
                'user_agent' => substr($request->userAgent() ?? '', 0, 255),
            ]
        );
        $session->update(['last_seen_at' => now()]);

        // Sauvegarder le message visiteur
        ChatMessage::create([
            'session_id' => $session->id,
            'direction'  => 'visitor',
            'body'       => $request->body,
        ]);

        // Analyser et tenter une réponse automatique
        $botReply = $this->matchBot($request->body);

        $botMsgId = null;

        if ($botReply) {
            // Sauvegarder la réponse bot comme message admin
            $botMsg   = ChatMessage::create([
                'session_id' => $session->id,
                'direction'  => 'admin',
                'body'       => $botReply['body'],
                'read'       => true, // déjà affiché côté client
            ]);
            $botMsgId = $botMsg->id;
        } else {
            // Bot incapable → email d'alerte à l'admin
            try {
                Mail::send(new ChatAlert($session, $request->body));
            } catch (\Throwable $e) {
                // Ne pas bloquer si l'email échoue
            }
        }

        $response = response()->json([
            'ok'       => true,
            'token'    => $token,
            'bot'      => $botReply,
            'bot_id'   => $botMsgId, // permet au JS de sauter ce message dans le poll
        ]);

        return $response->cookie('chat_token', $token, 60 * 24 * 30, '/', null, false, true);
    }

    /**
     * Récupérer les nouveaux messages admin/bot depuis un certain ID.
     */
    public function poll(Request $request)
    {
        $token = $request->cookie('chat_token');
        if (! $token) return response()->json(['messages' => []]);

        $session = ChatSession::where('token', $token)->first();
        if (! $session) return response()->json(['messages' => []]);

        $since    = (int) $request->query('since', 0);
        $messages = ChatMessage::where('session_id', $session->id)
            ->where('direction', 'admin')
            ->where('id', '>', $since)
            ->orderBy('id')
            ->get(['id', 'body', 'created_at']);

        ChatMessage::where('session_id', $session->id)
            ->where('direction', 'admin')
            ->where('read', false)
            ->update(['read' => true]);

        return response()->json(['messages' => $messages]);
    }

    /**
     * Chercher une réponse bot correspondant au message.
     */
    private function matchBot(string $text): ?array
    {
        foreach (self::BOT_RULES as $pattern => $reply) {
            if (preg_match($pattern, $text)) {
                return $reply;
            }
        }
        return null;
    }

    private function makeToken(): string
    {
        return bin2hex(random_bytes(32));
    }
}
