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
$titlePage = 'AstroSight';
$titleSite = 'AstroSight';
$contentTitle = '';

switch ($page) {
    case 'home':
        $titlePage = 'Accueil';
        $titleSite = 'AstroSight - Accueil';
        $contentTitle = "Contribuez à la carte du ciel. Rejoignez le réseau d'astronomes amateurs.";
        break;
    case 'about':
        $titlePage = 'A propos';
        $titleSite = 'AstroSight - A propos';
        break;
    case 'register':
        $titlePage = "S'inscrire";
        $titleSite = 'AstroSight - Inscription';
        break;
    case 'login':
        $titlePage = 'Connexion';
        $titleSite = 'AstroSight - Connexion';
        break;
    case 'contact':
        $titlePage = 'Contactez-nous';
        $titleSite = 'AstroSight - Contact';
        break;
    case 'add-post':
        $titlePage = 'Publier un post';
        $titleSite = 'AstroSight - Publier';
        break;
    case 'my-posts':
        $titlePage = 'Mes posts';
        $titleSite = 'AstroSight - Mes posts';
        break;
    case 'profile-edit':
        $titlePage = 'Editer mon profil';
        $titleSite = 'AstroSight - Editer profil';
        break;
    case 'privacy':
        $titlePage = 'Politique de confidentialité';
        $titleSite = 'AstroSight - Politique de confidentialité';

        break;
    case 'dashboard':
        $titlePage = 'Dashboard';
        $titleSite = 'AstroSight - Mon Dashboard';
        break;
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