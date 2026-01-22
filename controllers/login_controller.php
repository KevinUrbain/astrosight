<?php
//Securité dans le cas où on ne vient pas de l'index
if (!defined('ROOT')) {
    http_response_code(403);
    exit('Accès interdit');
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';

    if (!empty($email) && !empty($password)) {

        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);


        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'firstname' => $user['first_name'],
                'lastname' => $user['last_name'],
                'username' => $user['username'],
                'email' => $user['email'],
                'role' => $user['role'],
                'avatar' => $user['avatar'] ?? 'default.jpg'
            ];

            header('Location: ' . BASE_URL . '/home');
            exit();

        } else {
            $errors[] = "Identifiants incorrects.";
        }
    } else {
        $errors[] = "Veuillez remplir tous les champs.";
    }
}
