<?php
//Securité dans le cas où on ne vient pas de l'index
if (!defined('ROOT')) {
    http_response_code(403);
    exit('Accès interdit');
}

$errors = [];
$username = '';
$email = '';
$firstname = '';
$lastname = '';
$bio = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $firstname = trim($_POST['firstname'] ?? '');
    $lastname = trim($_POST['lastname'] ?? '');
    $bio = trim($_POST['bio'] ?? '');
    $password = $_POST['password'] ?? '';

    $filename = 'default.jpg';


    if (isset($_FILES['image_post']) && $_FILES['image_post']['error'] !== UPLOAD_ERR_NO_FILE) {

        $avatar = $_FILES['image_post'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $uploadDir = ROOT . '/uploads/img-avatar/';

        // Vérification des erreurs d'upload (autres que "pas de fichier")
        if ($avatar['error'] !== UPLOAD_ERR_OK) {
            $errors[] = "Erreur lors de l'envoi de l'image.";
        } elseif ($avatar['size'] > 2 * 1024 * 1024) {
            $errors[] = "L'image ne doit pas dépasser 2 Mo.";
        } elseif (!in_array($avatar['type'], $allowedTypes)) {
            $errors[] = "Format non autorisé: png, jpeg, gif uniquement.";
        } else {
            $newFilename = uniqid() . '_' . basename($avatar['name']);
            $destination = $uploadDir . $newFilename;

            if (move_uploaded_file($avatar['tmp_name'], $destination)) {
                // Si l'upload réussit, on met à jour le nom de fichier à insérer en BDD
                $filename = $newFilename;
            } else {
                $errors[] = "Erreur lors de l'enregistrement de l'image sur le serveur.";
            }
        }
    }

    if (empty($username)) {
        $errors[] = 'Le pseudo est obligatoire.';
    }
    if (empty($firstname) || empty($lastname)) {
        $errors[] = 'Le nom et le prénom sont obligatoires.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'adresse email n'est pas valide.";
    }
    if (strlen($password) < 8) {
        $errors[] = 'Le mot de passe doit contenir au moins 8 caractères.';
    }


    if (empty($errors)) {
        try {
            $sqlCheck = "SELECT id FROM users WHERE email = :email";
            $stmtCheck = $pdo->prepare($sqlCheck);
            $stmtCheck->execute(['email' => $email]);

            if ($stmtCheck->fetch()) {
                $errors[] = "L'email est déjà utilisé.";
            } else {
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                $sql = "INSERT INTO users (username, email, first_name, last_name, bio, password, avatar) VALUES (:username, :email, :first_name, :last_name, :bio, :password, :avatar)";
                $stmt = $pdo->prepare($sql);

                $success = $stmt->execute([
                    'username' => $username,
                    'email' => $email,
                    'first_name' => $firstname,
                    'last_name' => $lastname,
                    'bio' => $bio,
                    'password' => $passwordHash,
                    'avatar' => $filename // Sera soit l'image uploadée, soit 'default.jpg'
                ]);

                if ($success) {
                    $_SESSION['success_message'] = 'true';
                    header('Location: ' . BASE_URL . '/login&register=success');
                    exit;
                }
            }
        } catch (PDOException $e) {
            log_error($e);
            $errors[] = "Une erreur technique est survenue lors de l'inscription.";
        }
    }
}