<?php
// Ce script génère le fichier sitemap.xml à la volée.

define('ROOT', __DIR__);
require_once ROOT . '/config/database.php';
require_once ROOT . '/functions/utils.php';

header('Content-Type: application/xml; charset=utf-8');

echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

function addUrl($loc, $lastmod = null, $changefreq = 'weekly', $priority = '0.8')
{
    echo '  <url>' . PHP_EOL;
    echo '    <loc>' . htmlspecialchars($loc) . '</loc>' . PHP_EOL;
    if ($lastmod) {
        echo '    <lastmod>' . date('c', strtotime($lastmod)) . '</lastmod>' . PHP_EOL;
    }
    echo '    <changefreq>' . $changefreq . '</changefreq>' . PHP_EOL;
    echo '    <priority>' . $priority . '</priority>' . PHP_EOL;
    echo '  </url>' . PHP_EOL;
}

// 1. Pages statiques
$staticPages = ['about', 'contact', 'register', 'login', 'privacy'];
addUrl(BASE_URL . '/', date('c'), 'daily', '1.0'); // Page d'accueil
foreach ($staticPages as $page) {
    addUrl(BASE_URL . '/' . $page, null, 'monthly', '0.7');
}

// 2. Pages dynamiques (posts)
try {
    // Assurez-vous que votre table 'posts' a une colonne 'slug' pour les URLs propres
    $stmt = $pdo->query("SELECT slug, updated_at FROM posts WHERE status_post = 1 AND is_deleted = 0 ORDER BY updated_at DESC");
    while ($post = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $postUrl = BASE_URL . '/post/' . $post['slug'];
        addUrl($postUrl, $post['updated_at'], 'weekly', '0.9');
    }
} catch (PDOException $e) {
    log_error($e);
}

echo '</urlset>' . PHP_EOL;
