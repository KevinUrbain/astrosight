<?php

if (!defined('ROOT')) {
    http_response_code(403);
    exit('Accès interdit');
}

check_admin();

$commentId = $_GET['id'] ?? null;

if ($commentId) {
    try {
        $stmt = $pdo->prepare("DELETE FROM comments WHERE id = :id");
        $stmt->execute([':id' => $commentId]);
        $_SESSION['success_message'] = "Commentaire supprimé avec succès.";
    } catch (PDOException $e) {
        log_error($e);
        $_SESSION['error_message'] = "Erreur lors de la suppression du commentaire.";
    }
} else {
    $_SESSION['error_message'] = "ID de commentaire manquant.";
}

header('Location: ' . BASE_URL . '/admin-list-comments');
exit();
