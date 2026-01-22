<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-white">Gestion des Commentaires</h1>
        <a href="<?= BASE_URL ?>/dashboard" class="btn btn-outline-light"><i class="fas fa-arrow-left me-2"></i>Retour
            Dashboard</a>
    </div>

    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['success_message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert"><?= $_SESSION['error_message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['error_message']); ?>

    <?php endif; ?>

    <div class="card bg-dark border-secondary text-light">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-dark table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>Auteur</th>
                            <th>Commentaire</th>
                            <th>Article lié</th>
                            <th>État</th>
                            <th>Date</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($comments)): ?>
                            <tr>
                                <td colspan="6" class="text-center">Aucun commentaire à afficher.</td>
                            </tr>
                        <?php endif; ?>
                        <?php foreach ($comments as $comment): ?>
                            <tr>
                                <td>
                                    <span class="badge bg-secondary">
                                            <?= htmlspecialchars($comment['username']) ?>
                                    </span>
                                </td>
                                <td style="max-width: 400px;">
                                    <p class="mb-0" title="<?= htmlspecialchars($comment['content']) ?>">
                                            <?= htmlspecialchars(mb_strimwidth($comment['content'], 0, 80, "...")) ?>
                                    </p>
                                </td>
                                <td>
                                    <a href="<?= BASE_URL ?>/post/<?= $comment['post_slug'] ?>"
                                        class="text-decoration-none text-info fw-bold" target="_blank">
                                            <?= htmlspecialchars($comment['post_title']) ?>
                                    </a>
                                </td>
                                <td>
                                        <?php if ($comment['status_comment'] == 1): ?>
                                        <span class="badge bg-success">Approuvé</span>
                                        <?php else: ?>
                                        <span class="badge bg-warning text-dark">En attente</span>
                                        <?php endif; ?>
                                </td>
                                <td>
                                        <?= date('d/m/y H:i', strtotime($comment['created_at'])) ?>
                                </td>
                                <td class="text-end">
                                    <a href="<?= BASE_URL ?>/admin-approve-comment?id=<?= $comment['id'] ?>"
                                        class="btn btn-sm btn-outline-success me-1" title="Approuver"><i
                                            class="fas fa-check"></i></a>
                                    <a href="<?= BASE_URL ?>/admin-hold-comment?id=<?= $comment['id'] ?>"
                                        class="btn btn-sm btn-outline-warning me-1" title="Mettre en attente"><i
                                            class="fas fa-clock"></i></a>
                                    <a href="<?= BASE_URL ?>/admin-delete-comment?id=<?= $comment['id'] ?>"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Supprimer ce commentaire définitivement ?')"
                                        title="Supprimer"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>