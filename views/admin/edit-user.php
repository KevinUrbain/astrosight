<div class="container py-5">
    <div class="col-md-6 mx-auto">
        <div class="card bg-dark border-secondary text-white">
            <div class="card-header">Modifier le rôle de
                <?= htmlspecialchars($userEdit['username']) ?>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label>Rôle</label>
                        <select name="role" class="form-select">
                            <option value="member" <?= $userEdit['role'] === 'member' ? 'selected' : '' ?>>Membre</option>
                            <option value="admin" <?= $userEdit['role'] === 'admin' ? 'selected' : '' ?>>Administrateur
                            </option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Sauvegarder</button>
                    <a href="<?= BASE_URL ?>/dashboard" class="btn btn-secondary">Annuler</a>
                </form>
            </div>
        </div>
    </div>
</div>