# 📋 CAHIER DES CHARGES DESIGN — KAPITALSTARK

## Site Web de Prêt Bancaire — Spécifications Complètes UI/UX

---

---

## 🏢 1. IDENTITÉ DE MARQUE

### Nom : KapitalStark

### Slogan
"Votre avenir financier commence ici" / "Your Financial Future Starts Here"

### Positionnement
KapitalStark est une institution financière moderne, fiable et accessible. Le site doit inspirer confiance, professionnalisme et proximité humaine. Le design doit être riche, détaillé, chaleureux, jamais froid ni robotique. Il doit donner l'impression d'avoir été conçu par une équipe de designers seniors dans une grande agence — pas généré par une intelligence artificielle.

### Ton & Personnalité
- Professionnel mais chaleureux
- Rassurant et autoritaire sur les chiffres
- Accessible à tous : jeunes actifs, familles, entrepreneurs, retraités
- Langage clair, pas de jargon bancaire complexe

---

---

## 🎨 2. PALETTE DE COULEURS

### Interdiction absolue
- Aucune nuance de violet, mauve, lavande, pourpre ou fuschia. Zéro. Nulle part.
- Aucun dégradé violet. Aucun accent violet. Aucune ombre violette.

### Couleurs principales
- **Bleu ciel KapitalStark** (#267BF1) — Couleur dominante, confiance, modernité, sérénité
- **Bleu profond** (#1A56B0) — Variante sombre pour headers, sections hero, fonds sombres
- **Bleu clair pastel** (#A8CFF7) — Fonds de sections alternées, badges, tags, accents légers

### Couleurs secondaires
- **Blanc pur** (#FFFFFF) — Fond principal, espaces de respiration
- **Blanc cassé / Crème glacé** (#F5F8FC) — Fonds de sections alternées, cartes (légère teinte bleutée)
- **Or doux** (#C8A951) — Accent premium, étoiles, badges VIP, icônes spéciales
- **Gris anthracite** (#2D2D2D) — Texte principal, titres
- **Gris moyen** (#6B7280) — Texte secondaire, descriptions

### Couleurs fonctionnelles
- **Vert succès** (#22C55E) — Validations, confirmations
- **Rouge doux** (#EF4444) — Erreurs, alertes
- **Bleu info** (#267BF1) — Informations, liens (même que la couleur principale pour cohérence)
- **Orange attention** (#F59E0B) — Avertissements

### Dégradés autorisés
- Bleu ciel → Bleu profond (dégradé diagonal ou horizontal)
- Bleu profond → Noir bleuté (#0D1B2A) (pour les sections hero/bannières sombres)
- Blanc → Crème glacé (transitions de sections subtiles)
- Bleu ciel → Or doux (touches premium, très rarement, CTA spéciaux)

---

---

## 🔤 3. TYPOGRAPHIE

### Police des titres (Display)
- **Playfair Display** (Google Fonts) — Serif élégante, premium, forte personnalité
- Utilisée pour : H1, H2, grands titres de sections, slogans, citations

### Police du corps de texte
- **DM Sans** (Google Fonts) — Sans-serif moderne, très lisible, chaleureuse
- Utilisée pour : paragraphes, descriptions, boutons, menus, labels

### Police d'accent / chiffres
- **Space Mono** ou **JetBrains Mono** — Monospace pour les chiffres importants, taux, montants, calculateurs, compteurs animés

### Hiérarchie typographique
- H1 : Playfair Display, 56-72px, Bold, espacement serré (-2%)
- H2 : Playfair Display, 40-48px, Bold
- H3 : DM Sans, 28-32px, SemiBold
- H4 : DM Sans, 22-24px, SemiBold
- Paragraphe : DM Sans, 16-18px, Regular, interligne 1.7
- Petit texte : DM Sans, 14px, Regular
- Boutons : DM Sans, 16px, SemiBold, lettres légèrement espacées (+1%)
- Chiffres / Taux : Space Mono, taille variable, Bold

---

---

## 📐 4. GRILLE & MISE EN PAGE

### Grille principale
- Container max : 1440px centré
- Grille 12 colonnes avec gouttières de 24px
- Marges latérales : 80px desktop, 40px tablette, 20px mobile
- Sections : padding vertical 100-120px desktop, 60-80px mobile

### Principes de layout
- Alterner les layouts : pleine largeur → conteneur → asymétrique → grille → split screen
- Jamais deux sections identiques en layout consécutives
- Utiliser des formes organiques (blobs, vagues, courbes) pour casser la rigidité
- Superpositions d'éléments : images qui débordent de leur conteneur, cartes qui chevauchent les sections
- Sections avec fonds colorés (bleu profond, crème) alternées avec blanc pur
- Utiliser des grilles Bento (bento grid) pour certaines sections de fonctionnalités

### Formes d'images
- Images dans des formes : coins arrondis généreux (20-30px), formes organiques (blob), cercles, formes géométriques avec un coin coupé, parallélogrammes légers
- Bordures subtiles dorées ou bleues sur certaines images clés
- Ombres portées douces et élégantes (pas de box-shadow brutal)
- Effet de superposition : image + forme de couleur semi-transparente qui chevauche
- Masques CSS : utiliser clip-path pour des formes originales

---

---

## ✨ 5. ANIMATIONS & MICRO-INTERACTIONS

### Animations d'entrée (Scroll Reveal)
- Chaque section apparaît au scroll avec un fade-in + léger slide-up (durée 0.6s, ease-out)
- Les éléments d'une même section apparaissent en cascade (stagger de 0.1s entre chaque élément)
- Les cartes apparaissent une par une avec un léger scale de 0.95 → 1
- Les titres apparaissent avec un effet de révélation mot par mot ou lettre par lettre sur les titres principaux
- Les chiffres/statistiques s'animent avec un compteur qui monte de 0 à la valeur finale (count-up animation)

### Animations de hover
- Boutons : léger scale-up (1.03), changement de couleur smooth, ombre qui s'agrandit
- Cartes : élévation (translateY -8px), ombre plus prononcée, bordure qui apparaît
- Liens du menu : soulignement animé qui glisse de gauche à droite
- Images : léger zoom-in (scale 1.05) avec overflow hidden
- Icônes : rotation légère ou bounce subtil au hover
- Liens footer : décalage à droite avec une flèche qui apparaît

### Animations continues (subtiles)
- Dégradé de fond de la bannière qui se déplace lentement (animation de gradient)
- Formes décoratives en arrière-plan qui flottent doucement (floating blobs)
- Indicateur de scroll animé dans le hero (petite flèche qui pulse)
- Barre de progression du scroll en haut de page (fine ligne bleue)
- Particules ou points subtils qui se déplacent en fond de certaines sections sombres

### Transitions de page
- Transition douce entre les pages (fade-in/out)
- Loader animé avec le logo KapitalStark pendant le chargement
- Skeleton screens pendant le chargement du contenu

### Animations spéciales
- Simulateur de prêt : les barres et graphiques s'animent en temps réel quand l'utilisateur bouge les curseurs
- Compteurs de statistiques : effet count-up quand la section entre dans le viewport
- Témoignages : carousel avec transition slide fluide
- Timeline d'étapes : progression animée le long d'une ligne

---

---

## 🧭 6. BARRE DE NAVIGATION (HEADER)

### Structure du header
- Header fixe (sticky) en haut de page
- Fond blanc avec une fine ombre en bas quand l'utilisateur scroll
- Hauteur : 80px desktop, 64px mobile
- Le header devient légèrement plus compact au scroll (shrink effect de 80px → 64px)

### Disposition
- **Gauche** : Logo KapitalStark (icône + texte)
- **Centre** : Menu principal horizontal
- **Droite** : Sélecteur de langue (FR/EN/DE/...), bouton "Espace Client" (outline bleu), bouton "Simuler un Prêt" (plein bleu ciel, CTA principal)

### Menu principal — Structure complète

**1. Nos Prêts** (méga-menu dropdown)
- Prêt Immobilier → page dédiée
  - Achat résidence principale
  - Investissement locatif
  - Rachat de crédit immobilier
  - Prêt travaux / rénovation
- Prêt Automobile → page dédiée
  - Voiture neuve
  - Voiture d'occasion
  - Véhicule utilitaire
  - Leasing / LOA
- Prêt Personnel → page dédiée
  - Prêt consommation
  - Prêt voyage
  - Prêt mariage / événement
  - Prêt études / formation
- Prêt Entreprise → page dédiée
  - Création d'entreprise
  - Développement / expansion
  - Trésorerie
  - Équipement professionnel
- Prêt Agricole → page dédiée
  - Équipement agricole
  - Foncier agricole
  - Trésorerie saisonnière
- Microcrédit → page dédiée
  - Microcrédit personnel
  - Microcrédit professionnel

**2. Simulateur** (méga-menu)
- Simulateur de prêt immobilier
- Simulateur de prêt auto
- Simulateur de prêt personnel
- Simulateur de capacité d'emprunt
- Comparateur de taux
- Calculateur de mensualités

**3. À Propos** (dropdown classique)
- Notre histoire
- Notre équipe / Direction
- Nos valeurs & engagements
- Chiffres clés
- Nos agences / Nous trouver
- Carrières / Rejoignez-nous
- Presse & Médias

**4. Ressources** (méga-menu)
- Blog / Actualités financières
- Guides pratiques
  - Guide du premier emprunteur
  - Guide de l'investissement immobilier
  - Guide de la création d'entreprise
- FAQ / Questions fréquentes
- Glossaire financier
- Vidéos & Tutoriels
- Téléchargements (brochures PDF, formulaires)

**5. Contact** (dropdown)
- Formulaire de contact
- Prendre rendez-vous en ligne
- Nos agences (carte interactive)
- Service client (horaires, téléphone)
- Réclamations

### Méga-menu design
- Fond blanc avec une ombre généreuse
- Organisé en colonnes (3-4 colonnes par méga-menu)
- Chaque catégorie a une icône bleue et un titre en gras
- Les sous-éléments sont des liens avec hover animé
- Une image ou illustration décorative sur le côté droit du méga-menu
- Animation d'apparition : slide-down + fade-in depuis le header (durée 0.3s)

### Menu mobile
- Hamburger menu animé (3 barres → X avec transition)
- Menu plein écran (full-screen overlay) avec fond bleu profond
- Texte blanc, grand, bien espacé
- Sous-menus en accordéon avec icône + / -
- Boutons CTA en bas du menu mobile
- Sélecteur de langue accessible

---

---

## 🖼️ 7. PAGE D'ACCUEIL — SECTIONS DÉTAILLÉES

---

### 7.1 — SECTION HERO / BANNIÈRE PRINCIPALE

**Layout** : Split screen — texte à gauche (55%), image/visuel à droite (45%)

**Côté gauche (texte)** :
- Badge au-dessus du titre : petit tag arrondi bleu clair avec icône étoile + texte "N°1 des prêts en ligne" ou "Taux à partir de 2.9%"
- Titre H1 : "Financez Tous Vos Projets Avec KapitalStark" — en Playfair Display, très grand, bleu profond. Un mot clé surligné en bleu ciel avec un underline décoratif animé
- Sous-titre : 2-3 lignes en DM Sans, gris anthracite, qui explique la promesse de valeur
- Deux boutons CTA côte à côte :
  - "Simuler Mon Prêt" — bouton plein bleu ciel, grande taille, avec icône flèche animée
  - "Découvrir Nos Offres" — bouton outline bleu profond
- Ligne de confiance en dessous : petites icônes + textes "✓ Réponse en 24h" | "✓ 100% en ligne" | "✓ Taux compétitifs" | "✓ Sans frais cachés"

**Côté droit (visuel)** :
- Image principale d'une famille/personne souriante dans un cadre de vie (maison, voiture, bureau) — dans une forme organique (blob ou arrondi asymétrique)
- Éléments flottants décoratifs autour de l'image :
  - Petite carte flottante avec icône maison + "Prêt approuvé ✓" avec une animation de flottement
  - Petite carte flottante avec un graphique en hausse + "+15 000 clients satisfaits"
  - Formes géométriques bleues décoratives en arrière-plan (cercles, points)

**Arrière-plan** : Dégradé très subtil blanc → crème avec des formes organiques bleues transparentes en arrière-plan. Motif de points ou lignes très discret.

**Animation** : Le texte apparaît mot par mot ou ligne par ligne, les éléments flottants apparaissent en cascade avec un bounce léger, le badge arrive en premier avec un slide-in depuis la gauche.

---

### 7.2 — BARRE DE CONFIANCE / PARTENAIRES

**Layout** : Bande horizontale, fond blanc ou crème léger

**Contenu** :
- Logos de partenaires / banques centrales / certifications : logos en niveaux de gris, qui deviennent colorés au hover
- Défilement automatique fluide (marquee effect) si beaucoup de logos
- Texte au-dessus : "Ils nous font confiance" ou "Nos partenaires"
- Séparateur décoratif au-dessus et en dessous (fine ligne ou vague SVG)

---

### 7.3 — NOS TYPES DE PRÊTS (Section Produits)

**Layout** : Grille Bento (bento grid) — 6 cartes de tailles variées (2 grandes + 4 moyennes ou autre combinaison asymétrique)

**Titre de section** :
- Sur-titre petit en bleu ciel + icône : "💰 Nos Solutions"
- Titre H2 : "Un Prêt Pour Chaque Projet de Vie"
- Sous-titre descriptif en gris

**Chaque carte de prêt contient** :
- Icône large et détaillée du type de prêt (maison, voiture, personne, building, tracteur, pièces)
- Nom du prêt (H3)
- Description courte (2-3 lignes)
- Taux indicatif en gros (police mono, accent or) : "à partir de X.XX%"
- Petit tag : "Populaire", "Nouveau", "PME" selon le cas
- Bouton "En savoir plus →"
- Fond de carte : blanc avec bordure très subtile, au hover → ombre élevée + bordure bleue

**Animation** : Les cartes apparaissent en cascade au scroll. Au hover, la carte s'élève et l'icône fait un bounce subtil.

**Fond de section** : Crème / blanc cassé avec des formes organiques bleues très pâles en arrière-plan

---

### 7.4 — POURQUOI CHOISIR KAPITALSTARK (Avantages)

**Layout** : Deux colonnes — illustration à gauche, grille d'avantages à droite (2x3)

**Côté gauche** :
- Grande illustration ou image d'une personne utilisant un téléphone/ordinateur, dans une forme arrondie avec des éléments décoratifs autour
- Éléments décoratifs : points bleus, cercle doré, lignes

**Côté droit — 6 avantages en grille 2x3** :
Chaque avantage a :
- Icône dans un cercle bleu clair (ou carré arrondi)
- Titre court en gras
- Description en 1-2 lignes
- Léger séparateur entre chaque

Les 6 avantages :
1. 🏦 Taux Compétitifs — "Les meilleurs taux du marché, renégociables"
2. ⚡ Réponse en 24h — "Votre demande traitée rapidement"
3. 📱 100% Digital — "Faites tout en ligne depuis chez vous"
4. 🛡️ Sécurité Totale — "Vos données protégées et cryptées"
5. 👤 Conseiller Dédié — "Un expert personnel vous accompagne"
6. 💎 Zéro Frais Cachés — "Transparence totale sur les coûts"

**Animation** : L'image apparaît en slide-in depuis la gauche, les avantages apparaissent un par un en stagger depuis la droite

---

### 7.5 — SIMULATEUR DE PRÊT RAPIDE (Section Interactive)

**Layout** : Section pleine largeur, fond bleu profond (section sombre)

**Design** :
- Titre en blanc : "Simulez Votre Prêt en 30 Secondes"
- Sous-titre en bleu clair
- Formulaire interactif stylisé avec fond blanc/glassmorphism :
  - Sélecteur de type de prêt (icônes cliquables en ligne : Immobilier / Auto / Personnel / Entreprise)
  - Slider pour le montant (avec affichage en temps réel, police mono grande)
  - Slider pour la durée (en mois/années)
  - Affichage instantané en gros :
    - Mensualité estimée (très grand, police mono, couleur or)
    - Taux indicatif
    - Coût total du crédit
  - Bouton CTA : "Faire Ma Demande Complète"
- Éléments décoratifs : graphique en barres animé qui évolue selon les valeurs, courbe animée, icônes flottantes

**Animation** : Les résultats s'animent en temps réel (count-up, barres qui bougent). Le conteneur a un léger effet glassmorphism avec blur.

---

### 7.6 — COMMENT ÇA MARCHE (Étapes)

**Layout** : Section timeline horizontale avec 4 étapes reliées par une ligne de progression animée

**Titre** : "Comment Obtenir Votre Prêt ?"

**Les 4 étapes** :
1. 📝 **Remplissez le Formulaire** — "Complétez votre demande en ligne en 5 minutes"
2. 📊 **Analyse de Votre Dossier** — "Notre équipe étudie votre demande sous 24h"
3. ✅ **Offre Personnalisée** — "Recevez une offre adaptée à votre profil"
4. 💳 **Déblocage des Fonds** — "Les fonds sont virés directement sur votre compte"

**Design de chaque étape** :
- Numéro dans un grand cercle bleu (ou en or)
- Icône illustrative au-dessus
- Titre en gras
- Description courte
- Ligne de connexion animée entre chaque étape (progression de gauche à droite au scroll)

**Animation** : La ligne de progression se remplit au scroll, chaque cercle s'illumine quand atteint, les icônes font un bounce à l'activation

---

### 7.7 — CHIFFRES CLÉS / STATISTIQUES

**Layout** : Bande horizontale, fond dégradé bleu profond → bleu ciel

**4 compteurs animés en ligne** :
- **+50 000** Clients Satisfaits (icône personnes)
- **2.9%** Taux le Plus Bas (icône pourcentage)
- **24h** Délai de Réponse (icône horloge)
- **98%** Taux d'Acceptation (icône check)

**Design** : Chiffres en très grande police mono blanche ou dorée, labels en blanc. Séparateurs verticaux entre chaque. Chaque chiffre a une icône au-dessus.

**Animation** : Count-up de 0 à la valeur finale quand la section entre dans le viewport (durée 2s, ease-out)

---

### 7.8 — TÉMOIGNAGES CLIENTS

**Layout** : Section fond blanc/crème avec un carousel de témoignages

**Titre** : "Ce Que Disent Nos Clients"

**Chaque témoignage** :
- Grande carte blanche avec ombre douce
- Photo du client dans un cercle avec bordure bleue
- Nom, profession, ville
- Étoiles de notation (5 étoiles dorées animées)
- Citation en italique avec guillemets décoratifs grandes et bleues (")
- Type de prêt contracté (petit badge)
- Date

**Carousel** :
- 3 témoignages visibles à la fois sur desktop
- Navigation : flèches gauche/droite stylisées + indicateurs points en bas
- Auto-scroll toutes les 5 secondes
- Transition slide fluide

**Éléments décoratifs** : Guillemets géants en bleu pâle en arrière-plan, formes organiques

---

### 7.9 — BLOG / ACTUALITÉS (Aperçu)

**Layout** : Grille 3 colonnes (1 article large à gauche + 2 articles empilés à droite)

**Titre** : "Actualités & Conseils Financiers"

**Chaque carte article** :
- Image en haut avec coins arrondis et overlay bleu subtil au hover
- Catégorie en petit badge bleu
- Titre H3 cliquable
- Extrait (2 lignes)
- Date + temps de lecture
- Auteur avec petit avatar
- Bouton "Lire la suite →"

**Bouton** en bas : "Voir Tous les Articles →"

---

### 7.10 — SECTION CTA / APPEL À L'ACTION

**Layout** : Section pleine largeur avec fond bleu profond et motif géométrique subtil en overlay

**Contenu centré** :
- Titre H2 blanc : "Prêt à Réaliser Votre Projet ?"
- Sous-titre en bleu clair
- Deux boutons côte à côte :
  - "Simuler Mon Prêt" (bouton blanc, texte bleu)
  - "Parler à un Conseiller" (bouton outline blanc)
- Ligne de confiance : icônes en blanc (sécurité, rapidité, confiance)
- Éléments décoratifs : cercles dorés, lignes, formes géométriques subtiles

---

### 7.11 — SECTION NEWSLETTER

**Layout** : Bande, fond crème

**Contenu** :
- Icône enveloppe animée
- Titre : "Restez Informé"
- Description : "Recevez nos meilleurs conseils et offres exclusives"
- Champ email stylisé avec bouton "S'abonner" intégré à droite du champ
- Texte RGPD en petit en dessous

---

---

## 🦶 8. FOOTER

### Structure du footer — Riche et complet

**Fond** : Bleu profond (#1B5E3B) ou noir charbon (#1A1A1A) avec texte blanc/gris clair

**Organisation en 5 colonnes + section du bas** :

**Colonne 1 — KapitalStark**
- Logo en blanc
- Description courte de l'entreprise (3-4 lignes)
- Réseaux sociaux : icônes rondes (Facebook, Twitter/X, LinkedIn, Instagram, YouTube) avec hover animé (scale + couleur de la marque)

**Colonne 2 — Nos Prêts**
- Prêt Immobilier
- Prêt Automobile
- Prêt Personnel
- Prêt Entreprise
- Prêt Agricole
- Microcrédit

**Colonne 3 — Ressources**
- Blog
- FAQ
- Guides Pratiques
- Glossaire
- Simulateurs
- Téléchargements

**Colonne 4 — L'Entreprise**
- À Propos
- Notre Équipe
- Carrières
- Presse
- Nos Agences
- Partenaires

**Colonne 5 — Contact & Support**
- Adresse physique avec icône
- Téléphone avec icône (cliquable)
- Email avec icône (cliquable)
- Horaires d'ouverture
- Bouton "Chat en Direct" stylisé
- Bouton "Prendre RDV"

**Section badge de confiance** (entre les colonnes et le bas) :
- Badges de sécurité (SSL, certification bancaire)
- Logos de régulateurs
- Note Trustpilot / avis clients

**Barre du bas** :
- © 2026 KapitalStark. Tous droits réservés.
- Liens : Mentions légales | CGU | Politique de confidentialité | Cookies | Plan du site
- Sélecteur de langue compact

**Animations footer** :
- Les liens ont un hover avec décalage à droite + flèche qui apparaît
- Les icônes réseaux sociaux ont un hover avec scale + couleur de marque
- Apparition en fade-in au scroll

---

---

## 📄 9. PAGES DÉDIÉES

---

### 9.1 — PAGE TYPE DE PRÊT (template commun pour chaque prêt)

Chaque type de prêt (Immobilier, Auto, Personnel, Entreprise, Agricole, Microcrédit) a sa propre page avec le même template mais du contenu personnalisé :

**Section Hero de la page** :
- Bannière avec fond dégradé bleu + image thématique (maison pour immobilier, voiture pour auto, etc.) dans une forme découpée
- Fil d'Ariane (breadcrumb) en haut
- Titre H1 : "Prêt [Type]"
- Description riche
- Badge "Taux à partir de X.XX%"
- Bouton CTA : "Simuler Ce Prêt"

**Section Avantages spécifiques** :
- Grille 3 colonnes, icônes + titres + descriptions
- Avantages propres à ce type de prêt

**Section Sous-catégories** :
- Cartes pour chaque sous-type (ex: pour Immobilier → Résidence principale, Investissement locatif, etc.)
- Chaque carte avec icône, titre, description, lien

**Section Détails & Conditions** :
- Tableau stylisé (pas un tableau HTML brut) avec :
  - Montants min/max
  - Durées possibles
  - Taux indicatifs
  - Conditions d'éligibilité
- Design : lignes alternées blanc/crème, coins arrondis, header bleu

**Section Simulateur intégré** :
- Simulateur spécifique au type de prêt, intégré dans la page
- Même design que le simulateur de la page d'accueil mais adapté

**Section Documents Requis** :
- Liste avec icônes de documents
- Chaque document requis avec icône + description
- Bouton "Télécharger le Checklist PDF"

**Section Étapes** :
- Timeline verticale ou horizontale, même design que la page d'accueil

**Section FAQ spécifique** :
- Accordéon avec questions/réponses spécifiques au type de prêt
- Icône + / - animée
- Fond crème

**Section CTA** :
- "Prêt à Faire Votre Demande de Prêt [Type] ?"
- Boutons CTA

---

### 9.2 — PAGE SIMULATEUR

**Section Hero** : Titre "Simulateur de Prêt" + description

**Simulateur complet** :
- Onglets stylisés pour chaque type de prêt
- Formulaire riche :
  - Type de prêt (sélection visuelle avec icônes)
  - Montant souhaité (slider + champ input combiné)
  - Durée (slider + sélection)
  - Revenus mensuels
  - Charges mensuelles
  - Apport personnel (pour immobilier)
- Résultats en temps réel dans un panneau latéral sticky :
  - Mensualité estimée (très grand)
  - Taux estimé
  - Coût total du crédit
  - Graphique camembert : capital vs intérêts
  - Graphique en barres : évolution des remboursements
  - Tableau d'amortissement dépliable
- Bouton "Faire Ma Demande Avec Ces Paramètres"

**Section comparative** :
- Tableau comparatif des différents types de prêts (taux, durées, avantages)

---

### 9.3 — PAGE À PROPOS

**Section Hero** : Image équipe + titre

**Notre Histoire** :
- Timeline verticale avec dates clés, illustrations, textes
- Animation : la ligne se dessine au scroll

**Notre Équipe** :
- Grille de cartes de membres de direction
- Photo circulaire, nom, poste, bio courte
- Liens LinkedIn
- Au hover : la carte tourne légèrement et montre plus d'infos

**Nos Valeurs** :
- 4-6 valeurs en grande grille avec icônes illustratives
- Transparence, Innovation, Proximité, Sécurité, Accessibilité, Engagement

**Chiffres Clés** :
- Compteurs animés (comme sur la page d'accueil)

**Nos Agences** :
- Carte interactive avec marqueurs
- Liste des agences avec adresse, téléphone, horaires

---

### 9.4 — PAGE BLOG

**Layout** :
- Header avec recherche et filtres par catégorie (badges cliquables)
- Article mis en avant (featured) en grand en haut
- Grille 3 colonnes pour les autres articles
- Pagination stylisée ou infinite scroll
- Sidebar avec :
  - Articles populaires
  - Catégories
  - Newsletter signup

**Catégories** :
- Immobilier, Auto, Entreprise, Conseils Financiers, Économie, Guides

---

### 9.5 — PAGE ARTICLE BLOG (template)

- Image hero pleine largeur avec overlay
- Titre H1 grand
- Méta : auteur (avec photo), date, catégorie, temps de lecture
- Contenu riche avec typographie soignée (bon interligne, taille confortable)
- Images intégrées dans des formes
- Encadrés colorés pour les conseils / points clés
- Table des matières sticky sur le côté
- Boutons de partage social (sticky sur le côté ou en haut)
- Section "Articles Associés" en bas (3 cartes)
- Commentaires / réactions

---

### 9.6 — PAGE CONTACT

**Layout split** : Formulaire à gauche + Infos à droite

**Formulaire** :
- Champs stylisés : Nom, Email, Téléphone, Sujet (dropdown), Message
- Labels animés (floating labels)
- Validation en temps réel avec icônes ✓ et ✗
- Bouton "Envoyer" avec animation de chargement
- Message de confirmation animé après envoi

**Infos de contact** :
- Adresse avec icône
- Téléphone cliquable
- Email cliquable
- Horaires dans un mini tableau
- Carte interactive Google Maps intégrée avec marqueur custom bleu
- Bouton "Prendre RDV en Ligne"
- Liens vers réseaux sociaux

---

### 9.7 — PAGE FAQ

- Barre de recherche en haut (chercher dans les FAQ)
- Catégories en onglets ou badges filtrants
- Questions en accordéon avec animation smooth
- Icônes par catégorie
- Chaque réponse peut contenir des liens, des images, des tableaux
- Section "Vous n'avez pas trouvé votre réponse ?" avec lien vers contact/chat

---

### 9.8 — PAGE ESPACE CLIENT (Dashboard)

**Accès** : Login/Register avec formulaire stylisé, option de connexion via email/téléphone

**Dashboard** :
- Sidebar à gauche (navigation) avec icônes
- Zone principale à droite

**Sections du dashboard** :
- **Accueil** : Résumé des prêts en cours, notifications, messages
- **Mes Prêts** : Liste des prêts avec statut (en cours, remboursé, en attente), barres de progression
- **Mes Demandes** : Suivi des demandes en cours, statut en étapes visuelles (stepper)
- **Documents** : Upload / téléchargement de documents, gestion de dossier
- **Messagerie / Chat** : Chat en direct avec un conseiller, historique des conversations
- **Mon Profil** : Informations personnelles, modification, mot de passe
- **Calendrier RDV** : Prise de rendez-vous, historique

**Design** :
- Cartes blanches avec ombres douces
- Graphiques de remboursement (barres, courbes)
- Badges de statut colorés (En cours → bleu, En attente → orange, Terminé → gris)
- Notifications avec point rouge
- Chat en direct : bulle en bas à droite, interface de messagerie élégante

---

### 9.9 — PAGE GLOSSAIRE FINANCIER

- Index alphabétique (A-Z) avec navigation rapide
- Chaque terme : mot en gras + définition claire + exemple d'utilisation si pertinent
- Barre de recherche en haut
- Design : cartes ou liste avec séparateurs, fond alternant

---

### 9.10 — PAGES LÉGALES (Mentions, CGU, Confidentialité)

- Design sobre mais toujours dans le thème
- Table des matières cliquable en sidebar sticky
- Typographie confortable
- Dernière date de mise à jour en haut

---

---

## 🌍 10. MULTILINGUE

### Langues supportées
- 🇫🇷 Français (par défaut)
- 🇬🇧 Anglais
- 🇩🇪 Allemand
- 🇪🇸 Espagnol
- 🇵🇹 Portugais

### Sélecteur de langue
- Icône globe + drapeau de la langue active
- Dropdown avec drapeaux + nom de la langue
- Placé dans le header (droite) et dans le footer
- Changement sans rechargement de page (SPA)
- Les URLs changent : /fr/, /en/, /de/, etc.

---

---

## 💬 11. CHAT EN DIRECT

### Widget de chat
- Bulle flottante en bas à droite de chaque page
- Icône de message bleu ciel avec badge de notification
- Au clic : fenêtre de chat élégante qui s'ouvre avec animation slide-up
- Fond blanc, header bleu profond
- Avatar du conseiller
- Messages avec bulles (bleu pour le conseiller, gris clair pour l'utilisateur)
- Indicateur "en train d'écrire..."
- Possibilité d'envoyer des fichiers
- Bouton de fermeture avec confirmation
- Historique conservé
- Message d'accueil automatique : "Bonjour ! Comment pouvons-nous vous aider ?"
- Horaires affichés (si hors ligne → formulaire de message)

---

---

## 🧩 12. COMPOSANTS UI RÉUTILISABLES

### Boutons
- **Primaire** : Fond bleu ciel, texte blanc, coins arrondis (12px), padding généreux, hover → scale + ombre
- **Secondaire** : Outline bleu profond, fond transparent, hover → fond bleu léger
- **Ghost** : Texte bleu, pas de fond ni bordure, hover → underline animé
- **CTA Premium** : Fond dégradé bleu → or, texte blanc, icône animée
- Tous les boutons ont une transition smooth de 0.3s

### Cartes
- Fond blanc, coins arrondis (16-20px), ombre douce
- Hover : élévation + bordure bleue subtile
- Variantes : carte produit, carte témoignage, carte article, carte avantage, carte équipe

### Formulaires
- Inputs : bordure gris clair, coins arrondis (10px), focus → bordure bleue + ombre bleue légère
- Labels flottants (floating labels) avec animation
- Sliders customisés : piste gris clair, curseur bleu ciel avec taille généreuse
- Dropdowns customisés : pas le select natif du navigateur
- Checkboxes et radios customisés en bleu
- Validation : bordure bleue + icône ✓ quand valide, rouge + icône ✗ quand invalide

### Accordéons
- Titre cliquable avec icône + / - ou chevron animé
- Contenu qui se déplie avec animation smooth (max-height transition)
- Fond légèrement différent quand ouvert

### Tabs / Onglets
- Onglets horizontaux avec indicateur bleu qui glisse sous l'onglet actif (animation de glissement)
- Contenu qui change avec fade transition

### Modales
- Overlay sombre avec blur
- Carte blanche centrée avec coins arrondis
- Animation : scale de 0.9 → 1 + fade-in
- Bouton de fermeture X en haut à droite

### Badges / Tags
- Coins très arrondis (50px), petit, texte bleu sur fond bleu clair
- Variantes : bleu (défaut), or (premium), gris (neutre), rouge (alerte)

### Tooltips
- Petite bulle avec fond bleu profond, texte blanc, apparition avec fade + léger décalage
- Flèche pointant vers l'élément

### Tableaux
- Pas de bordures lourdes, plutôt des lignes horizontales subtiles
- Header bleu profond avec texte blanc
- Lignes alternées blanc/crème
- Coins arrondis sur le conteneur
- Hover sur les lignes : fond bleu très léger

### Pagination
- Boutons numérotés avec hover bleu
- Page active : fond bleu ciel, texte blanc
- Flèches précédent/suivant stylisées

---

---

## 📱 13. RESPONSIVE DESIGN

### Breakpoints
- **Desktop** : > 1200px — Layout complet, sidebar, grilles multi-colonnes
- **Tablette** : 768px — 1200px — Grilles réduites (2 colonnes), menu hamburger
- **Mobile** : < 768px — 1 colonne, menu hamburger plein écran, composants empilés

### Adaptations mobile
- Menu hamburger plein écran avec animation
- Les grilles passent en 1 colonne
- Les sliders du simulateur deviennent pleine largeur
- Le chat en direct reste mais en taille réduite
- Les tableaux deviennent scrollables horizontalement ou se transforment en cartes
- Les images réduisent proportionnellement
- Le footer passe en accordéon (chaque colonne dépliable)
- Boutons CTA pleine largeur
- Typographie réduite proportionnellement (mais jamais en dessous de 14px pour le corps)
- Touch-friendly : zones cliquables de minimum 44x44px

---

---

## ♿ 14. ACCESSIBILITÉ

- Contraste suffisant (ratio WCAG AA minimum 4.5:1 pour le texte)
- Tous les images ont des attributs alt descriptifs
- Navigation au clavier possible partout (focus visible avec outline bleu)
- Aria-labels sur les éléments interactifs
- Hiérarchie de headings correcte (H1 → H2 → H3)
- Texte redimensionnable sans casser le layout
- Animations respectueuses du "prefers-reduced-motion" (désactivation possible)
- Formulaires avec labels associés et messages d'erreur clairs

---

---

## ⚡ 15. PERFORMANCE & TECHNIQUE

- Images en format WebP avec fallback JPEG
- Lazy loading sur toutes les images hors viewport
- Animations en CSS (transform, opacity) pour des performances GPU
- Fonts préchargées (preload)
- SVG pour toutes les icônes (pas de PNG/JPG pour les icônes)
- Compression et minification des assets
- Skeleton screens pendant le chargement
- Score Lighthouse visé : 90+ sur toutes les métriques

---

---

## 🔗 16. ICÔNES

### Librairie d'icônes
- Utiliser **Lucide Icons** ou **Phosphor Icons** — style ligne (outline), trait fin, cohérent
- Taille standard : 24px
- Couleur par défaut : bleu profond ou gris anthracite selon le contexte
- Icônes dans des conteneurs circulaires ou carrés arrondis quand décoratives (fond bleu clair)

### Icônes nécessaires (non exhaustif)
- Maison, Voiture, Personne, Building, Tracteur, Pièces (types de prêts)
- Calculatrice, Pourcentage, Horloge, Bouclier, Utilisateur, Diamant (avantages)
- Document, Upload, Download, Dossier (espace client)
- Téléphone, Email, Localisation, Globe, Calendrier (contact)
- Flèche, Chevron, Check, X, Plus, Minus, Recherche (navigation)
- Facebook, Twitter/X, LinkedIn, Instagram, YouTube (réseaux)
- Étoile, Citation, Cœur (témoignages)
- Graphique, Barre, Camembert (simulateur/données)

---

---

## 🗺️ 17. PLAN DU SITE COMPLET

```
KapitalStark.com
│
├── / (Accueil)
│
├── /prets/
│   ├── /prets/immobilier/
│   ├── /prets/automobile/
│   ├── /prets/personnel/
│   ├── /prets/entreprise/
│   ├── /prets/agricole/
│   └── /prets/microcredit/
│
├── /simulateur/
│   ├── /simulateur/immobilier/
│   ├── /simulateur/auto/
│   ├── /simulateur/personnel/
│   ├── /simulateur/capacite/
│   └── /simulateur/comparateur/
│
├── /a-propos/
│   ├── /a-propos/histoire/
│   ├── /a-propos/equipe/
│   ├── /a-propos/valeurs/
│   ├── /a-propos/agences/
│   ├── /a-propos/carrieres/
│   └── /a-propos/presse/
│
├── /ressources/
│   ├── /blog/
│   ├── /blog/[article-slug]/
│   ├── /guides/
│   ├── /faq/
│   ├── /glossaire/
│   ├── /videos/
│   └── /telechargements/
│
├── /contact/
│   ├── /contact/formulaire/
│   ├── /contact/rdv/
│   ├── /contact/agences/
│   └── /contact/reclamations/
│
├── /espace-client/
│   ├── /espace-client/connexion/
│   ├── /espace-client/inscription/
│   ├── /espace-client/dashboard/
│   ├── /espace-client/mes-prets/
│   ├── /espace-client/mes-demandes/
│   ├── /espace-client/documents/
│   ├── /espace-client/messagerie/
│   ├── /espace-client/profil/
│   └── /espace-client/rdv/
│
├── /mentions-legales/
├── /cgu/
├── /confidentialite/
├── /cookies/
└── /plan-du-site/
```

---

---

## 🎯 18. RÉSUMÉ DES RÈGLES D'OR DU DESIGN

1. **Jamais de violet** — Sous aucune forme, nulle part
2. **Jamais générique** — Chaque page, chaque section doit avoir du caractère
3. **Animations partout** — Mais toujours subtiles et professionnelles, jamais distrayantes
4. **Riche mais pas surchargé** — Dense en contenu, aéré en espace
5. **Cohérence totale** — Même langage visuel de la première à la dernière page
6. **Mobile first dans l'esprit** — Tout doit être pensé pour fonctionner sur mobile
7. **Confiance visuelle** — Chiffres, badges, témoignages, logos partout pour rassurer
8. **Pro, pas IA** — Aucun pattern reconnaissable comme "généré par IA" (pas de dégradés violets, pas de cartes génériques identiques, pas de layout répétitif)
9. **Images dans des formes** — Jamais d'images rectangulaires brutes, toujours stylisées
10. **Typographie soignée** — La hiérarchie typographique est le squelette du design

---
