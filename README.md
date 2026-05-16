# AstroSight

**AstroSight** est une plateforme communautaire francophone dédiée aux astronomes amateurs. Elle permet de partager des observations astronomiques, des photos du ciel profond, et d'interagir avec d'autres passionnés.

> Site de production : [astrosight.be](https://astrosight.be)

---

## Fonctionnalités

### Pour les utilisateurs
- Inscription / connexion avec avatar personnalisé
- Publication d'observations avec photos, description et données techniques (télescope, monture, caméra, filtre, échelle Bortle, etc.)
- Galerie d'images par observation
- Commentaires sur les publications (soumis à modération)
- Gestion de son profil et de ses publications

### Pour les administrateurs
- Tableau de bord : gestion des utilisateurs, posts et commentaires
- Approbation, mise en attente ou suppression de commentaires
- Modification ou suppression de tout utilisateur

### Autres
- Recherche parmi les observations
- Formulaire de contact avec envoi d'e-mail (PHPMailer / SMTP)
- Sitemap XML dynamique pour le SEO
- Page 404 personnalisée
- Page politique de confidentialité (RGPD)

---

## Stack technique

| Couche | Technologie |
|---|---|
| Backend | PHP 7.x+ avec PDO |
| Base de données | MySQL / MariaDB (UTF-8MB4) |
| Email | PHPMailer 7.0 (via Composer) |
| Frontend | Bootstrap 5.3.0 + Font Awesome 7.1.0 |
| CSS | Thème sombre personnalisé (CSS variables) |
| JavaScript | Vanilla JS + Bootstrap Bundle |
| Serveur | Apache avec mod_rewrite (`.htaccess`) |
| Local | Laragon (Windows) |

---

## Architecture

L'application suit un pattern **MVC-lite** avec un routeur central.

```
index.php  ←  toutes les requêtes (via .htaccess)
    │
    ├── ROUTES[]       → fichiers de vues
    └── CONTROLLERS[]  → fichiers de contrôleurs
```

```
public/  ← web root (assets, uploads)
config/  ← connexion BDD + constantes
controllers/ ← logique métier, requêtes SQL, redirections
views/       ← templates HTML (présentation uniquement)
templates/   ← composants réutilisables (nav, header, footer)
functions/   ← helpers (auth, utils)
services/    ← intégrations externes (MailerService)
```

**Flux d'une requête :**
1. `.htaccess` redirige vers `index.php?page=X`
2. Le routeur inclut le contrôleur correspondant
3. Le contrôleur accède à la BDD, valide les données, gère les POST
4. Les guards `check_login()` / `check_admin()` protègent les routes
5. Le contrôleur charge la vue, enveloppée dans `layout.php`

---

## Structure des fichiers

```
astrosight/
├── index.php                   # Point d'entrée et routeur
├── sitemap.php                 # Sitemap XML dynamique
├── .htaccess                   # Réécriture d'URL Apache
├── composer.json               # Dépendances PHP (PHPMailer)
│
├── config/
│   ├── database.php            # Config BDD + constantes (non versionné)
│   └── database.sample.php     # Modèle de config
│
├── controllers/                # 20 contrôleurs (un par page/action)
├── views/                      # Templates de pages (+ sous-dossier admin/)
├── templates/                  # Composants partagés (head, nav, header, footer, 404)
├── functions/                  # auth.php, utils.php, createDropDownCountries.php
├── services/                   # MailerService.php
│
├── public/
│   ├── css/                    # Bootstrap, Font Awesome, styles personnalisés
│   ├── js/                     # Bootstrap bundle
│   ├── webfonts/               # Polices Font Awesome
│   ├── assets/img/             # Images statiques (OG image, favicon)
│   └── uploads/posts/          # Images uploadées par les utilisateurs
│
├── uploads/img-avatar/         # Avatars des utilisateurs
├── log/error_log.txt           # Journal d'erreurs (si SHOW_ERRORS=true)
└── vendor/                     # Dépendances Composer
```

---

## Base de données

Les principales tables (déduites des contrôleurs) :

| Table | Description |
|---|---|
| `users` | Comptes utilisateurs (id, username, email, password_hash, role, avatar…) |
| `posts` | Observations (titre, slug, contenu, image, catégorie, pays, ville, données techniques, statut…) |
| `post_images` | Images multiples liées à un post |
| `comments` | Commentaires (lié à post et user, statut de modération) |

---

## Installation locale

### Prérequis
- **Laragon** (ou Apache + PHP 7.4+ + MySQL)
- **Composer**

### Étapes

```bash
# 1. Cloner le dépôt dans le dossier web de Laragon
git clone <url-du-repo> C:\laragon\www\astrosight

# 2. Installer les dépendances PHP
composer install

# 3. Configurer la base de données
cp config/database.sample.php config/database.php
# Éditer config/database.php avec vos identifiants locaux

# 4. Importer le schéma SQL
# (importer le fichier .sql fourni séparément via phpMyAdmin ou CLI)

# 5. Accéder à l'application
# http://localhost/astrosight
```

### Variables de configuration (`config/database.php`)

| Constante | Description |
|---|---|
| `DB_HOST` | Hôte MySQL (`localhost`) |
| `DB_PORT` | Port MySQL (`3306`) |
| `DB_NAME` | Nom de la base de données |
| `DB_USER` | Utilisateur MySQL |
| `DB_PASS` | Mot de passe MySQL |
| `BASE_URL` | URL de base (`http://localhost/astrosight` ou `https://astrosight.be`) |
| `SHOW_ERRORS` | `true` en développement, `false` en production |
| `SMTP_HOST` | Hôte SMTP pour les e-mails |
| `SMTP_USER` | Identifiant SMTP |
| `SMTP_PASS` | Mot de passe SMTP |
| `SMTP_PORT` | Port SMTP |

---

## Sécurité

- Requêtes préparées PDO (protection injection SQL)
- `htmlspecialchars()` sur toutes les sorties (protection XSS)
- Hachage des mots de passe avec `password_hash()` / `password_verify()`
- Cookies de session : `httponly=true`, `samesite=Strict`
- Validation et assainissement des entrées utilisateur
- Protection des routes par rôle (`check_login()`, `check_admin()`)

---

## Rôles utilisateurs

| Rôle | Accès |
|---|---|
| `user` | Publier, éditer/supprimer ses propres posts, commenter, gérer son profil |
| `admin` | Tout ce que `user` peut faire + gestion des utilisateurs, modération des commentaires, gestion de tous les posts |

---

## Développement

Le projet n'utilise pas de bundler front-end. Les assets CSS/JS sont servis directement depuis `public/`. Pour modifier le thème, éditer [public/styles.css](public/styles.css) (variables CSS `--primary-accent`, `--bg-dark`, etc.).

Les contrôleurs suivent la convention de nommage `<nom-de-page>_controller.php` et les vues `<nom-de-page>.php`.

---

## Licence

Projet privé — tous droits réservés © AstroSight / Kevin Urbain.
