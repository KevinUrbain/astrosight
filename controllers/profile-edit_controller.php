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

$userId = $_SESSION['user']['id'];
$errors = [];
$success = null;


$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute([':id' => $userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    session_destroy();
    header('Location: ' . BASE_URL . '/login');
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username'] ?? '');
    $firstname = trim($_POST['firstname'] ?? '');
    $lastname = trim($_POST['lastname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $bio = trim($_POST['bio'] ?? '');
    $password = $_POST['password'] ?? '';


    if (empty($username) || empty($email) || empty($firstname) || empty($lastname)) {
        $errors[] = "Tous les champs obligatoires doivent être remplis.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format d'email invalide.";
    }

    $newAvatarName = $user['avatar']; // Par défaut, on garde l'ancien

    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] !== UPLOAD_ERR_NO_FILE) {
        $file = $_FILES['avatar'];
        $allowed = ['image/jpeg', 'image/png', 'image/webp'];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $errors[] = "Erreur lors de l'envoi de l'image.";
        } elseif (!in_array($file['type'], $allowed)) {
            $errors[] = "Format invalide (JPG, PNG, WEBP uniquement).";
        } elseif ($file['size'] > 2 * 1024 * 1024) {
            $errors[] = "L'image est trop lourde (max 2Mo).";
        } else {
            $uploadDir = ROOT . '/uploads/img-avatar/';
            $fileName = uniqid() . '_' . basename($file['name']);

            if (move_uploaded_file($file['tmp_name'], $uploadDir . $fileName)) {
                if ($user['avatar'] && $user['avatar'] !== 'default.jpg' && $user['avatar'] !== 'default-avatar.png') {
                    $oldFile = $uploadDir . $user['avatar'];
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }

                $newAvatarName = $fileName;
            } else {
                $errors[] = "Erreur technique lors de l'enregistrement de l'image.";
            }
        }
    }

    if (empty($errors)) {
        try {
            $sql = "UPDATE users SET 
                    username = :user,
                    first_name = :fn,
                    last_name = :ln,
                    email = :email,
                    bio = :bio,
                    avatar = :avatar";

            $params = [
                ':user' => $username,
                ':fn' => $firstname,
                ':ln' => $lastname,
                ':email' => $email,
                ':bio' => $bio,
                ':avatar' => $newAvatarName,
                ':id' => $userId
            ];

            if (!empty($password)) {
                if (strlen($password) < 8) {
                    $errors[] = "Le nouveau mot de passe doit faire au moins 8 caractères.";
                } else {
                    $sql .= ", password = :pwd";
                    $params[':pwd'] = password_hash($password, PASSWORD_DEFAULT);
                }
            }

            if (empty($errors)) {
                $sql .= " WHERE id = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute($params);

                // Mise à jour de la session
                $_SESSION['user']['username'] = $username;
                $_SESSION['user']['first_name'] = $firstname;
                $_SESSION['user']['avatar'] = $newAvatarName;
                $_SESSION['user']['email'] = $email;

                $user['username'] = $username;
                $user['first_name'] = $firstname;
                $user['last_name'] = $lastname;
                $user['email'] = $email;
                $user['bio'] = $bio;
                $user['avatar'] = $newAvatarName;

                $success = "Votre profil a été mis à jour avec succès !";
            }

        } catch (PDOException $e) {
            $errors[] = "Erreur SQL : " . $e->getMessage();
        }
    }
}

