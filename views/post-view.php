<div class="position-relative w-100" style="height: 400px; overflow: hidden;">
    <?php
    $heroImg = BASE_URL . '/public/uploads/posts/' . htmlspecialchars($post['featured_image']);
    ?>
    <div style="background-image: url('<?= $heroImg ?>'); 
                background-size: cover; 
                background-position: center; 
                filter: blur(8px) brightness(0.4); 
                position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index: 0;">
    </div>

    <div class="container h-100 position-relative d-flex flex-column justify-content-center align-items-center text-center"
        style="z-index: 1;">
        <span class="badge bg-primary mb-2">
            <?= htmlspecialchars($post['category']) ?>
        </span>
        <h1 class="display-4 fw-bold text-white">
            <?= htmlspecialchars($post['title']) ?>
        </h1>

        <div class="mt-3 text-white-50 d-flex align-items-center gap-3">
            <div class="d-flex align-items-center">
                <img src="<?= BASE_URL ?>/uploads/img-avatar/<?= htmlspecialchars($post['avatar'] ?? 'default.jpg') ?>"
                    class="rounded-circle border border-white me-2" width="30" height="30" alt="Avatar">
                <span>Par
                    <?= htmlspecialchars($post['username']) ?>
                </span>
            </div>
            <span>•</span>
            <span><i class="far fa-calendar me-1"></i>
                <?= $formattedDate ?>
            </span>
            <?php if ($post['country'] && $post['city']): ?>
                <span>•</span>
                <span><i class="fas fa-map-marker-alt me-1"></i>
                    <?= htmlspecialchars($post['country']) . ', ' . htmlspecialchars($post['city']) ?>
                </span>
            <?php endif; ?>
        </div>
    </div>
</div>

<section class="py-5">
    <div class="container">
        <div class="row g-5">

            <div class="col-lg-8">

                <img src="<?= $heroImg ?>" class="img-fluid rounded shadow-lg mb-5 w-100" alt="Main View">

                <div class="article-content text-white">
                    <p class="lead">
                        <?= nl2br(htmlspecialchars($post['content'])) ?>
                    </p>
                </div>

                <?php if (!empty($galleryImages)): ?>
                    <h3 class="text-white mt-5 mb-4 border-bottom pb-2 border-secondary">Galerie d'acquisition</h3>
                    <div class="row g-3">
                        <?php foreach ($galleryImages as $img): ?>
                            <?php if ($img !== $post['featured_image']): ?>
                                <div class="col-6 col-md-4">
                                    <a href="<?= BASE_URL ?>/public/uploads/posts/<?= htmlspecialchars($img) ?>" target="_blank">
                                        <img src="<?= BASE_URL ?>/public/uploads/posts/<?= htmlspecialchars($img) ?>"
                                            class="img-fluid rounded border border-secondary"
                                            style="height: 150px; width: 100%; object-fit: cover; transition: transform 0.2s;"
                                            onmouseover="this.style.transform='scale(1.05)'"
                                            onmouseout="this.style.transform='scale(1)'">
                                    </a>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] === $post['user_id']): ?>
                    <div
                        class="mt-5 p-3 bg-dark border border-secondary rounded d-flex justify-content-between align-items-center">
                        <span class="text-white-50">Ceci est votre observation.</span>
                        <div>
                            <a href="<?= BASE_URL ?>/edit-post?id=<?= $post['id'] ?>"
                                class="btn btn-outline-info me-2">Modifier</a>
                            <a href="<?= BASE_URL ?>/delete-post?id=<?= $post['id'] ?>" class="btn btn-outline-danger"
                                onclick="return confirm('Supprimer ?')">Supprimer</a>
                        </div>
                    </div>
                <?php endif; ?>

                <hr class="border-secondary my-5">

                <div id="comments-section">
                    <h3 class="text-white mb-4">
                        <i class="far fa-comments me-2 text-primary"></i>
                        Commentaires <span
                            class="badge bg-dark border border-secondary ms-2 fs-6"><?= count($comments) ?></span>
                    </h3>

                    <?php if (isset($_SESSION['user'])): ?>
                        <div class="card bg-dark border-secondary mb-5">
                            <div class="card-body">
                                <h5 class="card-title text-white mb-3">Participer à la discussion</h5>

                                <?php if (isset($commentSuccess) && $commentSuccess): ?>
                                    <div class="alert alert-success py-2"><?= $commentSuccess ?></div>
                                <?php endif; ?>
                                <?php if (isset($commentError) && $commentError): ?>
                                    <div class="alert alert-danger py-2"><?= $commentError ?></div>
                                <?php endif; ?>

                                <form action="" method="POST">
                                    <div class="mb-3">
                                        <textarea name="content" class="form-control form-control-light" rows="3"
                                            placeholder="Une question ? Une remarque sur le matériel ?..."
                                            required></textarea>
                                    </div>
                                    <div class="text-end">
                                        <button type="submit" name="submit_comment" class="btn btn-primary">
                                            <i class="fas fa-paper-plane me-2"></i>Envoyer
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info bg-dark border-secondary text-white mb-5 d-flex align-items-center">
                            <i class="fas fa-lock me-3 fa-2x"></i>
                            <div>
                                Vous devez être <a href="<?= BASE_URL ?>/login" class="fw-bold text-info">connecté</a> pour
                                poster un commentaire.
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="comments-list">
                        <?php if (empty($comments)): ?>
                            <p class="text-white-50 fst-italic">Soyez le premier à commenter cette observation !</p>
                        <?php else: ?>
                            <?php foreach ($comments as $com): ?>
                                <div class="d-flex mb-4">
                                    <div class="flex-shrink-0">
                                        <img src="<?= BASE_URL ?>/uploads/img-avatar/<?= htmlspecialchars($com['avatar'] ?? 'default.jpg') ?>"
                                            class="rounded-circle border border-secondary" width="50" height="50" alt="Avatar">
                                    </div>

                                    <div class="flex-grow-1 ms-3">
                                        <div class="bg-dark border border-secondary rounded p-3">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div>
                                                    <span class="fw-bold text-white me-2">
                                                        <?= htmlspecialchars($com['username']) ?>
                                                    </span>

                                                    <span class="badge bg-secondary text-dark" style="font-size: 0.7rem;"
                                                        title="Nombre d'observations publiées">
                                                        <i class="fas fa-camera me-1"></i><?= $com['nb_posts'] ?>
                                                    </span>
                                                </div>

                                                <small class="text-white-50">
                                                    <?= date('d/m/Y à H:i', strtotime($com['created_at'])) ?>
                                                </small>
                                            </div>

                                            <p class="text-white mb-0">
                                                <?= htmlspecialchars($com['content'], ENT_QUOTES) ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card bg-dark border-secondary sticky-top" style="top: 20px;">
                    <div class="card-header border-secondary bg-black bg-opacity-25">
                        <h4 class="card-title h5 text-white mb-0"><i
                                class="fas fa-sliders-h me-2 text-primary"></i>Détails Techniques</h4>
                    </div>
                    <div class="card-body">

                        <h6 class="text-uppercase text-white-50 fs-7 fw-bold mb-3 mt-1">Matériel (Setup)</h6>
                        <ul class="list-unstyled text-white mb-4">
                            <?php if ($post['telescope']): ?>
                                <li class="mb-2 d-flex justify-content-between">
                                    <span class="text-white-50">Optique</span>
                                    <span class="fw-bold text-end">
                                        <?= htmlspecialchars($post['telescope']) ?>
                                    </span>
                                </li>
                            <?php endif; ?>
                            <?php if ($post['camera']): ?>
                                <li class="mb-2 d-flex justify-content-between">
                                    <span class="text-white-50">Caméra</span>
                                    <span class="fw-bold text-end">
                                        <?= htmlspecialchars($post['camera']) ?>
                                    </span>
                                </li>
                            <?php endif; ?>
                            <?php if ($post['mount']): ?>
                                <li class="mb-2 d-flex justify-content-between">
                                    <span class="text-white-50">Monture</span>
                                    <span class="fw-bold text-end">
                                        <?= htmlspecialchars($post['mount']) ?>
                                    </span>
                                </li>
                            <?php endif; ?>
                            <?php if ($post['filters']): ?>
                                <li class="mb-2 d-flex justify-content-between">
                                    <span class="text-white-50">Filtres</span>
                                    <span class="fw-bold text-end">
                                        <?= htmlspecialchars($post['filters']) ?>
                                    </span>
                                </li>
                            <?php endif; ?>
                        </ul>

                        <hr class="border-secondary">

                        <h6 class="text-uppercase text-white-50 fs-7 fw-bold mb-3">Données d'acquisition</h6>
                        <ul class="list-unstyled text-white mb-0">
                            <?php if ($post['exposure_time']): ?>
                                <li class="mb-2"><i class="fas fa-stopwatch me-2 text-info"></i> <strong>Pose unitaire
                                        :</strong>
                                    <?= htmlspecialchars($post['exposure_time']) ?>
                                </li>
                            <?php endif; ?>
                            <?php if ($post['exposure_count']): ?>
                                <li class="mb-2"><i class="fas fa-layer-group me-2 text-info"></i> <strong>Nombre de poses
                                        :</strong>
                                    <?= htmlspecialchars($post['exposure_count']) ?>
                                </li>
                            <?php endif; ?>
                            <?php if ($post['gain_iso']): ?>
                                <li class="mb-2"><i class="fas fa-adjust me-2 text-info"></i> <strong>ISO / Gain :</strong>
                                    <?= htmlspecialchars($post['gain_iso']) ?>
                                </li>
                            <?php endif; ?>
                            <?php if ($post['bortle_scale']): ?>
                                <li class="mb-2">
                                    <i class="fas fa-city me-2 text-warning"></i> <strong>Ciel (Bortle) :</strong>
                                    <span class="badge bg-warning text-dark">
                                        <?= htmlspecialchars($post['bortle_scale']) ?>
                                    </span>
                                </li>
                            <?php endif; ?>
                            <?php if ($post['soft_processing']): ?>
                                <li class="mb-2"><i class="fas fa-laptop-code me-2 text-info"></i> <strong>Logiciel
                                        :</strong>
                                    <?= htmlspecialchars($post['soft_processing']) ?>
                                </li>
                            <?php endif; ?>
                        </ul>

                        <?php if (empty($post['telescope']) && empty($post['exposure_time'])): ?>
                            <p class="text-muted small fst-italic">Aucune donnée technique renseignée pour cette
                                observation.</p>
                        <?php endif; ?>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>