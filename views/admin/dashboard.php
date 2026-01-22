<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-white">Dashboard</h1>
        <div class="d-flex align-items-center gap-3">
            <span class="badge bg-warning text-dark">
                Admin : <?= htmlspecialchars($_SESSION['user']['username'] ?? 'Moi') ?>
            </span>
            <a href="<?= BASE_URL ?>/admin-list-comments" class="btn btn-outline-light">
                <i class="fas fa-comments me-2"></i>Gérer les commentaires
            </a>
            <a href="<?= BASE_URL ?>/admin-list-posts" class="btn btn-outline-light">
                <i class="fas fa-list me-2"></i>Voir la liste des posts
            </a>
        </div>
    </div>

    <div class="card bg-dark border-secondary text-light">
        <div class="card-header border-secondary">
            <h3 class="card-title h5 mb-0"><i class="fas fa-users me-2"></i>Liste des utilisateurs</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-dark table-hover mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Utilisateur</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Inscrit le</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td>#<?= $user['id'] ?></td>
                                <td><?= htmlspecialchars($user['username']) ?></td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td>
                                    <?php if ($user['role'] === 'admin'): ?>
                                        <span class="badge bg-danger">Admin</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Membre</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= date('d/m/Y', strtotime($user['created_at'])) ?></td>
                                <td>
                                    <a href="<?= BASE_URL ?>/?page=admin-edit-user&id=<?= $user['id'] ?>"
                                        class="btn btn-sm btn-outline-info me-1">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <?php if ($user['id'] != $_SESSION['user']['id']): ?>
                                        <a href="<?= BASE_URL ?>/?page=admin-delete-user&id=<?= $user['id'] ?>"
                                            class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Attention : Cette action est irréversible. Supprimer cet utilisateur supprimera aussi tous ses posts. Continuer ?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    <?php else: ?>
                                        <button class="btn btn-sm btn-secondary" disabled
                                            title="Vous ne pouvez pas vous supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>