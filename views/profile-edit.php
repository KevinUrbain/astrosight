<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="card bg-dark border-secondary text-white">
                <div class="card-header border-secondary">
                    <h1 class="h3 mb-0"><i class="fas fa-user-edit me-2"></i>Modifier mon profil</h1>
                </div>

                <div class="card-body p-4">

                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0 ps-3">
                                <?php foreach ($errors as $e): ?>
                                    <li><?= htmlspecialchars($e) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?php if ($success): ?>
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i><?= $success ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" enctype="multipart/form-data">
                        <div class="row">

                            <div class="col-md-4 text-center mb-4 mb-md-0">
                                <label class="form-label d-block fw-bold">Photo de profil</label>

                                <div class="mb-3 position-relative d-inline-block">
                                    <img src="<?= BASE_URL ?>/uploads/img-avatar/<?= htmlspecialchars($user['avatar'] ?? 'default.jpg') ?>"
                                        alt="Avatar" class="rounded-circle border border-primary shadow"
                                        style="width: 150px; height: 150px; object-fit: cover;" id="avatar-preview">
                                </div>

                                <div class="mt-2">
                                    <label for="avatar-input" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-camera me-2"></i>Changer
                                    </label>
                                    <input type="file" name="avatar" id="avatar-input" class="d-none" accept="image/*"
                                        onchange="previewImage(this)">
                                </div>
                                <div class="form-text text-white-50 small mt-2">Format JPG, PNG, WEBP. Max 2Mo.</div>
                            </div>

                            <div class="col-md-8">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Pseudo *</label>
                                        <input type="text" name="username"
                                            class="form-control bg-dark text-white border-secondary"
                                            value="<?= htmlspecialchars($user['username'], ENT_QUOTES) ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Email *</label>
                                        <input type="email" name="email"
                                            class="form-control bg-dark text-white border-secondary"
                                            value="<?= htmlspecialchars($user['email'], ENT_QUOTES) ?>" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Prénom *</label>
                                        <input type="text" name="firstname"
                                            class="form-control bg-dark text-white border-secondary"
                                            value="<?= htmlspecialchars($user['first_name'], ENT_QUOTES) ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Nom *</label>
                                        <input type="text" name="lastname"
                                            class="form-control bg-dark text-white border-secondary"
                                            value="<?= htmlspecialchars($user['last_name'], ENT_QUOTES) ?>" required>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Bio (Quelques mots sur vous)</label>
                                        <textarea name="bio" class="form-control bg-dark text-white border-secondary"
                                            rows="3"><?= htmlspecialchars($user['bio'], ENT_QUOTES) ?></textarea>
                                    </div>

                                    <div class="col-12 mt-4">
                                        <hr class="border-secondary">
                                        <h5 class="text-white-50 fs-6">Sécurité (Optionnel)</h5>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label">Nouveau mot de passe</label>
                                        <input type="password" name="password"
                                            class="form-control bg-dark text-white border-secondary"
                                            placeholder="Laisser vide pour ne pas changer">
                                    </div>
                                </div>

                                <div class="mt-4 text-end">
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="fas fa-save me-2"></i>Enregistrer les modifications
                                    </button>
                                </div>
                            </div>

                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // Prévisualiser l'avatar dès qu'on choisit un fichier
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('avatar-preview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>