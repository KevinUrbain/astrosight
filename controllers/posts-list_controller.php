<?php
//Securité dans le cas où on ne vient pas de l'index
if (!defined('ROOT')) {
        http_response_code(403);
        exit('Accès interdit');
}


// Vérification Admin
check_admin();

$sql = "SELECT p.*, u.username 
        FROM posts p 
        JOIN users u ON p.user_id = u.id 
        ORDER BY p.created_at DESC";

$stmt = $pdo->query($sql);
$allPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);

$titlePage = "Administration des Posts";
