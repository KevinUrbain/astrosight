<?php
// config/database.sample.php

if (!defined('ROOT'))
    exit();

$host = $_SERVER['HTTP_HOST'];

// --- MODE LOCAL ---
if (strpos($host, 'localhost') !== false) {
    define('DB_HOST', 'localhost');
    define('DB_PORT', '/');
    define('DB_NAME', '/');
    define('DB_USER', 'root');
    define('DB_PASS', '/');

    // URL locale automatique
    define('BASE_URL', 'http://localhost/nom-projet');
    define('SHOW_ERRORS', true);

} else {
    // --- MODE PRODUCTION (serveur) ---

    define('DB_HOST', 'localhost'); // Souvent localhost même en prod
    define('DB_PORT', '3306');

    define('DB_NAME', 'NOM_DE_BASE');
    define('DB_USER', 'UTILISATEUR');
    define('DB_PASS', 'MOT_DE_PASSE');

    define('BASE_URL', 'https://www.votre-site.com');

    define('SHOW_ERRORS', false);
}

//GESTION DES ERREURS
if (SHOW_ERRORS) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
}


try {
    $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";

    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);

} catch (PDOException $e) {
    if (SHOW_ERRORS) {
        $message = date('Y-m-d H:i:s') . ' : ' . $e->getMessage() . "\n";
        if (defined('ROOT')) {
            error_log($message, 3, ROOT . '/log/error_log.txt');
            require_once ROOT . '/templates/error404.php';
        } else {
            die("Erreur critique BDD");
        }
        exit();
    } else {
        die("Le site rencontre une erreur technique. Veuillez réessayer plus tard.");
    }
}