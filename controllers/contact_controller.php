<?php
//Securité dans le cas où on ne vient pas de l'index
if (!defined('ROOT')) {
    http_response_code(403);
    exit('Accès interdit');
}

$errors = [];
$success = null;

$name = '';
$email = '';
$subject = '';
$message = '';

if (isset($_SESSION['user'])) {
    $name = $_SESSION['user']['username'];
    $email = $_SESSION['user']['email'];
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $name = trim($_POST['name'] ?? '');
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');


    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $errors[] = "Tous les champs sont obligatoires.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'adresse email n'est pas valide.";
    }

    if (strlen($message) < 10) {
        $errors[] = "Votre message est trop court.";
    }

    //  Envoi d'email
    if (empty($errors)) {
        require_once __DIR__ . '/../services/MailerService.php';


        if (MailerService::sendContactEmail($email, $name, $message, $subject)) {

            if (!isset($_SESSION['user'])) {
                $name = $email = '';
            }
            $subject = $message = '';

            $_SESSION['flash_success'] = "Merci " . htmlspecialchars($name) . " ! Votre message a bien été transmis. Nous vous répondrons sous 48h.";
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit();

            if (!isset($_SESSION['user'])) {
                $name = $email = '';
            }
            $subject = $message = '';

        } else {
            $errors[] = "Une erreur technique est survenue lors de l'envoi. Veuillez réessayer plus tard.";
        }
    }
}
