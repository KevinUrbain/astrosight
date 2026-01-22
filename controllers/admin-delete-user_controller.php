<?php
//Securité dans le cas où on ne vient pas de l'index
if (!defined('ROOT')) {
    http_response_code(403);
    exit('Accès interdit');
}

check_admin();

$id = $_GET['id'] ?? null;

// J'empêche l'admin de se supprimer lui-même
if ($id && $id != $_SESSION['user']['id']) {
    try {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $_SESSION['success_message'] = "Utilisateur supprimé avec succès.";
        header('Location: ' . BASE_URL . '/dashboard?success=user_deleted');
    } catch (PDOException $e) {
        log_error($e);
        $_SESSION['error_message'] = "Erreur lors de la suppression de l'utilisateur.";
        header('Location: ' . BASE_URL . '/dashboard?error=delete_failed');
    }
} else {
    header('Location: ' . BASE_URL . '/dashboard?error=invalid_action');
}
exit();