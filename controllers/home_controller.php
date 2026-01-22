<?php
//Securité dans le cas où on ne vient pas de l'index
if (!defined('ROOT')) {
        http_response_code(403);
        exit('Accès interdit');
}


$search = isset($_GET['search']) ? trim($_GET['search']) : null;


$sql = "SELECT 
        p.*,
        (SELECT COUNT(*) FROM comments c WHERE c.post_id = p.id AND c.status_comment = 1) as comment_count
        FROM posts p 
        WHERE p.status_post = 1 AND p.is_deleted = 0";
$params = [];


if ($search) {
        $sql .= " AND (p.title LIKE :search OR p.content LIKE :search)";
        $params[':search'] = '%' . $search . '%';
}


$sql .= " ORDER BY p.created_at DESC";


$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

$titlePage = "Accueil";
if ($search) {
        $titlePage = "Recherche : " . htmlspecialchars($search);
}
