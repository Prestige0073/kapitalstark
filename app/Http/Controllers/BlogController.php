<?php

namespace App\Http\Controllers;

class BlogController extends Controller
{
    private array $articles = [
        [
            'slug'    => 'meilleur-taux-pret-immobilier-2025',
            'tag'     => 'Immobilier',
            'title'   => 'Comment obtenir le meilleur taux pour votre prêt immobilier en 2025 ?',
            'excerpt' => 'Les taux ont évolué significativement depuis 2023. Découvrez les stratégies des experts pour négocier votre taux et réduire le coût total de votre crédit immobilier.',
            'date'    => '12 mars 2025',
            'read'    => '8 min',
            'icon'    => '🏠',
            'author'  => 'Thomas Bernard — Conseiller Immobilier',
            'sections' => [
                [
                    'id'    => 'facteurs-influencent-taux',
                    'title' => 'Les facteurs qui influencent votre taux',
                    'body'  => '<p>Le taux d\'intérêt de votre prêt immobilier n\'est pas fixé arbitrairement : il résulte d\'une combinaison de facteurs liés à votre profil et aux conditions du marché. Comprendre ces leviers est la première étape pour agir dessus.</p><p>Les principaux critères analysés par les banques sont : votre <strong>taux d\'endettement</strong> (doit être inférieur à 35%), le rapport <strong>prêt/valeur du bien</strong> (LTV), la stabilité de vos revenus (CDI, statut de la fonction publique, ancienneté), et votre <strong>comportement bancaire</strong> (absence de découverts, épargne régulière).</p><ul><li>Un apport ≥ 10% réduit significativement le taux proposé</li><li>Un CDI de plus de 3 ans est fortement valorisé</li><li>L\'absence d\'incidents bancaires sur les 3 dernières années est indispensable</li></ul>',
                ],
                [
                    'id'    => 'soigner-dossier',
                    'title' => 'Soigner votre dossier avant de déposer',
                    'body'  => '<p>Un dossier solide se prépare plusieurs mois à l\'avance. La première action est de <strong>réduire vos crédits en cours</strong> : un crédit à la consommation remboursé avant de déposer votre demande améliore instantanément votre taux d\'endettement.</p><p>Constituez une épargne visible sur vos relevés : 3 à 6 mois de mensualités en réserve rassure considérablement le banquier. Cette épargne "de précaution" montre votre capacité à faire face aux imprévus.</p><ul><li>Évitez tout découvert dans les 3 mois précédant la demande</li><li>Préparez justificatifs de revenus, avis d\'imposition, relevés bancaires 3 derniers mois</li><li>Un apport d\'au moins 10% couvre les frais notariaux et rassure le prêteur</li></ul>',
                ],
                [
                    'id'    => 'comparer-negocier',
                    'title' => 'Comparer les offres et négocier efficacement',
                    'body'  => '<p>Ne vous contentez jamais de la première offre reçue. Les banques ont des politiques de taux différentes selon leurs objectifs commerciaux du trimestre. En consultant au minimum 3 à 5 établissements, vous maximisez vos chances d\'obtenir le meilleur taux.</p><p>Faire appel à un <strong>courtier en crédit immobilier</strong> (IOBSP) comme KapitalStark vous donne accès à un réseau de partenaires bancaires et à une expertise de négociation. Statistiquement, un dossier présenté par un courtier obtient un taux 0,10 à 0,30 % inférieur à un dossier en direct.</p><p>N\'hésitez pas à mettre les banques en concurrence explicitement : mentionner une offre concurrente lors de la négociation peut faire baisser le taux de 0,05 à 0,15 %.</p>',
                ],
                [
                    'id'    => 'frais-ne-pas-negliger',
                    'title' => 'Les frais à ne pas négliger dans le coût total',
                    'body'  => '<p>Le TAEG (Taux Annuel Effectif Global) est le seul indicateur de comparaison fiable : il intègre le taux nominal, les frais de dossier, l\'assurance emprunteur et les frais de garantie. Deux offres avec le même taux nominal peuvent avoir des TAEG très différents selon l\'assurance proposée.</p><p>L\'assurance emprunteur représente souvent <strong>30 à 40% du coût total du crédit</strong>. Depuis la loi Lemoine (2022), vous pouvez changer d\'assurance à tout moment sans frais. Déléguer votre assurance à un assureur externe peut faire économiser jusqu\'à 50% sur ce poste.</p><ul><li>Frais de dossier bancaires : 500 à 1 500 € selon les établissements (négociable)</li><li>Frais de garantie (caution ou hypothèque) : 0,5 à 2% du capital</li><li>Frais de notaire : 7 à 8% dans l\'ancien, 2 à 3% dans le neuf</li></ul>',
                ],
            ],
        ],
        [
            'slug'    => 'taux-endettement-guide-complet',
            'tag'     => 'Finance',
            'title'   => 'Taux d\'endettement : le guide complet 2025',
            'excerpt' => 'Le taux d\'endettement est un critère central dans l\'analyse de votre dossier de prêt. Comprendre son calcul et comment l\'optimiser peut faire la différence.',
            'date'    => '5 mars 2025',
            'read'    => '5 min',
            'icon'    => '📊',
            'author'  => 'Marc Dumont — Directeur des Risques',
            'sections' => [
                [
                    'id'    => 'definition-taux-endettement',
                    'title' => 'Qu\'est-ce que le taux d\'endettement ?',
                    'body'  => '<p>Le taux d\'endettement (ou taux d\'effort) mesure la part de vos revenus nets mensuels consacrée au remboursement de vos crédits. Il s\'exprime en pourcentage et est calculé par la formule :<br><strong>Taux d\'endettement = (total des mensualités / revenus nets) × 100</strong></p><p>Depuis janvier 2022, le Haut Conseil de Stabilité Financière (HCSF) impose aux banques de ne pas dépasser <strong>35%</strong> de taux d\'endettement (assurance comprise) pour l\'octroi de crédit. Cette règle a force réglementaire : un dépassement expose la banque à des sanctions de l\'ACPR.</p>',
                ],
                [
                    'id'    => 'calcul-exemple',
                    'title' => 'Comment calculer son taux d\'endettement ?',
                    'body'  => '<p>Prenons un exemple concret. M. et Mme Dupont ont des revenus nets mensuels de 5 200 €. Ils remboursent déjà un crédit auto de 350 €/mois. Ils souhaitent emprunter pour acheter leur résidence principale avec une mensualité de 1 200 €.</p><p>Calcul : (350 + 1 200) / 5 200 × 100 = <strong>29,8%</strong>. Leur dossier est dans les clous. La mensualité maximale autorisée serait de (5 200 × 35%) - 350 = <strong>1 470 €</strong>.</p><ul><li><strong>Revenus pris en compte :</strong> salaires nets, revenus locatifs (à 70%), retraites, allocations pérennes</li><li><strong>Charges prises en compte :</strong> tous les crédits en cours, loyer si locataire, pensions alimentaires versées</li><li><strong>Non pris en compte :</strong> charges courantes (alimentation, énergie, loisirs)</li></ul>',
                ],
                [
                    'id'    => 'optimiser-taux',
                    'title' => 'Optimiser son taux d\'endettement',
                    'body'  => '<p>Si votre taux d\'endettement dépasse 35%, plusieurs stratégies existent. La plus efficace est le <strong>remboursement anticipé d\'un crédit en cours</strong> : en soldant un crédit à la consommation avant de déposer votre demande, vous libérez immédiatement de la capacité d\'emprunt.</p><p>Autre levier : le <strong>rachat de crédits</strong>. En regroupant plusieurs crédits en un seul à mensualité réduite, vous abaissez mécaniquement votre taux d\'endettement. Attention cependant : le coût total du crédit augmente avec la durée.</p><p>En dernier recours, l\'ajout d\'un <strong>co-emprunteur</strong> (conjoint, parent) permet d\'additionner les revenus et donc d\'augmenter la capacité d\'emprunt totale.</p>',
                ],
                [
                    'id'    => 'exceptions-regles',
                    'title' => 'Les exceptions à la règle des 35%',
                    'body'  => '<p>La réglementation HCSF prévoit une dérogation de <strong>20%</strong> de la production trimestrielle de crédits : les banques peuvent donc financer un certain nombre de dossiers au-delà de 35%. Ces dérogations sont prioritairement accordées pour les primo-accédants et les investissements locatifs.</p><p>Des revenus élevés ou un <strong>reste-à-vivre confortable</strong> peuvent également convaincre un banquier d\'utiliser sa marge de flexibilité. Un ménage gagnant 10 000 €/mois avec 40% d\'endettement dispose de 6 000 € de reste-à-vivre, soit plus qu\'un ménage à 3 000 €/mois avec 30% (2 100 €).</p>',
                ],
            ],
        ],
        [
            'slug'    => 'loa-vs-pret-auto',
            'tag'     => 'Automobile',
            'title'   => 'LOA ou prêt auto : que choisir pour financer votre voiture ?',
            'excerpt' => 'Location avec option d\'achat ou crédit classique ? Les deux solutions ont leurs avantages. On vous aide à faire le bon choix selon votre situation.',
            'date'    => '28 fév. 2025',
            'read'    => '6 min',
            'icon'    => '🚗',
            'author'  => 'Lucie Fontaine — Conseillère Auto & Personnel',
            'sections' => [
                [
                    'id'    => 'loa-expliquee',
                    'title' => 'La LOA (Location avec Option d\'Achat) expliquée',
                    'body'  => '<p>La LOA est un contrat de location longue durée (généralement 24 à 60 mois) qui vous donne la <strong>possibilité d\'acheter le véhicule à son terme</strong> pour un prix résiduel fixé à l\'avance. Vous payez des mensualités inférieures à un crédit classique, car vous ne remboursez que la dépréciation du véhicule, pas sa valeur totale.</p><p>Concrètement : pour une voiture à 30 000 €, avec un premier loyer de 3 000 € et 48 mensualités de 350 €, la valeur résiduelle pourrait être de 14 000 €. Si vous optez pour le rachat, vous aurez payé au total 33 800 € pour un véhicule valant 30 000 € à l\'achat.</p><ul><li><strong>Avantage :</strong> mensualités plus basses, accès à des véhicules récents</li><li><strong>Inconvénient :</strong> kilométrage limité contractuellement (frais de dépassement)</li><li><strong>Pour qui :</strong> conducteurs qui aiment changer régulièrement de voiture</li></ul>',
                ],
                [
                    'id'    => 'credit-auto-classique',
                    'title' => 'Le crédit automobile classique',
                    'body'  => '<p>Le crédit auto est un prêt affecté dont vous devenez propriétaire du véhicule dès l\'achat (ou après remboursement de la dernière mensualité selon le contrat). Les mensualités intègrent capital + intérêts, avec un TAEG moyen de 2,5 à 5% selon votre profil et la durée.</p><p>Sur 60 mois à 3% pour 27 000 € (apport de 3 000 €), la mensualité serait d\'environ 485 €, pour un coût total de 2 100 € d\'intérêts. Vous avez la propriété complète du véhicule, sans restriction de kilométrage.</p><ul><li><strong>Avantage :</strong> propriété immédiate, pas de limite kilométrique</li><li><strong>Inconvénient :</strong> mensualités plus élevées, vous subissez la dépréciation</li><li><strong>Pour qui :</strong> ceux qui roulent beaucoup ou conservent longtemps leur véhicule</li></ul>',
                ],
                [
                    'id'    => 'tableau-comparatif',
                    'title' => 'Comparaison LOA vs crédit auto',
                    'body'  => '<p>Pour un même véhicule à 30 000 € sur 48 mois :</p><ul><li><strong>LOA :</strong> premier loyer 3 000 € + 48 × 280 € = 16 440 € décaissés sur 4 ans, valeur résiduelle 14 500 € si rachat → Total propriétaire : 33 940 €</li><li><strong>Crédit :</strong> apport 3 000 € + 48 × 620 € = 32 760 € → Total propriétaire : 32 760 € pour un véhicule valant maintenant ~16 000 €</li></ul><p>La LOA est plus intéressante si vous <strong>ne rachetez pas le véhicule à terme</strong> et que vous le rendez simplement. En revanche, si vous le rachetez, le coût total est souvent supérieur au crédit direct. L\'avantage de la LOA réside dans la flexibilité et les mensualités plus faibles.</p>',
                ],
                [
                    'id'    => 'notre-recommandation',
                    'title' => 'Notre recommandation selon votre profil',
                    'body'  => '<p><strong>Choisissez la LOA si :</strong> vous changez de voiture tous les 3-4 ans, vous faites moins de 15 000 km/an, vous voulez toujours conduire un véhicule récent et sous garantie constructeur, ou si vous souhaitez maîtriser votre budget mensuel.</p><p><strong>Choisissez le crédit auto si :</strong> vous roulez beaucoup (> 20 000 km/an), vous conservez vos véhicules longtemps, vous souhaitez être propriétaire immédiatement pour la revente, ou vous avez un usage professionnel du véhicule.</p><p>Notre conseil : simulez les deux options avec votre kilométrage réel et la durée de conservation envisagée. Chez KapitalStark, nos conseillers peuvent comparer les deux formules avec vos données réelles.</p>',
                ],
            ],
        ],
        [
            'slug'    => 'microcredit-inclusion-financiere',
            'tag'     => 'Inclusion',
            'title'   => 'Microcrédit : une chance pour les exclus du système bancaire',
            'excerpt' => 'Chômage, RSA, faibles revenus… le microcrédit ouvre des portes. Découvrez comment en bénéficier et quels projets il peut financer.',
            'date'    => '20 fév. 2025',
            'read'    => '7 min',
            'icon'    => '🌱',
            'author'  => 'Fatima Benali — Conseillère Microcrédit',
            'sections' => [
                [
                    'id'    => 'qui-peut-beneficier',
                    'title' => 'Qui peut bénéficier du microcrédit ?',
                    'body'  => '<p>Le microcrédit s\'adresse aux personnes <strong>exclues du système bancaire classique</strong> : personnes en situation de précarité, bénéficiaires du RSA ou de l\'ASS, chômeurs de longue durée, personnes en situation de surendettement résolu, travailleurs informels ou sans CDI.</p><p>La condition fondamentale n\'est pas d\'avoir un revenu élevé, mais de pouvoir démontrer la <strong>viabilité de votre projet</strong> et votre capacité de remboursement, même modeste. Les organismes de microcrédit évaluent l\'homme ou la femme derrière le dossier, pas seulement les chiffres.</p><ul><li>Montants : de 300 € à 12 000 € pour le microcrédit personnel, jusqu\'à 25 000 € pour le professionnel</li><li>Taux : généralement entre 4,5% et 7,5% TAEG</li><li>Durée : 6 mois à 5 ans selon le projet</li></ul>',
                ],
                [
                    'id'    => 'types-de-microcredit',
                    'title' => 'Les deux types de microcrédit',
                    'body'  => '<p>Le <strong>microcrédit personnel</strong> finance des besoins courants liés à l\'insertion ou au maintien dans l\'emploi : achat d\'un véhicule pour aller travailler, formation professionnelle, équipement informatique, caution logement, équipement du foyer essentiel. L\'objectif est de lever un obstacle concret à l\'emploi ou à la dignité.</p><p>Le <strong>microcrédit professionnel</strong> (ou microcrédit entrepreneurial) finance la création ou le développement d\'une très petite entreprise (TPE). Il est souvent accompagné d\'un suivi personnalisé par un réseau associatif (Adie, France Active, Réseau Entreprendre). En France, 60 000 micros-entreprises sont créées chaque année grâce à ce dispositif.</p>',
                ],
                [
                    'id'    => 'faire-une-demande',
                    'title' => 'Comment faire une demande de microcrédit ?',
                    'body'  => '<p>La demande de microcrédit passe généralement par un <strong>accompagnateur social ou associatif</strong> (CCAS, association, travailleur social) qui instruit le dossier et le présente à l\'établissement de crédit partenaire. Ce n\'est pas une démarche purement bancaire mais un parcours d\'accompagnement.</p><p>Les étapes typiques : 1) Premier entretien avec l\'accompagnateur 2) Évaluation du projet et de la situation 3) Montage du dossier (pièces d\'identité, justificatifs revenus/charges, description du projet) 4) Présentation à la commission 5) Réponse sous 15-30 jours 6) Déblocage des fonds + suivi pendant la durée du crédit.</p><ul><li>KapitalStark est partenaire de l\'Adie et de France Active</li><li>Premiers fonds débloqués généralement en 2 à 4 semaines après accord</li><li>Un référent KapitalStark vous accompagne pendant toute la durée du remboursement</li></ul>',
                ],
                [
                    'id'    => 'partenaires-france',
                    'title' => 'Les partenaires clés du microcrédit en France',
                    'body'  => '<p>L\'<strong>Adie (Association pour le Droit à l\'Initiative Économique)</strong> est le principal opérateur du microcrédit professionnel en France, avec 15 000 microcrédits accordés par an. Elle accompagne les créateurs d\'entreprise qui n\'ont pas accès au crédit bancaire classique.</p><p><strong>France Active</strong> soutient les entreprises solidaires et les entrepreneurs en insertion. La <strong>Croix-Rouge Française</strong> gère le microcrédit personnel pour les ménages fragiles. Les <strong>CCAS communaux</strong> sont souvent le premier interlocuteur pour identifier le bon dispositif.</p><p>Chez KapitalStark, notre équipe microcrédit vous oriente vers le dispositif le plus adapté à votre situation, gratuitement et sans engagement.</p>',
                ],
            ],
        ],
        [
            'slug'    => 'pret-entreprise-creation',
            'tag'     => 'Entreprise',
            'title'   => 'Créer son entreprise : quels financements disponibles en 2025 ?',
            'excerpt' => 'BPI, prêt bancaire, love money, crowdfunding… tour d\'horizon des solutions pour financer la création de votre entreprise.',
            'date'    => '14 fév. 2025',
            'read'    => '9 min',
            'icon'    => '🚀',
            'author'  => 'Pierre Garnier — Conseiller Entreprises',
            'sections' => [
                [
                    'id'    => 'aides-publiques',
                    'title' => 'Les aides publiques : BPI, ACRE, NACRE',
                    'body'  => '<p>La <strong>BPI France</strong> (Banque Publique d\'Investissement) est un acteur incontournable du financement de la création d\'entreprise. Elle propose des prêts participatifs sans garantie (Prêt d\'Honneur), des garanties bancaires (jusqu\'à 70% du prêt), et des co-investissements en fonds propres.</p><p>L\'<strong>ACRE (Aide à la Création et Reprise d\'Entreprise)</strong> vous exonère partiellement de cotisations sociales pendant la première année d\'activité. Le dispositif <strong>NACRE</strong> (Nouvel Accompagnement pour la Création et Reprise d\'Entreprise) propose un prêt à taux zéro de 1 000 à 8 000 € adossé à un prêt bancaire.</p><ul><li>Prêt d\'Honneur BPI : 5 000 à 80 000 € sans intérêts ni garantie personnelle</li><li>Garantie BPI : permet d\'obtenir un prêt bancaire sans apport ni caution personnelle</li><li>Prêt BPI Création : jusqu\'à 200 000 € avec garantie couvrant 50 à 60% du crédit</li></ul>',
                ],
                [
                    'id'    => 'pret-bancaire-professionnel',
                    'title' => 'Le prêt bancaire professionnel',
                    'body'  => '<p>Le prêt bancaire reste la colonne vertébrale du financement de la création d\'entreprise. Pour l\'obtenir, vous devez présenter un <strong>business plan solide</strong> avec projections financières sur 3 ans, justifier d\'un apport personnel (en général 20 à 30% du besoin de financement), et souvent fournir une garantie (caution personnelle, hypothèque ou garantie BPI).</p><p>Les banques évaluent principalement la viabilité économique du projet, la cohérence entre les compétences du porteur et le secteur, et la solidité du plan de financement. Un accompagnement par une CCI, une CMA ou un cabinet spécialisé renforce considérablement le dossier.</p><ul><li>Taux : EURIBOR + marge (actuellement 3,5 à 6% selon profil)</li><li>Durée : 3 à 7 ans pour le matériel, jusqu\'à 15 ans pour l\'immobilier professionnel</li><li>Délai de réponse : 2 à 6 semaines après dépôt du dossier complet</li></ul>',
                ],
                [
                    'id'    => 'financement-alternatif',
                    'title' => 'Les financements alternatifs (crowdfunding, love money)',
                    'body'  => '<p>Le <strong>crowdfunding (financement participatif)</strong> connaît une croissance significative : 2,5 milliards d\'euros levés en France en 2024. Les principales plateformes (Ulule, Kickstarter, Lita.co, WiSEED) permettent de lever des fonds auprès du grand public, soit sous forme de dons avec contrepartie (crowdfunding récompense), soit de prêt (crowdlending), soit d\'investissement en capital (equity crowdfunding).</p><p>Le <strong>love money</strong> désigne les investissements de l\'entourage (famille, amis). Il peut prendre la forme de prêts familiaux (à déclarer aux impôts au-delà de 5 000 €), d\'apports en capital, ou de prêts participatifs. Le dispositif <strong>IR-PME</strong> permet aux investisseurs de déduire 25% de leur investissement de leur impôt sur le revenu.</p>',
                ],
                [
                    'id'    => 'structurer-plan-financement',
                    'title' => 'Structurer son plan de financement',
                    'body'  => '<p>Un plan de financement équilibré combine généralement plusieurs sources : <strong>fonds propres</strong> (apport personnel, love money) + <strong>dettes bancaires</strong> (prêt bancaire + crédit-bail) + <strong>aides publiques</strong> (Prêt d\'Honneur, NACRE, subventions régionales). La règle empirique est de couvrir 30 à 40% du besoin total par des fonds propres.</p><p>L\'erreur classique est de se focaliser sur un seul type de financement. Un plan mixte rassure davantage les banques (qui voient que le porteur a d\'autres partenaires) et réduit le risque global. Nos conseillers KapitalStark vous aident à identifier et combiner les dispositifs les plus adaptés à votre projet et votre secteur.</p>',
                ],
            ],
        ],
        [
            'slug'    => 'pret-immobilier-guide-complet',
            'tag'     => 'Immobilier',
            'title'   => 'Prêt immobilier : tout comprendre avant de se lancer',
            'excerpt' => 'TAEG, apport, assurance, durée… maîtrisez tous les concepts clés pour choisir le meilleur financement immobilier et éviter les erreurs coûteuses.',
            'date'    => '3 janv. 2025',
            'read'    => '12 min',
            'icon'    => '🏡',
            'author'  => 'Thomas Bernard — Conseiller Immobilier',
            'sections' => [
                [
                    'id'    => 'types-de-prets',
                    'title' => 'Les différents types de prêts immobiliers',
                    'body'  => '<p>Il n\'existe pas un seul prêt immobilier mais une gamme de produits adaptés à chaque situation. Le <strong>prêt amortissable classique</strong> est le plus courant : chaque mensualité rembourse une part de capital et des intérêts calculés sur le capital restant dû. En début de prêt, la majeure partie de la mensualité est constituée d\'intérêts ; en fin de prêt, l\'inverse.</p><p>Le <strong>Prêt à Taux Zéro (PTZ)</strong> est réservé aux primo-accédants sous conditions de ressources. Il finance jusqu\'à 40% du prix d\'achat dans le neuf (ou ancien avec travaux dans certaines zones) sans intérêts. Le PTZ ne peut pas être souscrit seul : il complète un prêt principal.</p><ul><li><strong>Prêt à taux fixe :</strong> mensualités constantes, visibilité totale sur le coût final — recommandé dans 90% des cas</li><li><strong>Prêt à taux variable :</strong> indexé sur l\'Euribor, risqué en période de hausse des taux</li><li><strong>Prêt in fine :</strong> remboursement du capital en une seule fois à terme, pour investisseurs locatifs uniquement</li></ul>',
                ],
                [
                    'id'    => 'comprendre-taeg',
                    'title' => 'Comprendre le TAEG et le coût réel de votre crédit',
                    'body'  => '<p>Le <strong>Taux Annuel Effectif Global (TAEG)</strong> est l\'unique indicateur de comparaison fiable entre plusieurs offres. Contrairement au taux nominal, le TAEG intègre la totalité des frais obligatoires : intérêts, frais de dossier, frais de garantie et <strong>assurance emprunteur</strong>.</p><p>L\'assurance représente souvent 30 à 40% du coût total du crédit — un poste considérable que beaucoup d\'emprunteurs sous-estiment. Sur un prêt de 200 000 € à 2% sur 20 ans, les intérêts s\'élèvent à environ 43 000 €, mais l\'assurance peut ajouter 20 000 à 30 000 € supplémentaires selon la formule choisie.</p><ul><li>Comparez toujours le <strong>coût total du crédit</strong> (TAEG × durée), pas seulement le taux nominal</li><li>Les frais de notaire (7-8% dans l\'ancien) ne sont pas inclus dans le TAEG mais constituent un coût réel</li><li>Les frais de garantie (caution Crédit Logement vs hypothèque) varient de 0,5 à 2% du capital</li></ul>',
                ],
                [
                    'id'    => 'apport-et-assurance',
                    'title' => 'L\'apport personnel et le choix de l\'assurance',
                    'body'  => '<p>L\'apport personnel a un double rôle : couvrir les frais annexes (notaire, garantie, dossier) et rassurer la banque sur votre capacité d\'épargne. Un apport de <strong>10% minimum</strong> est généralement exigé, mais 20% ou plus vous permet d\'obtenir un taux significativement meilleur.</p><p>L\'<strong>assurance emprunteur</strong> couvre le remboursement du prêt en cas de décès, d\'invalidité (PTIA/IPT/IPP) et d\'incapacité de travail (ITT). Depuis la <strong>loi Lemoine de 2022</strong>, vous pouvez changer d\'assurance à tout moment sans frais ni pénalités. La délégation d\'assurance (souscrire chez un assureur externe) permet d\'économiser 0,10 à 0,30% de TAEG, soit plusieurs dizaines de milliers d\'euros sur la durée du prêt.</p><ul><li>Comparez les garanties (équivalence de niveau de garantie exigée)</li><li>Attention aux exclusions : sports à risques, maladies préexistantes, zone de guerre</li><li>Les jeunes emprunteurs ont tout intérêt à déléguer : les tarifs des assureurs alternatifs peuvent être 3 à 5× moins chers</li></ul>',
                ],
                [
                    'id'    => 'bien-choisir-son-offre',
                    'title' => 'Comment bien choisir son offre de prêt',
                    'body'  => '<p>Une fois les offres reçues, vous disposez d\'un <strong>délai légal de réflexion de 10 jours minimum</strong> (loi Scrivener) avant de pouvoir accepter. Utilisez ce délai pour comparer méticuleusement les TAEG, les conditions de remboursement anticipé, la modularité des mensualités et les garanties.</p><p>Faire appel à un <strong>courtier en crédit immobilier</strong> vous donne accès à un réseau bancaire plus large et à une expertise de négociation. Les courtiers sont rémunérés par la banque (honoraires inclus dans les frais de dossier) et ne vous coûtent donc rien en général. En contrepartie, ils vous accompagnent de la simulation au déblocage des fonds.</p><p>Chez KapitalStark, notre processus est entièrement digital : déposez votre dossier en ligne, recevez vos offres comparées sous 48h, et signez électroniquement depuis votre espace client.</p>',
                ],
            ],
        ],
        [
            'slug'    => 'investissement-locatif-guide',
            'tag'     => 'Immobilier',
            'title'   => 'Investissement locatif : financer et rentabiliser votre patrimoine',
            'excerpt' => 'Dispositifs Pinel, LMNP, rendement locatif brut et net, fiscalité… notre guide complet pour l\'investisseur immobilier qui cherche à financer intelligemment.',
            'date'    => '18 jan. 2025',
            'read'    => '14 min',
            'icon'    => '🔑',
            'author'  => 'Marc Dumont — Directeur des Risques',
            'sections' => [
                [
                    'id'    => 'rendement-locatif',
                    'title' => 'Calculer le rendement locatif réel',
                    'body'  => '<p>Le <strong>rendement locatif brut</strong> est calculé simplement : (loyer annuel / prix d\'achat) × 100. Un appartement à 150 000 € loué 700 €/mois génère un rendement brut de (8 400 / 150 000) × 100 = <strong>5,6%</strong>. Mais ce chiffre est trompeur.</p><p>Le <strong>rendement locatif net</strong> déduit les charges réelles : taxe foncière, charges de copropriété non récupérables, assurance PNO, frais de gestion locative (7-10% des loyers), provisions pour travaux et vacance locative. Le rendement net est généralement inférieur de 1,5 à 2,5 points au brut. Dans notre exemple, le net serait plutôt de 3 à 4%.</p><ul><li>Rendement net-net : après impôts, en régime réel ou micro-foncier</li><li>Zone de vigilance : rendements > 8% brut peuvent indiquer une forte vacance locative ou des travaux importants</li><li>La valeur du bien à terme (plus-value potentielle) s\'ajoute à la rentabilité globale de l\'opération</li></ul>',
                ],
                [
                    'id'    => 'dispositifs-fiscaux',
                    'title' => 'Les dispositifs fiscaux : Pinel, LMNP, Malraux',
                    'body'  => '<p>Le <strong>dispositif Pinel</strong> (prolongé jusqu\'en décembre 2024 puis transformé en Pinel+) offre une réduction d\'impôt de 9 à 14% du prix d\'achat en contrepartie d\'un engagement de location de 6 à 12 ans à loyers et ressources locataires plafonnés, dans les zones tendues (A, A bis, B1). Attention : la réduction s\'applique sur un prix plafonné à 5 500 €/m² et 300 000 €.</p><p>Le <strong>statut LMNP (Loueur Meublé Non Professionnel)</strong> est souvent plus avantageux fiscalement : en régime réel, vous pouvez déduire toutes les charges ET amortir le bien (sur 25-30 ans) et les meubles (sur 5-7 ans), ce qui permet de générer des déficits amortissables et de ne payer aucun impôt sur les loyers pendant 10-15 ans pour la plupart des investisseurs.</p><ul><li>Micro-foncier : abattement forfaitaire 30% si revenus &lt; 15 000 €/an (nu)</li><li>Micro-BIC : abattement 50% pour meublé classique, 71% pour meublé classé tourisme</li><li>Malraux : réduction 22-30% pour rénovation en secteur sauvegardé</li></ul>',
                ],
                [
                    'id'    => 'sci-et-structure',
                    'title' => 'Détenir en SCI ou en nom propre ?',
                    'body'  => '<p>La <strong>SCI (Société Civile Immobilière)</strong> est pertinente pour la transmission patrimoniale et la détention à plusieurs, mais elle est fiscalement neutre en elle-même (transparente à l\'IR). Elle facilite la cession de parts plutôt que du bien, utile pour la donation ou la succession.</p><p>La SCI à l\'<strong>IS (Impôt sur les Sociétés)</strong> permet l\'amortissement du bien, comme le LMNP, mais elle est imposée à l\'IS sur les bénéfices distribués, ce qui peut être pénalisant à long terme (imposition sur la plus-value au régime IS et non IR). Elle convient aux investisseurs qui ne souhaitent pas distribuer les revenus.</p><p>Pour un premier investissement locatif standard, le régime <strong>LMNP en nom propre</strong> est souvent la structure la plus simple et la plus avantageuse fiscalement, sans frais de constitution de société ni contraintes comptables lourdes.</p>',
                ],
                [
                    'id'    => 'financer-investissement',
                    'title' => 'Financer son investissement locatif',
                    'body'  => '<p>Contrairement à la résidence principale, l\'investissement locatif bénéficie d\'une logique de <strong>levier financier</strong> : emprunter au maximum est souvent préférable à payer cash, car les intérêts d\'emprunt sont déductibles fiscalement (régime réel) et le rendement locatif peut dépasser le taux d\'emprunt.</p><p>Le calcul du taux d\'endettement intègre les loyers attendus à hauteur de <strong>70%</strong> (banques appliquent une décote de 30% pour vacance locative). Si vous empruntez 150 000 € à 3% sur 20 ans (mensualité 831 €) et que le loyer attendu est 700 €, la banque comptabilise 490 € de revenus locatifs, soit une charge nette de 341 €/mois dans votre taux d\'endettement.</p><ul><li>Apport : 10-20% recommandé pour couvrir frais de notaire et charges initiales</li><li>Préférez emprunter sur la durée maximale pour maximiser le levier fiscal</li><li>Un conseiller KapitalStark peut simuler l\'impact exact sur votre imposition</li></ul>',
                ],
            ],
        ],
        [
            'slug'    => 'assurance-emprunteur-deleguer',
            'tag'     => 'Assurance',
            'title'   => 'Assurance emprunteur : comparer, déléguer et économiser',
            'excerpt' => 'La délégation d\'assurance peut faire économiser 10 000 € à 30 000 € sur la durée de votre prêt. Tout ce qu\'il faut savoir depuis la loi Lemoine.',
            'date'    => '10 jan. 2025',
            'read'    => '7 min',
            'icon'    => '⚖️',
            'author'  => 'Sophie Leclerc — DGD',
            'sections' => [
                [
                    'id'    => 'garanties-essentielles',
                    'title' => 'Les garanties essentielles à vérifier',
                    'body'  => '<p>Une assurance emprunteur couvre plusieurs risques. Les garanties <strong>DC (décès)</strong> et <strong>PTIA (Perte Totale et Irréversible d\'Autonomie)</strong> sont universellement requises par les banques. Elles couvrent le remboursement intégral du capital restant dû en cas de décès ou d\'invalidité absolue.</p><p>Les garanties <strong>IPT (Invalidité Permanente Totale)</strong> et <strong>IPP (Invalidité Permanente Partielle)</strong> couvrent les invalidités d\'origine médicale supérieures à 66% ou 33% selon les contrats. La garantie <strong>ITT (Incapacité Temporaire de Travail)</strong> prend en charge les mensualités pendant un arrêt de travail, après une franchise de 30 à 90 jours selon les contrats.</p><ul><li>Vérifiez le mode d\'indemnisation : <strong>indemnitaire</strong> (complète les autres revenus) vs <strong>forfaitaire</strong> (verse la mensualité intégrale) — le forfaitaire est plus avantageux</li><li>Attention aux exclusions : maladies dorsales (souvent plafonnées), troubles psychiques, métiers à risques</li><li>Pour la garantie ITT, comparez la franchise et le seuil de déclenchement (hospitalisation vs simple arrêt)</li></ul>',
                ],
                [
                    'id'    => 'loi-lemoine-delegation',
                    'title' => 'La loi Lemoine et la délégation d\'assurance',
                    'body'  => '<p>Depuis le 1er juin 2022, la <strong>loi Lemoine</strong> permet à tout emprunteur de <strong>changer d\'assurance emprunteur à n\'importe quel moment</strong>, sans frais ni pénalités, dès lors que le nouveau contrat présente un niveau de garanties équivalent (critères CCSF). La banque a 10 jours ouvrés pour accepter ou refuser (avec motif écrit obligatoire).</p><p>La délégation d\'assurance consiste à souscrire l\'assurance chez un assureur externe plutôt qu\'auprès de la banque prêteuse. Les contrats bancaires ("contrats groupe") mutualisent les risques entre tous les emprunteurs, ce qui pénalise les profils jeunes et sains. Un contrat individuel adapté à votre âge et état de santé peut coûter 2 à 5 fois moins cher.</p><ul><li>Économie moyenne : 0,15 à 0,40% de TAEG</li><li>Sur 200 000 € sur 20 ans : économie potentielle de <strong>15 000 à 30 000 €</strong></li><li>Le droit à l\'oubli permet aux anciens malades du cancer (protocole > 5 ans) de ne pas déclarer la maladie</li></ul>',
                ],
                [
                    'id'    => 'comparer-les-offres',
                    'title' => 'Comment comparer les offres efficacement',
                    'body'  => '<p>La comparaison d\'assurances emprunteurs doit se faire sur la base du <strong>TAEA (Taux Annuel Effectif d\'Assurance)</strong>, qui permet de comparer le coût sur la durée du prêt indépendamment du capital restant dû. La banque est obligée de vous communiquer le TAEA de son contrat.</p><p>Les critères CCSF (Comité Consultatif du Secteur Financier) définissent 18 critères d\'équivalence de garanties, dont 11 sont "prioritaires". Pour substituer une assurance, votre nouveau contrat doit couvrir au minimum les critères exigés par votre banque. Les banques publient obligatoirement leur liste de critères.</p><ul><li>Utilisez les comparateurs en ligne (Meilleurtaux, Magnolia, Assurly) pour une première estimation</li><li>Sollicitez l\'aide d\'un courtier en assurance pour les profils "à risques" (sport, santé)</li><li>La garantie perte d\'emploi est facultative et souvent peu rentable (franchise longue, exclusions nombreuses)</li></ul>',
                ],
                [
                    'id'    => 'procedure-changement',
                    'title' => 'La procédure de changement : étape par étape',
                    'body'  => '<p>Le changement d\'assurance se déroule en 4 étapes : 1) Obtenir la fiche standardisée d\'information (FSI) de votre banque — elle liste les critères d\'équivalence exigés. 2) Sélectionner une offre concurrente qui coche tous ces critères. 3) Envoyer une demande de substitution à votre banque par lettre recommandée ou voie dématérialisée, avec le nouveau contrat en pièce jointe. 4) Attendre la réponse sous 10 jours ouvrés.</p><p>En cas de refus abusif (qui doit être motivé par écrit), vous pouvez saisir le médiateur bancaire. En pratique, les refus légitimes sont rares si vous respectez bien les critères d\'équivalence. La date d\'effet du nouveau contrat est l\'acceptation de la banque, sans interruption de couverture.</p><p>Chez KapitalStark, notre équipe assurance accompagne gratuitement les emprunteurs dans cette démarche et gère la résiliation auprès de votre banque.</p>',
                ],
            ],
        ],
        [
            'slug'    => 'pret-agricole-guide',
            'tag'     => 'Agricole',
            'title'   => 'Prêt agricole : financer son exploitation de A à Z',
            'excerpt' => 'Matériel, foncier, trésorerie saisonnière, aides PAC… notre guide complet pour les agriculteurs qui souhaitent financer intelligemment leur exploitation.',
            'date'    => '25 jan. 2025',
            'read'    => '10 min',
            'icon'    => '🌾',
            'author'  => 'Pierre Garnier — Conseiller Entreprises',
            'sections' => [
                [
                    'id'    => 'types-financement-agricole',
                    'title' => 'Les types de financement agricole',
                    'body'  => '<p>Le financement agricole se distingue du crédit classique par l\'adaptation aux <strong>cycles saisonniers</strong> de production. Un agriculteur dépense en début de campagne (semences, engrais, carburant) et perçoit ses revenus après la récolte — parfois 6 à 9 mois plus tard. Les banques spécialisées en agriculture adaptent leurs produits à cette réalité.</p><p>Le <strong>crédit de campagne</strong> (ou crédit de trésorerie saisonnière) est une ligne de crédit à court terme renouvelée chaque année, remboursée en fin de récolte. Le <strong>prêt d\'équipement</strong> finance les matériels agricoles sur 3 à 7 ans, souvent avec un différé de remboursement de 12 mois. Le <strong>prêt foncier</strong> finance l\'achat de terres sur 15 à 25 ans.</p><ul><li>Crédit-bail agricole : alternative au prêt pour le matériel, avec entretien inclus possible</li><li>Prêt bonifiés MSA : taux réduits pour les installations aidées (jeunes agriculteurs)</li><li>Prêt SAFE BPI : financement BPI pour l\'agro-industrie et les filières certifiées</li></ul>',
                ],
                [
                    'id'    => 'aides-pac-subventions',
                    'title' => 'Aides PAC et subventions : les intégrer au plan de financement',
                    'body'  => '<p>La <strong>Politique Agricole Commune (PAC)</strong> verse des aides annuelles basées sur les surfaces (droits à paiement de base, paiement redistributif, aide couplée selon les productions). Ces aides constituent des revenus réguliers qui améliorent la capacité de remboursement. Les banques les intègrent dans le calcul du revenu disponible avec un coefficient de fiabilité élevé.</p><p>La <strong>Dotation Jeune Agriculteur (DJA)</strong> est une aide à l\'installation de 10 000 à 70 000 € (modulée selon la zone et le département) pour les moins de 40 ans. Elle est accompagnée d\'un prêt bonifié à taux réduit. Ces financements publics sont cumulables avec le prêt bancaire et permettent de réduire l\'apport personnel requis.</p><ul><li>PCAE (Plan de Compétitivité et d\'Adaptation des Exploitations Agricoles) : subventions régionales pour l\'agroécologie</li><li>France Agri Mer : fonds spécifiques selon les filières (viticulture, maraîchage, élevage)</li><li>Crédit d\'impôt agricole : disponible pour la certification HVE et l\'agriculture biologique</li></ul>',
                ],
                [
                    'id'    => 'remboursements-saisonniers',
                    'title' => 'Remboursements saisonniers : adapter le calendrier à la récolte',
                    'body'  => '<p>La plupart des banques agricoles proposent des <strong>plans de remboursement adaptés aux cycles de production</strong>. Plutôt que des mensualités égales, les remboursements sont concentrés en fin de campagne, quand les revenus de la récolte ont été encaissés. Cette structure réduit considérablement la pression sur la trésorerie en période de dépenses.</p><p>Pour une exploitation céréalière (blé, colza), les revenus arrivent en juillet-août. Le plan de remboursement prévoit alors des versements importants en septembre-octobre, avec des mensualités symboliques ou nulles en mars-avril, en pleine saison des intrants.</p><ul><li>Différé de remboursement possible sur 12 à 24 mois pour les nouvelles installations</li><li>Lissage possible en cas de mauvaise récolte : contact immédiat avec le conseiller bancaire recommandé</li><li>L\'assurance récolte peut servir de filet de sécurité pour honorer les remboursements en cas de sinistre climatique</li></ul>',
                ],
                [
                    'id'    => 'constituer-dossier-agricole',
                    'title' => 'Constituer un dossier agricole solide',
                    'body'  => '<p>Un dossier agricole se distingue d\'un dossier de crédit classique par la nécessité de présenter un <strong>plan d\'exploitation prévisionnel</strong> cohérent. Pour une installation, le Plan de Professionnalisation Personnalisé (PPP) et le Plan de Développement de l\'Exploitation (PDE) validés par la Chambre d\'Agriculture constituent un socle crédible.</p><p>Pour une exploitation en activité, les <strong>comptes de gestion ou bilans comptables des 2 à 3 dernières années</strong> (établis par un cabinet comptable ou un centre de gestion agricole) sont indispensables. La banque analyse la capacité de remboursement (EBE — Emprunts), la structure des actifs et la rentabilité par production.</p><p>Chez KapitalStark, notre conseiller agricole est formé aux spécificités du secteur et travaille en partenariat avec les centres de gestion agricole pour simplifier le montage de votre dossier.</p>',
                ],
            ],
        ],
        [
            'slug'    => 'remboursement-anticipe-credit',
            'tag'     => 'Conseils',
            'title'   => 'Remboursement anticipé de crédit : avantages, pénalités et stratégies',
            'excerpt' => 'Vous avez reçu une somme importante ? Est-il intéressant de rembourser votre crédit par anticipation ? La réponse dépend de plusieurs facteurs.',
            'date'    => '7 fév. 2025',
            'read'    => '6 min',
            'icon'    => '🔄',
            'author'  => 'Sophie Leclerc — DGD',
            'sections' => [
                [
                    'id'    => 'quand-interessant',
                    'title' => 'Quand le remboursement anticipé est-il rentable ?',
                    'body'  => '<p>Le remboursement anticipé (RA) est rentable quand le <strong>gain en intérêts futurs</strong> dépasse les indemnités de remboursement anticipé (IRA) et le coût d\'opportunité de la somme mobilisée. Il est particulièrement intéressant en début de prêt, quand la part d\'intérêts dans la mensualité est maximale.</p><p>Exemple : un prêt immobilier de 200 000 € à 2,5% sur 20 ans. Après 5 ans, rembourser 30 000 € par anticipation économise environ 18 000 € d\'intérêts sur les 15 ans restants, contre des IRA de 600 € maximum (6 mois d\'intérêts plafonnés légalement). Le gain net est de 17 400 €.</p><ul><li>RA partiel : possible à tout moment, sans justification</li><li>RA total : solde l\'intégralité du prêt + IRA</li><li>Seuil légal minimum : 10% du capital initial pour les prêts immobiliers (certains contrats)</li></ul>',
                ],
                [
                    'id'    => 'ira-penalites',
                    'title' => 'Les indemnités de remboursement anticipé (IRA)',
                    'body'  => '<p>Les IRA sont plafonnées par la loi pour les crédits immobiliers à <strong>6 mois d\'intérêts</strong> au taux du prêt, et au maximum <strong>3% du capital restant dû</strong>. Le prêteur applique le moindre des deux montants.</p><p>Pour un crédit à la consommation, la loi Lagarde plafonne les IRA à <strong>1% du capital restant dû</strong> si la durée restante est supérieure à un an, ou <strong>0,5%</strong> si inférieure à un an. Certains contrats prévoient même une <strong>exonération totale d\'IRA</strong> (à négocier lors de la souscription).</p><p>Dans certains cas, les IRA peuvent être exonérées : vente du bien finançant un bien familial principal (prêts immobiliers), perte d\'emploi, décès, invalidité du co-emprunteur.</p>',
                ],
                [
                    'id'    => 'strategies-alternatives',
                    'title' => 'Stratégies alternatives au remboursement anticipé',
                    'body'  => '<p>Avant de rembourser par anticipation, envisagez ces alternatives : <strong>moduler vos mensualités à la hausse</strong> si votre contrat le permet (réduction de durée sans IRA), placer la somme sur un livret A ou une assurance-vie si le rendement dépasse le taux du prêt (intéressant quand les taux d\'épargne sont élevés).</p><p>Pour un prêt à taux bas (< 2%), il est souvent plus judicieux d\'<strong>investir la somme</strong> (immobilier locatif, actions, PEA) plutôt que de rembourser. Un crédit à 1,5% remboursé par anticipation "rapporte" 1,5%/an, alors qu\'un PEA diversifié peut générer 5 à 7%/an en moyenne long terme.</p>',
                ],
                [
                    'id'    => 'simuler-gain',
                    'title' => 'Comment simuler votre gain potentiel',
                    'body'  => '<p>Le calcul du gain d\'un remboursement anticipé nécessite de comparer : le total des intérêts futurs évités vs. les IRA payées + l\'opportunité de placer la somme ailleurs. Notre simulateur de prêt KapitalStark intègre un tableau d\'amortissement qui vous permet de visualiser les intérêts restant à payer à tout moment du prêt.</p><p>Pour un RA partiel, l\'impact sur la durée ou les mensualités dépend de l\'option choisie (votre contrat prévoit généralement les deux). Réduire la durée maximise le gain en intérêts ; réduire les mensualités améliore votre cash-flow mensuel. Consultez votre conseiller KapitalStark pour une simulation personnalisée basée sur votre contrat réel.</p>',
                ],
            ],
        ],
    ];

    public function index()
    {
        return view('blog.index', ['articles' => $this->articles]);
    }

    public function show(string $slug)
    {
        $article = collect($this->articles)->firstWhere('slug', $slug);

        if (!$article) {
            abort(404);
        }

        $related = collect($this->articles)
            ->where('slug', '!=', $slug)
            ->take(3)
            ->values()
            ->toArray();

        return view('blog.show', compact('article', 'related'));
    }
}
