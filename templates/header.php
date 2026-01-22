<!-- HEADER -->
<section class="page-header mb-3">
    <div class="container">
        <hgroup>
            <h1 class="page-title"><?= $titlePage ?></h1>
            <p>
                <?= $contentTitle ?>
            </p>
        </hgroup>
        <?php if (isset($_SESSION['user'])): ?>
            <a href="<?= BASE_URL ?>/add-post" class="read-more">
                <i class="fas fa-arrow-right"></i>Commencez à publier
            </a>
        <?php else: ?>
            <a href="<?= BASE_URL ?>/register" class="read-more">
                <i class="fas fa-arrow-right"></i>Commencez à publier
            </a>
        <?php endif; ?>
    </div>
</section>
<!-- HEADER -->