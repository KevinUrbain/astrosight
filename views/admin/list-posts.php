<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-white">Gestion des Posts</h1>
        <a href="<?= BASE_URL ?>/dashboard" class="btn btn-outline-light"><i class="fas fa-arrow-left me-2"></i>Retour
            Dashboard</a>
    </div>

    <div class="card bg-dark border-secondary text-light">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-dark table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Titre</th>
                            <th>Auteur</th>
                            <th>État</th>
                            <th>Date</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($allPosts as $post): ?>
                            <tr>
                                <td style="width: 60px;">
                                    <img src="<?= BASE_URL ?>/public/uploads/posts/<?= htmlspecialchars($post['featured_image']) ?>"
                                        class="rounded" width="40" height="40" style="object-fit:cover;">
                                </td>
                                <td>
                                    <a href="<?= BASE_URL ?>/post/<?= $post['slug'] ?>"
                                        class="text-decoration-none text-info fw-bold" target="_blank">
                                        <?= htmlspecialchars($post['title']) ?>
                                    </a>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">
                                        <?= htmlspecialchars($post['username']) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($post['is_deleted'] == 1): ?>
                                        <span class="badge bg-danger">Corbeille</span>
                                    <?php elseif ($post['status_post'] == 1): ?>
                                        <span class="badge bg-success">Publié</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Brouillon</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?= date('d/m/y', strtotime($post['created_at'])) ?>
                                </td>
                                <td class="text-end">
                                    <a href="<?= BASE_URL ?>/edit-post?id=<?= $post['id'] ?>"
                                        class="btn btn-sm btn-outline-info me-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= BASE_URL ?>/delete-post?id=<?= $post['id'] ?>"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Supprimer ce post définitivement ?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>