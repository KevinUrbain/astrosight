<?php defined('ROOT') || exit('Accès interdit'); ?>
<!doctype html>
<html lang="fr" data-bs-theme="dark">
<?php require_once ROOT . '/templates/head.php'; ?>

<body>
    <?php require_once ROOT . '/templates/nav.php'; ?>

    <?php
    // header que pour les pages qui ne sont pas dans le back-office
    if (strpos($page, 'admin') !== 0) {
        require_once ROOT . '/templates/header.php';
    }
    ?>

    <?php require_once ROOT . '/views/' . $contentView . '.php'; ?>

    <?php require_once ROOT . '/templates/footer.php'; ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>