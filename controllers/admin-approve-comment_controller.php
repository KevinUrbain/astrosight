<?php
//Securité
if (!defined('ROOT')) {
    http_response_code(403);
    exit('Accès interdit');
}

check_admin();

$commentId = $_GET['id'] ?? null;

if ($commentId) {
    try {
        $stmt = $pdo->prepare("UPDATE comments SET status_comment = 1 WHERE id = :id");
        $stmt->execute([':id' => $commentId]);
        $_SESSION['success_message'] = "Commentaire approuvé avec succès.";
    } catch (PDOException $e) {
        log_error($e);
        $_SESSION['error_message'] = "Erreur lors de l'approbation du commentaire.";
    }
} else {
    $_SESSION['error_message'] = "ID de commentaire manquant.";
}

header('Location: ' . BASE_URL . '/admin-list-comments');
exit();
