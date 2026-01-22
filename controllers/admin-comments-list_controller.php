<?php
//Securité
if (!defined('ROOT')) {
    http_response_code(403);
    exit('Accès interdit');
}

$sql = "SELECT 
            c.*, 
            u.username,
            p.title as post_title,
            p.slug as post_slug
        FROM comments c
        JOIN users u ON c.user_id = u.id
        JOIN posts p ON c.post_id = p.id
        ORDER BY c.created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

$titlePage = "Gestion des commentaires";
