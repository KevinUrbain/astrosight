<?php if (empty($posts)): ?>
    <div class="alert alert-danger text-center container">Aucun posts pour le moment !</div>
<?php else: ?>
    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-white">Mes publications</h2>
                <a href="<?= BASE_URL ?>/add-post" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Nouvelle observation
                </a>
            </div>

            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success">Action effectuée avec succès !</div>
            <?php endif; ?>

            <?php if (empty($posts)): ?>
                <div class="alert alert-info bg-dark border-secondary text-white">
                    Vous n'avez posté aucune observation pour le moment.
                </div>
            <?php else: ?>
                <div class="card bg-dark border-secondary">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th style="width: 80px;">Image</th>
                                    <th>Titre</th>
                                    <th>Catégorie</th>
                                    <th>Statut</th>
                                    <th>Date</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($posts as $post): ?>
                                    <tr>
                                        <td>
                                            <img src="<?= BASE_URL ?>/public/uploads/posts/<?= htmlspecialchars($post['featured_image']) ?>"
                                                alt="Aperçu" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                        </td>
                                        <td class="fw-bold text-white">
                                            <a href="<?= BASE_URL ?>/post/<?= htmlspecialchars($post['slug']) ?>">
                                                <?= htmlspecialchars($post['title']) ?>
                                            </a>

                                        </td>
                                        <td><span class="badge bg-secondary">
                                                <?= htmlspecialchars($post['category']) ?>
                                            </span></td>
                                        <td><?= $post['status_post'] === 0 ? 'Brouillon' : 'Publié' ?></td>
                                        <td class="text-white-50">
                                            <?= date('d/m/Y', strtotime($post['created_at'])) ?>
                                        </td>
                                        <td class="text-end">
                                            <a href="<?= BASE_URL ?>/edit-post?id=<?= $post['id'] ?>"
                                                class="btn btn-sm btn-outline-info me-1" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <?php if ($post['status_post'] == 1): ?>
                                                <a href="<?= BASE_URL ?>/delete-post?id=<?= $post['id'] ?>&action=draft"
                                                    class="btn btn-sm btn-outline-warning me-1" title="Mettre en brouillon (Cacher)">
                                                    <i class="fas fa-eye-slash"></i>
                                                </a>
                                            <?php else: ?>
                                                <a href="<?= BASE_URL ?>/delete-post?id=<?= $post['id'] ?>&action=publish"
                                                    class="btn btn-sm btn-outline-success me-1" title="Publier maintenant"
                                                    style="<?= $isAdmin ? '' : 'display:none;' ?>">
                                                    <i class="fas fa-check"></i>
                                                </a>
                                            <?php endif; ?>

                                            <a href="<?= BASE_URL ?>/delete-post?id=<?= $post['id'] ?>&action=delete"
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce post ? Il ne sera plus visible.')"
                                                title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>