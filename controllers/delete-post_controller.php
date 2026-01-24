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


if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: ' . BASE_URL . '/my-posts');
    exit();
}

$postId = intval($_GET['id']);
$action = $_GET['action'] ?? 'delete';

$isAdmin = isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin';


if ($isAdmin) {
    $sql = "SELECT id FROM posts WHERE id = :pid";
    $params = [':pid' => $postId];
} else {
    $sql = "SELECT id FROM posts WHERE id = :pid AND user_id = :uid";
    $params = [':pid' => $postId, ':uid' => $_SESSION['user']['id']];
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$post = $stmt->fetch();

if ($post) {

    if ($action === 'draft') {
        // CAS 1 : Mettre en BROUILLON
        $updateStmt = $pdo->prepare("UPDATE posts SET status_post = 0 WHERE id = :id");
        $updateStmt->execute([':id' => $postId]);
        $msg = "drafted";

    } elseif ($action === 'publish') {
        // CAS 2 : PUBLIER
        if ($isAdmin) {
            $updateStmt = $pdo->prepare("UPDATE posts SET status_post = 1 WHERE id = :id");
            $updateStmt->execute([':id' => $postId]);
            $msg = "published";
        } else {
            // Un non-admin ne peut pas publier.
            header('Location: ' . BASE_URL . '/my-posts?error=auth');
            exit();
        }

    } else {
        // CAS 3 : SUPPRIMER (is_deleted = 1) - Comportement par défaut
        $deleteStmt = $pdo->prepare("UPDATE posts SET is_deleted = 1, status_post = 0 WHERE id = :id");
        $deleteStmt->execute([':id' => $postId]);
        $msg = "deleted";
    }

    if ($isAdmin) {
        header('Location: ' . BASE_URL . '/?page=admin-list-posts&success=' . $msg);
    } else {
        header('Location: ' . BASE_URL . '/my-posts?success=' . $msg);
    }

} else {
    header('Location: ' . BASE_URL . '/my-posts?error=auth');
}
exit();