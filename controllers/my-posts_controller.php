<?php

//Securité dans le cas où on ne vient pas de l'index
if (!defined('ROOT')) {
    http_response_code(403);
    exit('Accès interdit');
}

if (!isset($_SESSION['user'])) {
    header('Location: ' . BASE_URL . '/login');
    exit();
}


$sql = "SELECT id, title, category, created_at, status_post, featured_image, slug 
        FROM posts 
        WHERE user_id = :uid AND is_deleted = 0
        ORDER BY created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute([':uid' => $_SESSION['user']['id']]);
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

$titlePage = "Mes publications";
