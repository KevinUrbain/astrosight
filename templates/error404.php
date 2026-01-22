<?php defined('ROOT') || exit('Accès interdit'); ?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>404 - Page Not Found</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link
        href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;700&family=Roboto+Condensed:wght@400;700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/styles404.css" />
</head>

<body>
    <div class="error-page-wrapper">
        <div class="overlay"></div>

        <div class="content-layer top-logo">
            <a href="<?= BASE_URL ?>" class="brand-logo">
                <i class="fa fa-moon"></i> AstroSight
            </a>
        </div>

        <div class="content-layer main-error-content">
            <h1 class="error-code">404</h1>
            <h2 class="error-title">Page Not Found</h2>
            <p class="error-desc">
                You may have mistyped the address or the page may have moved.
            </p>
            <a href="<?= BASE_URL ?>" class="btn-home">Back to Home Page</a>
        </div>

        <div class="content-layer simple-footer">
            <p class="m-0">© 2026 All rights reserved.</p>
        </div>
    </div>
</body>

</html>