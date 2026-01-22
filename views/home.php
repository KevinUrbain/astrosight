<!-- =========================================================================================================================== -->

<div class="container py-5">

    <div class="row mb-5 align-items-center">
        <div class="col-md-6">
            <h1 class="text-white fw-bold">Dernières Observations</h1>
            <p class="text-white-50">Explorez l'univers à travers les yeux de la communauté.</p>
        </div>
        <div class="col-md-6">
            <form action="<?= BASE_URL ?>/home" method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control bg-dark text-white border-secondary"
                    placeholder="Rechercher une nébuleuse, une planète..."
                    value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                </button>
                <?php if (isset($_GET['search'])): ?>
                    <a href="<?= BASE_URL ?>/home" class="btn btn-outline-secondary" title="Effacer la recherche">
                        <i class="fas fa-times"></i>
                    </a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <?php if (empty($posts)): ?>
        <div class="alert alert-info text-center py-5">
            <i class="fas fa-telescope fa-3x mb-3 text-info"></i>
            <h3>Aucune observation trouvée.</h3>
            <p>Essayez un autre mot-clé ou revenez plus tard.</p>
            <a href="<?= BASE_URL ?>/home" class="btn btn-outline-light mt-2">Voir tous les posts</a>
        </div>
    <?php else: ?>

        <div class="row g-4">
            <?php foreach ($posts as $post): ?>
                <div class="col-md-4">
                    <article class="blog-card h-100">
                        <div class="card-img-wrapper">
                            <?php
                            $imgSrc = !empty($post['featured_image'])
                                ? BASE_URL . '/public/uploads/posts/' . htmlspecialchars($post['featured_image'])
                                : BASE_URL . '/public/uploads/posts/' . 'default-image.png';
                            ?>
                            <img src="<?= $imgSrc ?>" class="card-img-top img-fluid"
                                alt="<?= htmlspecialchars($post['title']) ?>" style="height: 200px; object-fit: cover;" />
                        </div>

                        <div class="card-body p-0">
                            <div class="category-line text-uppercase">
                                <?= htmlspecialchars($post['category']) ?>
                            </div>

                            <h3 class="card-title">
                                <?= htmlspecialchars($post['title']) ?>
                            </h3>

                            <p class="card-text">
                                <?= excerpt($post['content'], 100) ?>
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="<?= BASE_URL ?>/post/<?= htmlspecialchars($post['slug']) ?>" class="read-more">
                                    <i class="fas fa-arrow-right"></i> Voir détails
                                </a>
                                <span class="text-white-50 small" title="Nombre de commentaires">
                                    <i class="far fa-comments me-1"></i>
                                    <?= $post['comment_count'] ?>
                                </span>
                            </div>
                        </div>

                    </article>
                </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>

</div>