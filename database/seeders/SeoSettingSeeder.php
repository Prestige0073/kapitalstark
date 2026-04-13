<?php
// Seeder : meta title, description et robots par type de page pour Google Search

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SeoSetting;

class SeoSettingSeeder extends Seeder
{
    public function run(): void
    {
        SeoSetting::truncate();

        $settings = [
            [
                'page_type'        => 'home',
                'meta_title'       => 'KapitalStark — Solutions de Prêt sur Mesure au Portugal',
                'meta_description' => 'Obtenez votre prêt immobilier, auto ou personnel au meilleur taux. Réponse en 24h, accompagnement personnalisé. Plus de 12 000 clients satisfaits.',
                'robots_directive' => 'index, follow',
                'keywords'         => 'prêt immobilier Portugal, crédit auto, prêt personnel, financement entreprise, KapitalStark',
            ],
            [
                'page_type'        => 'loans',
                'meta_title'       => 'Nos Solutions de Prêt — Immobilier, Auto, Personnel, Entreprise',
                'meta_description' => 'Découvrez toutes nos offres de financement : prêt immobilier, automobile, personnel, entreprise, agricole et microcrédit. Taux compétitifs, réponse rapide.',
                'robots_directive' => 'index, follow',
                'keywords'         => 'prêt immobilier, crédit automobile, prêt personnel, financement entreprise, microcrédit',
            ],
            [
                'page_type'        => 'loan_immobilier',
                'meta_title'       => 'Prêt Immobilier au Portugal — Dès 3,20 % TAEG | KapitalStark',
                'meta_description' => 'Financez votre bien immobilier avec KapitalStark. Taux dès 3,20 % TAEG, jusqu\'à 30 ans, réponse en 24h. Primo-accédants et investisseurs acceptés.',
                'robots_directive' => 'index, follow',
                'keywords'         => 'prêt immobilier Portugal, crédit immobilier taux, financement logement Lisboa, hypothèque Portugal',
            ],
            [
                'page_type'        => 'loan_automobile',
                'meta_title'       => 'Crédit Auto — Financement Véhicule Neuf & Occasion | KapitalStark',
                'meta_description' => 'Obtenez votre prêt automobile rapidement. Véhicules neufs et d\'occasion, taux dès 4,50 % TAEG, durée jusqu\'à 7 ans. Réponse en 24h.',
                'robots_directive' => 'index, follow',
                'keywords'         => 'crédit automobile Portugal, prêt voiture, financement véhicule occasion, LOA',
            ],
            [
                'page_type'        => 'loan_personnel',
                'meta_title'       => 'Prêt Personnel sans Justificatif — Jusqu\'à 75 000 € | KapitalStark',
                'meta_description' => 'Réalisez vos projets avec un prêt personnel flexible. Sans justificatif d\'utilisation, taux dès 5,90 % TAEG, réponse immédiate.',
                'robots_directive' => 'index, follow',
                'keywords'         => 'prêt personnel Portugal, crédit consommation, prêt sans justificatif, financement projet personnel',
            ],
            [
                'page_type'        => 'loan_entreprise',
                'meta_title'       => 'Prêt Professionnel PME/TPE — Financez votre Croissance | KapitalStark',
                'meta_description' => 'Solutions de financement professionnel pour PME, TPE et indépendants. Trésorerie, investissement, équipement. Décision rapide, accompagnement expert.',
                'robots_directive' => 'index, follow',
                'keywords'         => 'prêt entreprise Portugal, financement PME, crédit professionnel, investissement entreprise',
            ],
            [
                'page_type'        => 'loan_agricole',
                'meta_title'       => 'Prêt Agricole — Financez votre Exploitation | KapitalStark',
                'meta_description' => 'Financement dédié aux agriculteurs et exploitations agricoles. Matériel, foncier, trésorerie saisonnière. Conditions adaptées au secteur agricole.',
                'robots_directive' => 'index, follow',
                'keywords'         => 'prêt agricole Portugal, financement exploitation, crédit agriculteur',
            ],
            [
                'page_type'        => 'loan_microcredit',
                'meta_title'       => 'Microcrédit — Inclusion Financière dès 1 000 € | KapitalStark',
                'meta_description' => 'Accédez au crédit même sans historique bancaire. Microcrédit de 1 000 à 10 000 € pour lancer un projet, financer une formation ou faire face à l\'urgence.',
                'robots_directive' => 'index, follow',
                'keywords'         => 'microcrédit Portugal, inclusion financière, petit prêt sans banque, aide financière',
            ],
            [
                'page_type'        => 'simulator',
                'meta_title'       => 'Simulateur de Prêt Gratuit — Calculez vos Mensualités | KapitalStark',
                'meta_description' => 'Simulez votre prêt en ligne gratuitement. Calculez vos mensualités, votre capacité d\'emprunt et comparez les offres. Outil rapide et sans engagement.',
                'robots_directive' => 'index, follow',
                'keywords'         => 'simulateur prêt, calcul mensualités, capacité emprunt, simulateur crédit Portugal',
            ],
            [
                'page_type'        => 'faq',
                'meta_title'       => 'FAQ — Toutes vos Questions sur nos Prêts | KapitalStark',
                'meta_description' => 'Trouvez les réponses à vos questions : conditions de prêt, taux, éligibilité, documents requis, remboursement anticipé. Questions fréquentes KapitalStark.',
                'robots_directive' => 'index, follow',
                'keywords'         => 'questions prêt, FAQ crédit, conditions emprunt, eligibilité prêt Portugal',
            ],
            [
                'page_type'        => 'contact',
                'meta_title'       => 'Contactez KapitalStark — Conseillers Disponibles 6j/7',
                'meta_description' => 'Contactez nos conseillers par formulaire, téléphone ou en agence. Disponibles du lundi au samedi. Réponse garantie sous 24h.',
                'robots_directive' => 'index, follow',
                'keywords'         => 'contact KapitalStark, conseiller prêt, agence Lisboa Porto, rendez-vous prêt',
            ],
            [
                'page_type'        => 'about',
                'meta_title'       => 'À Propos de KapitalStark — 15 ans d\'Expertise Financière',
                'meta_description' => 'Découvrez KapitalStark : notre histoire, nos valeurs et notre engagement pour des solutions de financement accessibles et transparentes au Portugal.',
                'robots_directive' => 'index, follow',
                'keywords'         => 'KapitalStark avis, société financement Portugal, courtier crédit Lisboa',
            ],
            [
                'page_type'        => 'agencies',
                'meta_title'       => 'Nos Agences au Portugal — Lisboa, Porto, Coimbra, Braga, Faro',
                'meta_description' => '5 agences KapitalStark à votre service au Portugal. Prenez rendez-vous avec un conseiller près de chez vous ou consultez-nous en ligne.',
                'robots_directive' => 'index, follow',
                'keywords'         => 'agence prêt Lisboa, conseiller crédit Porto, KapitalStark adresse, bureau financement Portugal',
            ],
            [
                'page_type'        => 'blog',
                'meta_title'       => 'Blog Financier — Conseils Prêt & Investissement | KapitalStark',
                'meta_description' => 'Guides pratiques, analyses de marché et conseils d\'experts sur le crédit immobilier, l\'investissement locatif et la gestion patrimoniale au Portugal.',
                'robots_directive' => 'index, follow',
                'keywords'         => 'blog prêt immobilier, guide crédit Portugal, conseils investissement, actualité financière',
            ],
            [
                'page_type'        => 'landing',
                'meta_title'       => 'Demande de Prêt en Ligne | KapitalStark',
                'meta_description' => 'Faites votre demande de prêt en ligne. Réponse en 24h, sans engagement.',
                'robots_directive' => 'noindex, nofollow', // Landing pages hors SEO organique
                'keywords'         => null,
            ],
        ];

        foreach ($settings as $s) {
            SeoSetting::create($s);
        }
    }
}
