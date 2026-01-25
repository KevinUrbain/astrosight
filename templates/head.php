<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1" />

    <?php
    // --- 1. LOGIQUE SEO AUTOMATIQUE ---
    
    // Valeurs par défaut
    $seoTitle = $titleSite ?? 'AstroSight - Communauté Astronomie';
    // $metaDescription est déjà défini dans index.php
    $seoImage = BASE_URL . '/public/assets/img/social-share-astrosight.jpg';
    $ogType = 'website';

    // Logique spécifique pour les pages de post
    if (isset($post) && !empty($post)) {
        $seoTitle = htmlspecialchars($post['title'], ENT_QUOTES) . ' - AstroSight';


        if (function_exists('excerpt')) {
            $cleanContent = str_replace(["\r", "\n"], ' ', strip_tags($post['content']));
            $metaDescription = htmlspecialchars(excerpt($cleanContent, 155), ENT_QUOTES);
        }

        if (!empty($post['featured_image'])) {
            $seoImage = BASE_URL . '/public/uploads/posts/' . htmlspecialchars($post['featured_image'], ENT_QUOTES);
        }

        $ogType = 'article';
    }

    // Construction de l'URL canonique propre (sans query string)
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    $uri = strtok($_SERVER['REQUEST_URI'], '?');
    $canonicalUrl = $protocol . "://" . $host . $uri;
    ?>

    <title><?= $seoTitle ?></title>
    <meta name="description"
        content="<?= $metaDescription ?? 'Découvrez et partagez des observations astronomiques avec la communauté AstroSight.' ?>">
    <meta name="author" content="AstroSight Community">
    <link rel="canonical" href="<?= $canonicalUrl ?>" />

    <meta name="theme-color" content="#212529">
    <meta name="msapplication-navbutton-color" content="#212529">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <meta property="og:type" content="<?= $ogType ?>">
    <meta property="og:url" content="<?= $canonicalUrl ?>">
    <meta property="og:title" content="<?= $seoTitle ?>">
    <meta property="og:description"
        content="<?= $metaDescription ?? 'Découvrez et partagez des observations astronomiques avec la communauté AstroSight.' ?>">
    <meta property="og:image" content="<?= $seoImage ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="AstroSight">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= $seoTitle ?>">
    <meta name="twitter:description"
        content="<?= $metaDescription ?? 'Découvrez et partagez des observations astronomiques avec la communauté AstroSight.' ?>">
    <meta name="twitter:image" content="<?= $seoImage ?>">

    <link rel="icon" type="image/svg+xml" href="<?= BASE_URL ?>/public/assets/favicon/moon-solid-full.svg">
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>/public/assets/favicon/moon-solid-full.png">
    <link rel="apple-touch-icon" href="<?= BASE_URL ?>/public/assets/favicon/apple-touch-icon.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link
        href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;700&family=Roboto+Condensed:wght@400;700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/styles.css" />

    <?php if (isset($post) && !empty($post)):
        // On construit un tableau PHP propre
        //JSON-LD
        $schemaData = [
            "@context" => "https://schema.org",
            "@type" => "BlogPosting", // Plus spécifique que "Article"
            "mainEntityOfPage" => [
                "@type" => "WebPage",
                "@id" => $canonicalUrl
            ],
            "headline" => $post['title'],
            "image" => [$seoImage],
            "datePublished" => date('c', strtotime($post['created_at'])),
            "dateModified" => date('c', strtotime($post['updated_at'] ?? $post['created_at'])),
            "author" => [
                "@type" => "Person",
                "name" => $post['username'] ?? 'Membre AstroSight'
            ],
            "publisher" => [
                "@type" => "Organization",
                "name" => "AstroSight",
                "logo" => [
                    "@type" => "ImageObject",
                    "url" => BASE_URL . '/public/assets/favicon/moon-solid-full.png'
                ]
            ]
        ];
        ?>
        <script type="application/ld+json">
                    <?= json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>
                </script>
    <?php endif; ?>

</head>