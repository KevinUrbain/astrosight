<?php

function log_error(Throwable $e, $logFile = ROOT . '/log/error_log.txt')
{
    $message = date('Y-m-d H:i:s') . ' : ' . $e->getMessage() . ', errorCode=' . $e->getCode() . "\n";
    error_log($message, 3, $logFile);
}

/**
 * Coupe un texte à une longueur donnée sans couper les mots en plein milieu.
 * Idéal pour les résumés de cartes ou les meta descriptions SEO.
 *
 * @param string $text Le texte à raccourcir
 * @param int $limit Le nombre de caractères max (défaut 100)
 * @return string Le texte coupé avec "..." à la fin
 */
function excerpt(string $text, int $limit = 100): string
{

    $text = strip_tags($text);

    // On enlève les sauts de ligne inutiles pour avoir une seule ligne propre
    $text = str_replace(["\r", "\n"], ' ', $text);


    if (mb_strlen($text) <= $limit) {
        return $text;
    }


    $text = mb_substr($text, 0, $limit);


    $lastSpace = mb_strrpos($text, ' ');

    if ($lastSpace !== false) {
        $text = mb_substr($text, 0, $lastSpace);
    }

    return $text . '...';
}