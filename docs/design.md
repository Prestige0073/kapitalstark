# Design UI/UX — Spécifications

> Source : `KapitalStark_Cahier_des_Charges_Design.md`
> Règle absolue : **zéro violet/mauve/lavande/pourpre** — interdit partout.

---

## Identité de marque
- **Nom :** KapitalStark
- **Slogan :** "Votre avenir financier commence ici"
- **Ton :** Professionnel mais chaleureux, rassurant, accessible à tous (jeunes actifs, familles, entrepreneurs, retraités)

---

## Palette de couleurs

### Couleurs principales
| Rôle | Couleur | Hex |
|---|---|---|
| Dominante | Bleu ciel KapitalStark | `#267BF1` |
| Variante sombre | Bleu profond | `#1A56B0` |
| Accent léger | Bleu clair pastel | `#A8CFF7` |

### Couleurs secondaires
| Rôle | Couleur | Hex |
|---|---|---|
| Fond principal | Blanc pur | `#FFFFFF` |
| Fond alterné | Crème glacé | `#F5F8FC` |
| Accent premium | Or doux | `#C8A951` |
| Texte principal | Gris anthracite | `#2D2D2D` |
| Texte secondaire | Gris moyen | `#6B7280` |

### Couleurs fonctionnelles
| Rôle | Hex |
|---|---|
| Succès | `#22C55E` |
| Erreur | `#EF4444` |
| Avertissement | `#F59E0B` |

### Dégradés autorisés
- Bleu ciel → Bleu profond (diagonal ou horizontal)
- Bleu profond → Noir bleuté `#0D1B2A` (hero/bannières)
- Blanc → Crème glacé (transitions subtiles)
- Bleu ciel → Or doux (CTA premium, très rarement)

---

## Typographie

| Usage | Police | Taille | Style |
|---|---|---|---|
| H1 | Playfair Display | 56-72px | Bold, espacement -2% |
| H2 | Playfair Display | 40-48px | Bold |
| H3 | DM Sans | 28-32px | SemiBold |
| H4 | DM Sans | 22-24px | SemiBold |
| Corps | DM Sans | 16-18px | Regular, interligne 1.7 |
| Petit texte | DM Sans | 14px | Regular |
| Boutons | DM Sans | 16px | SemiBold, espacement +1% |
| Chiffres/Taux | Space Mono | variable | Bold |

---

## Grille & Mise en page
- Container max : **1440px** centré
- Grille **12 colonnes**, gouttières 24px
- Marges : 80px desktop / 40px tablette / 20px mobile
- Padding sections : 100-120px desktop / 60-80px mobile
- Alterner les layouts : jamais deux sections identiques consécutives
- Formes organiques (blobs, vagues, courbes) pour casser la rigidité
- Grilles Bento pour certaines sections de fonctionnalités

---

## Animations

### Scroll Reveal
- Fade-in + slide-up (0.6s, ease-out) à chaque section
- Stagger 0.1s entre éléments d'une même section
- Cartes : scale 0.95 → 1
- Titres : révélation mot par mot ou lettre par lettre
- Chiffres : count-up de 0 à la valeur (2s, ease-out)

### Hover
- Boutons : scale 1.03 + ombre agrandie
- Cartes : translateY -8px + ombre prononcée + bordure bleue
- Liens menu : soulignement animé gauche → droite
- Images : scale 1.05 (overflow hidden)
- Liens footer : décalage droite + flèche qui apparaît

### Continues (subtiles)
- Dégradé hero qui se déplace lentement
- Blobs décoratifs flottants
- Indicateur scroll animé dans le hero
- Barre progression scroll (fine ligne bleue en haut de page)

### Spéciales
- Simulateur : barres/graphiques animés en temps réel
- Timeline d'étapes : progression animée sur la ligne
- Loader : logo KapitalStark animé au chargement

> **Règle perf :** toutes animations via `transform` + `opacity`. Respecter `prefers-reduced-motion`.

---

## Composants UI clés

### Boutons
| Type | Style |
|---|---|
| Primaire | Fond bleu ciel, texte blanc, radius 12px |
| Secondaire | Outline bleu profond, fond transparent |
| Ghost | Texte bleu, pas de fond ni bordure |
| CTA Premium | Dégradé bleu → or, icône animée |

### Cartes
- Fond blanc, radius 16-20px, ombre douce
- Hover : élévation + bordure bleue subtile

### Formulaires
- Focus : bordure bleue + ombre bleue légère
- Floating labels animés
- Sliders custom (curseur bleu ciel)
- Checkboxes/radios custom bleu
- Validation temps réel : ✓ vert / ✗ rouge

### Images
- Formes : radius 20-30px, blobs organiques, clip-path
- Ombres douces, bordures bleues ou dorées subtiles
- Format WebP + fallback JPEG, lazy loading

---

## Header
- Sticky, hauteur 80px → 64px au scroll (shrink)
- Gauche : Logo | Centre : Menu méga-menus | Droite : Langue + "Espace Client" + "Simuler un Prêt"
- Méga-menus : colonnes 3-4, icônes bleues, animation slide-down 0.3s
- Mobile : hamburger → plein écran fond bleu profond, sous-menus accordéon

### Structure du menu
1. **Nos Prêts** — Immobilier, Automobile, Personnel, Entreprise, Agricole, Microcrédit
2. **Simulateur** — Par type + Comparateur + Capacité d'emprunt
3. **À Propos** — Histoire, Équipe, Valeurs, Chiffres, Agences, Carrières
4. **Ressources** — Blog, Guides, FAQ, Glossaire, Vidéos, Téléchargements
5. **Contact** — Formulaire, RDV, Agences, Service client

---

## Footer
- Fond bleu profond ou noir charbon, texte blanc
- 5 colonnes : KapitalStark (logo + réseaux) | Nos Prêts | Ressources | L'Entreprise | Contact & Support
- Badges sécurité + Trustpilot entre colonnes et barre du bas
- Barre du bas : copyright + liens légaux + sélecteur langue

---

## Pages
Voir [features.md](features.md) pour la liste complète des pages et leur statut d'avancement.

---

## Responsive
| Breakpoint | Layout |
|---|---|
| > 1200px | Desktop complet |
| 768-1200px | Tablette, grilles 2 colonnes, hamburger |
| < 768px | Mobile, 1 colonne, tout empilé |

- Tables → scrollables ou cartes sur mobile
- Footer → accordéon sur mobile
- Zones cliquables min 44×44px (touch-friendly)

---

## Accessibilité
- Contraste WCAG AA minimum (4.5:1)
- Navigation clavier, focus visible (outline bleu)
- Aria-labels sur tous les éléments interactifs
- Hiérarchie headings respectée (H1 → H2 → H3)
- `prefers-reduced-motion` respecté

---

## Multilingue
- Français (défaut), Anglais, Allemand, Espagnol, Portugais
- Sélecteur : globe + drapeau, dropdown avec noms
- URLs : `/fr/`, `/en/`, `/de/`, `/es/`, `/pt/`
- Changement sans rechargement (SPA behaviour)
