<?php
// Seeder : questions/réponses réelles pour Featured Snippets Google

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        Faq::truncate();

        $faqs = [

            // ── Conditions de prêt ────────────────────────────────────────────
            ['category' => 'conditions_pret', 'sort_order' => 1, 'page_slug' => null,
             'question' => 'Quel est le montant minimum et maximum d\'un prêt chez KapitalStark ?',
             'answer'   => 'KapitalStark propose des prêts à partir de 1 000 € jusqu\'à 500 000 € selon le type de financement. Pour un prêt immobilier, le montant peut atteindre 1 000 000 €. Le montant accordé dépend de votre capacité de remboursement, de vos revenus et de la valeur du bien financé.'],

            ['category' => 'conditions_pret', 'sort_order' => 2, 'page_slug' => null,
             'question' => 'Quelle est la durée maximale d\'un prêt immobilier ?',
             'answer'   => 'La durée d\'un prêt immobilier chez KapitalStark peut aller jusqu\'à 30 ans (360 mois). Pour les prêts personnels, la durée maximale est de 7 ans. Pour les prêts automobiles, elle est de 7 ans également. La durée optimale dépend du montant emprunté et de vos mensualités souhaitées.'],

            ['category' => 'conditions_pret', 'sort_order' => 3, 'page_slug' => null,
             'question' => 'Puis-je obtenir un prêt sans apport personnel ?',
             'answer'   => 'Il est possible d\'obtenir un prêt sans apport dans certaines conditions, notamment pour les primo-accédants et les profils disposant de revenus stables. Cependant, un apport personnel de 10 à 20 % améliore significativement les conditions du prêt (taux, durée, garanties). Nos conseillers étudient chaque dossier individuellement.'],

            ['category' => 'conditions_pret', 'sort_order' => 4, 'page_slug' => 'prets/immobilier',
             'question' => 'Quelles sont les conditions pour obtenir un prêt immobilier ?',
             'answer'   => 'Pour obtenir un prêt immobilier chez KapitalStark, vous devez : avoir des revenus réguliers (CDI, revenus fonciers ou profession libérale), présenter un taux d\'endettement inférieur à 35 %, fournir un apport idéalement de 10 à 20 %, avoir un historique de crédit sain et être majeur. Les non-résidents peuvent également déposer un dossier sous conditions.'],

            ['category' => 'conditions_pret', 'sort_order' => 5, 'page_slug' => 'prets/personnel',
             'question' => 'Un prêt personnel nécessite-t-il un justificatif d\'utilisation ?',
             'answer'   => 'Non, le prêt personnel KapitalStark est un crédit à la consommation sans affectation obligatoire. Vous n\'avez pas à justifier l\'utilisation des fonds (voyages, travaux, mariage, achat de matériel, etc.). La seule exigence est de démontrer votre capacité de remboursement à travers vos revenus et charges actuelles.'],

            // ── Taux d'intérêt ────────────────────────────────────────────────
            ['category' => 'taux_interet', 'sort_order' => 1, 'page_slug' => null,
             'question' => 'Quels sont les taux d\'intérêt pratiqués par KapitalStark ?',
             'answer'   => 'Les taux de KapitalStark varient selon le type de prêt : prêt immobilier dès 3,20 % TAEG, prêt automobile dès 4,50 % TAEG, prêt personnel dès 5,90 % TAEG, prêt entreprise dès 4,80 % TAEG. Ces taux sont indicatifs et dépendent de votre profil, de la durée et du montant. Utilisez notre simulateur pour obtenir une estimation personnalisée.'],

            ['category' => 'taux_interet', 'sort_order' => 2, 'page_slug' => null,
             'question' => 'Quelle est la différence entre taux fixe et taux variable ?',
             'answer'   => 'Un taux fixe reste identique pendant toute la durée du prêt : vos mensualités sont constantes et prévisibles. Un taux variable évolue selon un indice de référence (Euribor) : il peut baisser ou augmenter. KapitalStark propose principalement des prêts à taux fixe pour protéger nos clients des hausses de taux. Le taux variable est réservé aux profils éligibles souhaitant profiter d\'éventuelles baisses.'],

            ['category' => 'taux_interet', 'sort_order' => 3, 'page_slug' => null,
             'question' => 'Qu\'est-ce que le TAEG et comment est-il calculé ?',
             'answer'   => 'Le TAEG (Taux Annuel Effectif Global) inclut le taux d\'intérêt nominal plus tous les frais annexes obligatoires : frais de dossier, assurance emprunteur, frais de garantie. C\'est le coût réel de votre crédit. Il permet de comparer objectivement les offres entre établissements. Chez KapitalStark, le TAEG est toujours affiché de façon transparente avant signature.'],

            ['category' => 'taux_interet', 'sort_order' => 4, 'page_slug' => 'prets/immobilier',
             'question' => 'Comment obtenir le meilleur taux pour mon prêt immobilier ?',
             'answer'   => 'Pour obtenir le meilleur taux immobilier : constituez un apport d\'au moins 20 %, maintenez un taux d\'endettement inférieur à 30 %, présentez un dossier complet et soigné, choisissez une durée courte (15-20 ans), et optez pour la domiciliation de vos revenus. KapitalStark négocie directement avec ses partenaires pour vous obtenir les conditions les plus avantageuses.'],

            // ── Éligibilité ───────────────────────────────────────────────────
            ['category' => 'eligibilite', 'sort_order' => 1, 'page_slug' => null,
             'question' => 'Qui peut faire une demande de prêt chez KapitalStark ?',
             'answer'   => 'Toute personne majeure (18 ans ou plus) résidant au Portugal peut déposer une demande. KapitalStark étudie les dossiers des salariés en CDI, fonctionnaires, indépendants, professions libérales, entrepreneurs et retraités. Les non-résidents portugais peuvent également être éligibles selon conditions. Un fichage actif à la Banco de Portugal (liste noire) peut entrainer un refus.'],

            ['category' => 'eligibilite', 'sort_order' => 2, 'page_slug' => null,
             'question' => 'Mon dossier sera-t-il accepté si je suis en CDD ou freelance ?',
             'answer'   => 'Oui, KapitalStark étudie les dossiers des profils en CDD et freelance. Pour un CDD, il faut généralement justifier d\'au moins 12 mois d\'ancienneté dans le même secteur. Pour les freelances et indépendants, 2 années d\'activité avec bilans positifs sont requises. Des garanties supplémentaires (caution, hypothèque) peuvent être demandées pour sécuriser le dossier.'],

            ['category' => 'eligibilite', 'sort_order' => 3, 'page_slug' => null,
             'question' => 'Quel taux d\'endettement maximum est accepté ?',
             'answer'   => 'Le taux d\'endettement maximum accepté est de 35 % des revenus nets (charges mensuelles totales / revenus nets). Au-delà, le risque de surendettement est jugé trop élevé. Cependant, des exceptions sont possibles pour les dossiers présentant un fort reste à vivre, un apport important ou des garanties supplémentaires solides.'],

            ['category' => 'eligibilite', 'sort_order' => 4, 'page_slug' => 'prets/automobile',
             'question' => 'Puis-je financer un véhicule d\'occasion avec un prêt auto KapitalStark ?',
             'answer'   => 'Oui, KapitalStark finance les véhicules neufs et d\'occasion. Pour un véhicule d\'occasion, il doit avoir moins de 10 ans au terme du crédit et être acheté chez un professionnel ou entre particuliers. Le montant financé ne peut pas dépasser la valeur Argus du véhicule. Un justificatif d\'achat (bon de commande ou facture) sera demandé.'],

            // ── Remboursement ─────────────────────────────────────────────────
            ['category' => 'remboursement', 'sort_order' => 1, 'page_slug' => null,
             'question' => 'Est-il possible de rembourser mon prêt par anticipation ?',
             'answer'   => 'Oui, le remboursement anticipé est possible à tout moment, partiellement ou en totalité. Pour les prêts immobiliers, des indemnités de remboursement anticipé (IRA) peuvent s\'appliquer : elles sont plafonnées à 3 % du capital restant dû ou 6 mois d\'intérêts selon le code de la consommation. Pour les prêts personnels et auto, le remboursement anticipé est gratuit si le montant est inférieur à 10 000 €.'],

            ['category' => 'remboursement', 'sort_order' => 2, 'page_slug' => null,
             'question' => 'Que se passe-t-il si je ne peux pas payer une mensualité ?',
             'answer'   => 'En cas de difficulté ponctuelle, contactez votre conseiller KapitalStark dès que possible. Nous proposons des solutions : report d\'échéance (1 à 3 mois), modulation des mensualités à la baisse, rééchelonnement du prêt. L\'assurance emprunteur peut prendre en charge les échéances en cas de perte d\'emploi, invalidité ou décès. Agissez avant tout incident de paiement.'],

            ['category' => 'remboursement', 'sort_order' => 3, 'page_slug' => null,
             'question' => 'Puis-je moduler mes mensualités pendant le prêt ?',
             'answer'   => 'Oui, KapitalStark offre la possibilité de moduler vos mensualités à la hausse ou à la baisse (dans les limites du contrat) en cas de changement de situation. Une augmentation des mensualités réduit la durée et le coût total. Une diminution allonge la durée. Cette option est généralement disponible une fois par an après la 1ère année, sur simple demande auprès de votre conseiller.'],

            // ── Documents requis ──────────────────────────────────────────────
            ['category' => 'documents_requis', 'sort_order' => 1, 'page_slug' => null,
             'question' => 'Quels documents dois-je fournir pour une demande de prêt ?',
             'answer'   => 'Les documents standard sont : pièce d\'identité valide (passeport ou carte de séjour), 3 derniers bulletins de salaire, 2 derniers avis d\'imposition, 3 derniers relevés de compte bancaire, justificatif de domicile de moins de 3 mois. Pour un prêt immobilier, ajoutez le compromis de vente ou avant-contrat. Pour les indépendants : 2 derniers bilans comptables + attestation expert-comptable.'],

            ['category' => 'documents_requis', 'sort_order' => 2, 'page_slug' => null,
             'question' => 'Combien de temps faut-il pour traiter mon dossier de prêt ?',
             'answer'   => 'Le délai de traitement est : 24h pour une réponse de principe après soumission du dossier en ligne, 48 à 72h pour une offre définitive une fois le dossier complet, 7 à 15 jours pour le déblocage des fonds (prêt personnel), 3 à 4 semaines pour un prêt immobilier (délais légaux inclus). Un dossier complet et bien préparé accélère considérablement le processus.'],

            ['category' => 'documents_requis', 'sort_order' => 3, 'page_slug' => 'prets/entreprise',
             'question' => 'Quels documents spécifiques sont nécessaires pour un prêt entreprise ?',
             'answer'   => 'Pour un prêt professionnel, fournissez : extrait Kbis de moins de 3 mois, 3 derniers bilans et comptes de résultat, liasse fiscale, prévisionnel financier sur 3 ans, relevés de compte professionnel des 3 derniers mois, statuts de la société, pièce d\'identité du dirigeant. Un business plan solide et des projections réalistes renforcent la décision favorable.'],
        ];

        foreach ($faqs as $faq) {
            Faq::create(array_merge($faq, ['is_published' => true]));
        }
    }
}
