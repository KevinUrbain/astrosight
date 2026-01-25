<?php
$lifetime = 3 * 60 * 60;

session_set_cookie_params([
    'lifetime' => $lifetime,
    'path' => '/',
    'domain' => '',
    'secure' => isset($_SERVER['HTTPS']),
    'httponly' => true,
    'samesite' => 'Strict'
]);

session_start();

// RACINE
define('ROOT', __DIR__);

// INCLUSIONS GLOBALES
// BASE_URL est défini dans config/database.php
require_once ROOT . '/config/database.php';
require_once ROOT . '/functions/auth.php';
require_once ROOT . '/functions/utils.php';


$page = !empty($_GET['page']) ? $_GET['page'] : 'home';

// ROUTES
const ROUTES = [
    // --- FRONTEND ---
    'home' => 'home',
    'about' => 'about',
    'register' => 'register',
    'login' => 'login',
    'logout' => 'logout',
    'contact' => 'contact',
    'privacy' => 'privacy',
    'post' => 'post-view',
    'my-posts' => 'my-posts',
    'profile-edit' => 'profile-edit',
    'add-post' => 'add-post',

    // Routes partagées Membres/Admins
    'edit-post' => 'edit-post',
    'delete-post' => 'delete-post',

    // --- BACKOFFICE (ADMIN) ---
    'dashboard' => 'admin/dashboard',
    'admin-list-posts' => 'admin/list-posts',
    'admin-list-comments' => 'admin/list-comments',
    'admin-approve-comment' => 'admin/approve-comment',
    'admin-hold-comment' => 'admin/hold-comment',
    'admin-delete-comment' => 'admin/delete-comment',
    'admin-edit-user' => 'admin/edit-user',
    'admin-delete-user' => 'admin/delete-user',
];

const CONTROLLERS = [
    // --- FRONTEND ---
    'home' => 'home_controller.php',
    'register' => 'register_controller.php',
    'login' => 'login_controller.php',
    'logout' => 'logout_controller.php',
    'post' => 'post_controller.php',
    'profile-edit' => 'profile-edit_controller.php',
    'add-post' => 'add-post_controller.php',
    'my-posts' => 'my-posts_controller.php',
    'contact' => 'contact_controller.php',
    'privacy' => 'privacy_controller.php',

    // Gestion des posts
    'edit-post' => 'edit-post_controller.php',
    'delete-post' => 'delete-post_controller.php',

    // --- BACKOFFICE (ADMIN) ---
    'dashboard' => 'dashboard_controller.php',
    'admin-list-posts' => 'posts-list_controller.php',
    'admin-approve-comment' => 'admin-approve-comment_controller.php',
    'admin-hold-comment' => 'admin-hold-comment_controller.php',
    'admin-delete-comment' => 'admin-delete-comment_controller.php',
    'admin-list-comments' => 'admin-comments-list_controller.php',
    'admin-edit-user' => 'admin-edit-user_controller.php',
    'admin-delete-user' => 'admin-delete-user_controller.php',
];

// GESTION DES URLS SPÉCIALES (Slug)
if (strpos($page, 'post/') === 0) {
    $parts = explode('/', $page);

    if (isset($parts[1])) {
        $_GET['slug'] = $parts[1];
        $page = 'post';
    }
}

//DÉFINITION DES TITRES PAR DÉFAUT
$titlePage = '';
$titleSite = '';
$contentTitle = '';
$metaDescription = "AstroSight est la plateforme communautaire pour les astronomes amateurs. Partagez vos observations, photos du ciel profond, et découvrez les publications de la communauté.";

switch ($page) {
    case 'home':
        $titlePage = "AstroSight : Le réseau des astronomes amateurs";
        $titleSite = "AstroSight - Blog et Partage d'observations astronomiques";
        $contentTitle = "Contribuez à la carte du ciel. Rejoignez le réseau d'astronomes amateurs.";
        $metaDescription = "AstroSight est la plateforme communautaire pour les astronomes amateurs. Partagez vos observations, photos du ciel profond, et découvrez les publications de la communauté.";
        break;
    case 'about':
        $titlePage = 'À propos du projet AstroSight';
        $titleSite = "Qui sommes-nous ? Notre mission pour l'astronomie amateur - AstroSight";
        $metaDescription = "Découvrez l'équipe et la mission d'AstroSight, un projet dédié à connecter les passionnés d'astronomie et à faciliter le partage de connaissances.";
        break;
    case 'register':
        $titlePage = "Rejoindre la communauté";
        $titleSite = 'Inscription gratuite - AstroSight';
        $metaDescription = "Inscrivez-vous gratuitement sur AstroSight pour commencer à partager vos observations astronomiques et interagir avec notre communauté d'astronomes amateurs.";
        break;
    case 'login':
        $titlePage = 'Connexion';
        $titleSite = 'Connexion - AstroSight';
        $metaDescription = "Connectez-vous à votre compte AstroSight pour accéder à votre profil, gérer vos publications et interagir avec la communauté.";
        break;
    case 'contact':
        $titlePage = "Contactez l'équipe AstroSight";
        $titleSite = "Contact & Support - AstroSight";
        $metaDescription = "Une question, une suggestion ? Contactez l'équipe d'AstroSight. Nous sommes à votre écoute pour améliorer votre expérience.";
        break;
    case 'add-post':
        $titlePage = 'Partager une nouvelle observation';
        $titleSite = 'Nouvelle publication - AstroSight';
        $metaDescription = "Publiez une nouvelle observation sur AstroSight. Partagez vos photos, détails techniques et récits avec la communauté.";
        break;
    case 'my-posts':
        $titlePage = 'Mes observations publiées';
        $titleSite = 'Gestion de mes posts - AstroSight';
        $metaDescription = "Gérez toutes vos publications, modifiez vos observations et suivez leurs statuts depuis votre espace personnel sur AstroSight.";
        break;
    case 'profile-edit':
        $titlePage = 'Modifier mes informations';
        $titleSite = 'Mon Profil - AstroSight';
        $metaDescription = "Mettez à jour vos informations de profil, votre biographie et votre avatar sur la plateforme AstroSight.";
        break;
    case 'privacy':
        $titlePage = 'Politique de confidentialité';
        $titleSite = 'Confidentialité et RGPD - AstroSight';
        $metaDescription = "Consultez notre politique de confidentialité pour comprendre comment nous protégeons vos données personnelles sur AstroSight.";
        break;
    case 'dashboard':
        $titlePage = 'Dashboard';
        $titleSite = 'AstroSight - Mon Dashboard';
        break;
    // IMPORTANT: Pour la page 'post', le titre et la description doivent être définis
    // dans le contrôleur (ex: post_controller.php) à partir des données du post.
    // $titleSite = $post['title'] . ' - AstroSight';
    // $metaDescription = substr(strip_tags($post['content']), 0, 155);
}

//VÉRIFICATION DE LA ROUTE
if (!array_key_exists($page, ROUTES)) {
    http_response_code(404);
    require ROOT . '/templates/error404.php';
    exit();
}

//SÉCURITÉ ADMIN
if (strpos($page, 'admin') === 0) {
    // La fonction check_admin() (dans auth.php) gère la connexion ET le rôle
    check_admin();
}

//CHARGEMENT DU CONTRÔLEUR
if (array_key_exists($page, CONTROLLERS)) {
    require ROOT . '/controllers/' . CONTROLLERS[$page];
}

//AFFICHAGE DE LA VUE (LAYOUT)
$contentView = ROUTES[$page];
require ROOT . '/views/layout.php';