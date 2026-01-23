<?php
// services/MailerService.php

// On importe les classes de la librairie installée via Composer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Si vous n'avez pas d'autoloader global, on charge celui de Composer manuellement
require_once __DIR__ . '/../vendor/autoload.php';

class MailerService
{

    public static function sendContactEmail($fromEmail, $fromName, $message, $subject = 'Nouveau message du site')
    {
        $mail = new PHPMailer(true);

        try {
            // 1. Configuration du Serveur (SMTP)
            $mail->isSMTP();
            $mail->Host = SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = SMTP_USER;
            $mail->Password = SMTP_PASS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = SMTP_PORT;
            $mail->CharSet = 'UTF-8';

            // 2. Destinataires
            // L'expéditeur réel DOIT être l'adresse authentifiée (règle anti-spam)
            $mail->setFrom(SMTP_USER, 'AstroSight Formulaire');
            // On ajoute l'adresse du visiteur en "Reply-To" pour pouvoir lui répondre directement
            $mail->addReplyTo($fromEmail, $fromName);
            // Destinataire (Vous)
            $mail->addAddress('contact@astrosight.be');

            // 3. Contenu
            $mail->isHTML(true);
            $mail->Subject = "[Contact] " . $subject;
            $mail->Body = "
                <h3>Nouveau message de $fromName</h3>
                <p><strong>Email :</strong> $fromEmail</p>
                <p><strong>Message :</strong></p>
                <div style='background:#f4f4f4; padding:10px; border-left: 4px solid #333;'>
                    " . nl2br(htmlspecialchars($message)) . "
                </div>
            ";

            // Version texte brut pour les vieux clients mail
            $mail->AltBody = "Message de $fromName ($fromEmail) : \n\n $message";

            $mail->send();
            return true;

        } catch (Exception $e) {
            // En prod, on log l'erreur mais on ne l'affiche pas à l'utilisateur
            error_log($mail->ErrorInfo);
            return false;
        }
    }
}