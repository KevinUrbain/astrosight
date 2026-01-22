<?php

//Securité dans le cas où on ne vient pas de l'index
if (!defined('ROOT')) {
    http_response_code(403);
    exit('Accès interdit');
}


$slug = $_GET['slug'] ?? null;

if (!$slug) {
    header('Location: ' . BASE_URL . '/home');
    exit();
}

$sql = "SELECT p.*, u.username, u.avatar, u.first_name, u.last_name 
        FROM posts p 
        JOIN users u ON p.user_id = u.id 
        WHERE p.slug = :slug AND p.status_post = 1";

$stmt = $pdo->prepare($sql);
$stmt->execute([':slug' => $slug]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);


if (!$post) {
    http_response_code(404);
    require ROOT . '/templates/error404.php';
    exit();
}

$commentError = null;
$commentSuccess = null;


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_comment'])) {

    check_login();

    $content = (trim($_POST['content']));

    if (!empty($content)) {
        try {
            $stmtInsert = $pdo->prepare("INSERT INTO comments (post_id, user_id, content) VALUES (:pid, :uid, :content)");
            $stmtInsert->execute([
                ':pid' => $post['id'],
                ':uid' => $_SESSION['user']['id'],
                ':content' => $content
            ]);

            $commentSuccess = "Votre commentaire a été publié avec succès !";
            header('Location:' . BASE_URL . '/post/' . $post['slug']);
        } catch (PDOException $e) {
            log_error($e); // Log the error to file
            $commentError = "Une erreur est survenue lors de l'envoi.";
        }
    } else {
        $commentError = "Le commentaire ne peut pas être vide.";
    }
}

$sqlComments = "SELECT 
                    c.*,
                    u.username, 
                    u.avatar,
                    (SELECT COUNT(*) FROM posts WHERE posts.user_id = u.id AND status_post = 1) as nb_posts
                FROM comments c 
                JOIN users u ON c.user_id = u.id 
                WHERE c.post_id = :pid AND status_comment = 1 
                ORDER BY c.created_at DESC";

$stmtComm = $pdo->prepare($sqlComments);
$stmtComm->execute([':pid' => $post['id']]);
$comments = $stmtComm->fetchAll(PDO::FETCH_ASSOC);

$sqlImages = "SELECT filename FROM post_images WHERE post_id = :id";
$stmtImg = $pdo->prepare($sqlImages);
$stmtImg->execute([':id' => $post['id']]);
$galleryImages = $stmtImg->fetchAll(PDO::FETCH_COLUMN);


$titlePage = htmlspecialchars($post['title']);

$date = new DateTime($post['created_at']);
$formattedDate = $date->format('d/m/Y');
