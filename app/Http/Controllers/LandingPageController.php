<?php
// Contrôleur : landing pages Google Ads (/lp/{type})
// Capture UTM + GCLID, A/B testing, formulaire de demande

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\AdConversion;
use App\Models\Faq;

class LandingPageController extends Controller
{
    // Configurations des landing pages par type de prêt
    private const PAGES = [
        'pret-immobilier' => [
            'title_a'      => 'Prêt Immobilier — Obtenez votre financement en 48h',
            'title_b'      => 'Financement immobilier sur mesure — Taux compétitifs',
            'subtitle'     => 'KapitalStark finance votre projet immobilier avec des taux avantageux et un accompagnement personnalisé.',
            'loan_type'    => 'immobilier',
            'keyword'      => 'prêt immobilier',
            'trust_stats'  => ['clients' => '12 000+', 'years' => '15 ans', 'rate' => 'Dès 3,2 %'],
            'color'        => '#267BF1',
        ],
        'pret-automobile' => [
            'title_a'      => 'Prêt Auto — Financez votre véhicule rapidement',
            'title_b'      => 'Crédit auto flexible — Réponse en 24h',
            'subtitle'     => 'Obtenez votre prêt automobile avec des mensualités adaptées à votre budget.',
            'loan_type'    => 'automobile',
            'keyword'      => 'prêt automobile',
            'trust_stats'  => ['clients' => '8 500+', 'years' => '15 ans', 'rate' => 'Dès 4,5 %'],
            'color'        => '#267BF1',
        ],
        'pret-personnel' => [
            'title_a'      => 'Prêt Personnel — Sans justificatif, réponse immédiate',
            'title_b'      => 'Crédit personnel flexible — Jusqu\'à 75 000 €',
            'subtitle'     => 'Réalisez vos projets personnels avec un prêt sans justificatif d\'utilisation.',
            'loan_type'    => 'personnel',
            'keyword'      => 'prêt personnel',
            'trust_stats'  => ['clients' => '20 000+', 'years' => '15 ans', 'rate' => 'Dès 5,9 %'],
            'color'        => '#267BF1',
        ],
        'pret-entreprise' => [
            'title_a'      => 'Prêt Entreprise — Financez votre croissance',
            'title_b'      => 'Crédit professionnel — Solutions PME & TPE',
            'subtitle'     => 'Développez votre activité avec nos solutions de financement adaptées aux entreprises.',
            'loan_type'    => 'entreprise',
            'keyword'      => 'prêt entreprise',
            'trust_stats'  => ['clients' => '3 200+', 'years' => '15 ans', 'rate' => 'Dès 4,8 %'],
            'color'        => '#267BF1',
        ],
    ];

    public function show(Request $request, string $type): \Illuminate\View\View|\Illuminate\Http\Response
    {
        if (!isset(self::PAGES[$type])) {
            abort(404);
        }

        // Capture et stockage UTM + GCLID en session et cookie
        $this->captureUtm($request);

        $page = self::PAGES[$type];

        // A/B testing : variante A ou B selon cookie ou hasard
        $variant = $request->cookie('lp_variant') ?? (rand(0, 1) ? 'a' : 'b');
        $title = $variant === 'a' ? $page['title_a'] : $page['title_b'];

        // Pré-remplissage depuis UTM term
        $prefill = [
            'objet' => $request->session()->get('utm_term', ''),
        ];

        // FAQ spécifiques au type de prêt
        $faqs = Faq::forPage('prets/' . $page['loan_type']);

        return view('landing.show', compact('page', 'type', 'title', 'variant', 'prefill', 'faqs'))
            ->withCookie(cookie('lp_variant', $variant, 60 * 24 * 30));
    }

    public function submit(Request $request, string $type): \Illuminate\Http\RedirectResponse
    {
        if (!isset(self::PAGES[$type])) abort(404);

        $data = $request->validate([
            'prenom'          => 'required|string|max:50',
            'nom'             => 'required|string|max:50',
            'montant_souhaite'=> 'required|numeric|min:1000|max:1000000',
            'duree'           => 'required|integer|min:6|max:360',
            'objet_pret'      => 'nullable|string|max:200',
            'telephone'       => 'required|string|max:20',
            'email'           => 'required|email|max:100',
            'revenus_mensuels'=> 'required|numeric|min:0',
        ], [
            'prenom.required'           => 'Votre prénom est requis.',
            'nom.required'              => 'Votre nom est requis.',
            'montant_souhaite.required' => 'Veuillez indiquer le montant souhaité.',
            'telephone.required'        => 'Votre numéro de téléphone est requis.',
            'email.required'            => 'Votre adresse e-mail est requise.',
            'email.email'               => 'L\'adresse e-mail n\'est pas valide.',
            'revenus_mensuels.required' => 'Vos revenus mensuels sont requis.',
        ]);

        $page = self::PAGES[$type];

        // Enregistrer la conversion côté serveur
        AdConversion::record('landing_submit', $request, 75.00);

        // Notification admin par e-mail (simple, sans queue)
        try {
            \Mail::raw(
                "Nouvelle demande depuis landing page /{$type}\n\n"
                . "Nom : {$data['prenom']} {$data['nom']}\n"
                . "Email : {$data['email']}\n"
                . "Téléphone : {$data['telephone']}\n"
                . "Montant : {$data['montant_souhaite']} € sur {$data['duree']} mois\n"
                . "Revenus : {$data['revenus_mensuels']} €/mois\n"
                . "Objet : " . ($data['objet_pret'] ?? 'non précisé') . "\n"
                . "Source : " . ($request->session()->get('utm_source', 'direct')) . "\n"
                . "GCLID : " . ($request->session()->get('gclid', '-')) . "\n",
                fn ($m) => $m->to('contacto@kapitalstarks.com')
                             ->subject("LP {$type} — {$data['prenom']} {$data['nom']}")
            );
        } catch (\Throwable) { /* non bloquant */ }

        return redirect()->route('landing.show', $type)
            ->with('success', 'Votre demande a bien été reçue. Un conseiller vous contacte dans les 24h.');
    }

    // ── Capture UTM + GCLID ───────────────────────────────────────────────────

    private function captureUtm(Request $request): void
    {
        $params = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content', 'gclid'];
        foreach ($params as $param) {
            if ($request->has($param)) {
                $request->session()->put($param, $request->get($param));
            }
        }
    }
}
