<?php
//Securité dans le cas où on ne vient pas de l'index
if (!defined('ROOT')) {
    http_response_code(403);
    exit('Accès interdit');
}

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ' . BASE_URL . '/home');
    exit();
}

$id = $_GET['id'] ?? null;
$errors = [];
$success = false;


$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute([':id' => $id]);
$userEdit = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$userEdit) {
    header('Location: ' . BASE_URL . '/dashboard');
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = $_POST['role'];

    $update = $pdo->prepare("UPDATE users SET role = :role WHERE id = :id");
    $update->execute([':role' => $role, ':id' => $id]);

    header('Location: ' . BASE_URL . '/dashboard?success=user_updated');
    exit();
}

$titlePage = "Modifier Utilisateur";
