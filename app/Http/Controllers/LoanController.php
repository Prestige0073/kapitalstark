<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoanController extends Controller
{
    private array $loans = [
        'immobilier' => [
            'type'     => 'immobilier',
            'icon'     => '🏠',
            'title'    => 'Prêt Immobilier',
            'subtitle' => 'Financer votre bien, à votre rythme',
            'desc'     => 'Que vous achetiez votre résidence principale, un investissement locatif ou financiez des travaux, KapitalStark vous propose les meilleures conditions du marché avec un accompagnement personnalisé.',
            'rate_min' => '1.9',
            'rate_max' => '3.2',
            'amount_min' => '50 000 €',
            'amount_max' => '1 000 000 €',
            'duration_max' => '30 ans',
            'color'    => '#267BF1',
            'subcategories' => [
                ['icon'=>'🏡','title'=>'Achat résidence principale','desc'=>'Financez l\'achat de votre maison ou appartement avec les meilleures conditions.'],
                ['icon'=>'💼','title'=>'Investissement locatif','desc'=>'Développez votre patrimoine immobilier avec un financement optimisé.'],
                ['icon'=>'🔄','title'=>'Rachat de crédit','desc'=>'Regroupez vos crédits pour alléger vos mensualités et réduire votre taux.'],
                ['icon'=>'🔨','title'=>'Financement travaux','desc'=>'Rénovation, extension, mise aux normes — financez tous vos projets.'],
            ],
            'documents' => ['Pièce d\'identité','3 derniers bulletins de salaire','2 derniers avis d\'imposition','3 derniers relevés de compte','Compromis de vente'],
            'faq' => [
                ['q'=>'Quel apport minimum est nécessaire ?','r'=>'En général, nous recommandons un apport de 10% minimum. Certains profils peuvent emprunter sans apport.'],
                ['q'=>'Quelle est la durée maximale ?','r'=>'Pour un prêt immobilier, la durée peut aller jusqu\'à 30 ans selon votre profil et le type de bien.'],
                ['q'=>'Puis-je rembourser par anticipation ?','r'=>'Oui, le remboursement anticipé est possible. Des indemnités peuvent s\'appliquer selon les conditions de votre contrat.'],
            ],
        ],
        'automobile' => [
            'type'     => 'automobile',
            'icon'     => '🚗',
            'title'    => 'Prêt Automobile',
            'subtitle' => 'Prenez le volant de votre financement',
            'desc'     => 'Véhicule neuf, occasion, utilitaire ou leasing — KapitalStark finance tous vos projets automobiles avec des taux compétitifs et une réponse en 24h.',
            'rate_min' => '2.5',
            'rate_max' => '5.9',
            'amount_min' => '3 000 €',
            'amount_max' => '150 000 €',
            'duration_max' => '84 mois',
            'color'    => '#1A56B0',
            'subcategories' => [
                ['icon'=>'✨','title'=>'Véhicule neuf','desc'=>'Financez votre voiture neuve avec un taux préférentiel et des mensualités adaptées.'],
                ['icon'=>'🔍','title'=>'Véhicule occasion','desc'=>'Voiture récente ou ancienne, nous finançons tous types de véhicules d\'occasion.'],
                ['icon'=>'🚐','title'=>'Utilitaire professionnel','desc'=>'Fourgons, camionnettes, véhicules de fonction — solutions pour professionnels.'],
                ['icon'=>'🔑','title'=>'Leasing / LOA','desc'=>'Conduisez sans acheter : location avec option d\'achat flexible.'],
            ],
            'documents' => ['Pièce d\'identité','3 derniers bulletins de salaire','Relevés de compte (3 mois)','Bon de commande du véhicule','Permis de conduire'],
            'faq' => [
                ['q'=>'Puis-je financer un véhicule d\'occasion ?','r'=>'Oui, nous finançons tous les véhicules, neufs ou d\'occasion, jusqu\'à 10 ans.'],
                ['q'=>'Quelle différence entre crédit auto et LOA ?','r'=>'Le crédit auto vous rend propriétaire dès l\'achat. La LOA vous permet de louer avec option d\'achat en fin de contrat.'],
                ['q'=>'La garantie est-elle obligatoire ?','r'=>'Une assurance tous risques est recommandée. Elle peut être incluse dans votre financement.'],
            ],
        ],
        'personnel' => [
            'type'     => 'personnel',
            'icon'     => '💳',
            'title'    => 'Prêt Personnel',
            'subtitle' => 'Réalisez vos projets, sans justificatif',
            'desc'     => 'Voyage, mariage, études, équipement, santé — le prêt personnel KapitalStark vous donne accès aux fonds dont vous avez besoin, sans justifier de l\'utilisation.',
            'rate_min' => '3.2',
            'rate_max' => '12.0',
            'amount_min' => '1 000 €',
            'amount_max' => '75 000 €',
            'duration_max' => '84 mois',
            'color'    => '#267BF1',
            'subcategories' => [
                ['icon'=>'✈️','title'=>'Voyage & Loisirs','desc'=>'Partez à la découverte du monde avec un financement simple et rapide.'],
                ['icon'=>'💍','title'=>'Mariage & Événements','desc'=>'Célébrez les grands moments de votre vie sans contrainte financière.'],
                ['icon'=>'🎓','title'=>'Études & Formation','desc'=>'Investissez dans votre avenir avec un prêt étudiant avantageux.'],
                ['icon'=>'🏥','title'=>'Santé & Bien-être','desc'=>'Frais médicaux, optique, dentaire — financement rapide sans justificatif.'],
            ],
            'documents' => ['Pièce d\'identité','3 derniers bulletins de salaire','Relevés de compte (3 mois)','Justificatif de domicile'],
            'faq' => [
                ['q'=>'Dois-je justifier l\'utilisation des fonds ?','r'=>'Non, le prêt personnel ne nécessite aucun justificatif sur l\'utilisation des fonds.'],
                ['q'=>'Combien de temps pour obtenir les fonds ?','r'=>'Après acceptation, les fonds sont disponibles sous 7 à 14 jours ouvrés (délai légal de rétractation).'],
                ['q'=>'Puis-je rembourser par anticipation ?','r'=>'Oui, sans frais pour les prêts inférieurs à 10 000 €. Des indemnités plafonnées s\'appliquent au-delà.'],
            ],
        ],
        'entreprise' => [
            'type'     => 'entreprise',
            'icon'     => '🏢',
            'title'    => 'Prêt Entreprise',
            'subtitle' => 'Le financement de votre ambition',
            'desc'     => 'Création, développement, trésorerie, équipement — KapitalStark accompagne les entrepreneurs et les PME avec des solutions de financement sur mesure, jusqu\'à 1 million d\'euros.',
            'rate_min' => '2.8',
            'rate_max' => '7.5',
            'amount_min' => '10 000 €',
            'amount_max' => '1 000 000 €',
            'duration_max' => '120 mois',
            'color'    => '#1A56B0',
            'subcategories' => [
                ['icon'=>'🚀','title'=>'Création d\'entreprise','desc'=>'Lancez votre activité avec un financement adapté à votre business plan.'],
                ['icon'=>'📈','title'=>'Développement','desc'=>'Financement de croissance, recrutement, expansion commerciale.'],
                ['icon'=>'💰','title'=>'Trésorerie','desc'=>'Faites face aux décalages de trésorerie avec une ligne de crédit souple.'],
                ['icon'=>'⚙️','title'=>'Équipement & Matériel','desc'=>'Machines, véhicules, matériel informatique — financement rapide.'],
            ],
            'documents' => ['Pièce d\'identité du dirigeant','Kbis de moins de 3 mois','2 derniers bilans comptables','Business plan (pour création)','RIB professionnel'],
            'faq' => [
                ['q'=>'Mon entreprise est-elle éligible ?','r'=>'Nous finançons tous types d\'entreprises : auto-entrepreneurs, SARL, SAS, PME. Un bilan d\'1 an minimum est nécessaire sauf création.'],
                ['q'=>'Quel est le délai de traitement ?','r'=>'Les dossiers entreprise sont traités en 48 à 72h. Pour les montants importants, un rendez-vous avec un conseiller est organisé.'],
                ['q'=>'Puis-je financer sans garantie personnelle ?','r'=>'Selon le montant et le profil de l\'entreprise, certains prêts ne nécessitent pas de caution personnelle.'],
            ],
        ],
        'agricole' => [
            'type'     => 'agricole',
            'icon'     => '🌾',
            'title'    => 'Prêt Agricole',
            'subtitle' => 'Cultivez votre réussite',
            'desc'     => 'Conçus avec les agriculteurs, pour les agriculteurs — nos solutions de financement agricole s\'adaptent aux contraintes saisonnières et aux spécificités du secteur.',
            'rate_min' => '2.3',
            'rate_max' => '5.5',
            'amount_min' => '5 000 €',
            'amount_max' => '500 000 €',
            'duration_max' => '15 ans',
            'color'    => '#267BF1',
            'subcategories' => [
                ['icon'=>'🚜','title'=>'Équipement agricole','desc'=>'Tracteurs, moissonneuses, matériel d\'irrigation — financement immédiat.'],
                ['icon'=>'🌍','title'=>'Achat foncier','desc'=>'Acquisition de terres agricoles avec des conditions adaptées.'],
                ['icon'=>'🌱','title'=>'Trésorerie saisonnière','desc'=>'Financement des intrants, semences, engrais en début de campagne.'],
                ['icon'=>'🏗','title'=>'Bâtiments d\'exploitation','desc'=>'Construction ou rénovation de hangars, étables, serres.'],
            ],
            'documents' => ['Pièce d\'identité','MSA ou SIRET','2 derniers bilans / comptes de gestion','Relevés de compte (6 mois)','Plan d\'exploitation'],
            'faq' => [
                ['q'=>'Proposez-vous des remboursements saisonniers ?','r'=>'Oui, nous adaptons le calendrier de remboursement aux cycles de production : paiements en fin de récolte par exemple.'],
                ['q'=>'Les jeunes agriculteurs sont-ils éligibles ?','r'=>'Absolument. Nous avons des offres spéciales pour les installations aidées par la dotation jeune agriculteur (DJA).'],
                ['q'=>'Financez-vous l\'agriculture biologique ?','r'=>'Oui, avec des conditions préférentielles pour les exploitations certifiées bio ou en conversion.'],
            ],
        ],
        'microcredit' => [
            'type'     => 'microcredit',
            'icon'     => '🌱',
            'title'    => 'Microcrédit',
            'subtitle' => 'L\'inclusion financière pour tous',
            'desc'     => 'Le microcrédit KapitalStark est destiné aux personnes exclues du système bancaire traditionnel — demandeurs d\'emploi, allocataires RSA, micro-entrepreneurs — pour financer un projet de vie ou professionnel.',
            'rate_min' => '4.0',
            'rate_max' => '7.0',
            'amount_min' => '300 €',
            'amount_max' => '10 000 €',
            'duration_max' => '60 mois',
            'color'    => '#1A56B0',
            'subcategories' => [
                ['icon'=>'👤','title'=>'Microcrédit personnel','desc'=>'Permis de conduire, équipement, formation — pour retrouver l\'emploi.'],
                ['icon'=>'💡','title'=>'Microcrédit professionnel','desc'=>'Lancement de micro-activité, achat de stock, matériel de base.'],
            ],
            'documents' => ['Pièce d\'identité','Justificatif de domicile','Justificatif de revenus (CAF, Pôle emploi…)','Description du projet'],
            'faq' => [
                ['q'=>'Qui peut bénéficier du microcrédit ?','r'=>'Toute personne en difficulté d\'accès au crédit bancaire classique : chômeurs, allocataires RSA, personnes à revenus modestes.'],
                ['q'=>'Un accompagnement est-il prévu ?','r'=>'Oui, chaque bénéficiaire est suivi par un conseiller tout au long du remboursement pour l\'aider dans son projet.'],
                ['q'=>'Est-ce vraiment sans garantie ?','r'=>'Oui, le microcrédit ne nécessite pas de garantie classique. Il est accordé sur la base de votre projet et votre motivation.'],
            ],
        ],
    ];

    public function index(): mixed
    {
        return view('prets.index', ['loans' => $this->loans]);
    }

    public function show(Request $request, string $type): mixed
    {
        if (!array_key_exists($type, $this->loans)) {
            abort(404);
        }

        return view('prets.show', [
            'loan'  => $this->loans[$type],
            'loans' => $this->loans,
        ]);
    }
}
