<section class="py-5">
    <div class="container">
        <h2 class="mb-4 text-white">Modifier l'observation : <?= htmlspecialchars($post['title']) ?></h2>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0 ps-3">
                    <?php foreach ($errors as $e): ?>
                        <li><?= htmlspecialchars($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>/edit-post?id=<?= $post['id'] ?>" method="POST" enctype="multipart/form-data">

            <div class="row g-5">

                <div class="col-lg-8">

                    <ul class="nav nav-tabs mb-4" id="editTab" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" id="general-tab" data-bs-toggle="tab"
                                data-bs-target="#general" type="button"><i
                                    class="fas fa-info-circle me-2"></i>Général</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="equipment-tab" data-bs-toggle="tab" data-bs-target="#equipment"
                                type="button"><i class="fas fa-microscope me-2"></i>Matériel</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="acquisition-tab" data-bs-toggle="tab"
                                data-bs-target="#acquisition" type="button"><i
                                    class="fas fa-clock me-2"></i>Acquisition</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="editTabContent">

                        <div class="tab-pane fade show active" id="general">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label text-white">Titre *</label>
                                    <input type="text" name="title" class="form-control form-control-light"
                                        value="<?= htmlspecialchars($post['title']) ?>" required>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label text-white">Description *</label>
                                    <textarea name="content" class="form-control form-control-light" rows="5"
                                        required><?= htmlspecialchars($post['content']) ?></textarea>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label text-white">Image de couverture actuelle</label>
                                    <div class="mb-2">
                                        <img src="<?= BASE_URL ?>/public/uploads/posts/<?= htmlspecialchars($post['featured_image']) ?>"
                                            alt="Actuelle" class="img-thumbnail bg-dark" style="height: 100px;">
                                    </div>
                                    <label class="form-label text-white mt-2">Ajouter des images (laisser vide pour ne
                                        pas changer)</label>
                                    <input type="file" name="images[]" id="image-input"
                                        class="form-control form-control-light" multiple accept="image/*">
                                    <div class="form-text text-white-50">Les nouvelles images s'ajouteront à la galerie
                                        existante.</div>
                                </div>

                                <div class="col-md-12">
                                    <div id="preview-container" class="row g-2 mt-2"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label text-white">Catégorie *</label>
                                    <select name="category" class="form-select form-control-light">
                                        <option value="Observation" <?= $post['category'] == 'Observation' ? 'selected' : '' ?>>Observation Visuelle</option>
                                        <option value="Astrophoto" <?= $post['category'] == 'Astrophoto' ? 'selected' : '' ?>>Astrophoto Ciel Profond</option>
                                        <option value="Planetaire" <?= $post['category'] == 'Planetaire' ? 'selected' : '' ?>>Planétaire</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label text-white">Pays</label>
                                    <input type="text" name="country" class="form-control form-control-light"
                                        placeholder="ex: France"
                                        value="<?= htmlspecialchars($post['country'] ?? '') ?>">
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label text-white">Ville</label>
                                    <input type="text" name="city" class="form-control form-control-light"
                                        placeholder="ex: Marseille"
                                        value="<?= htmlspecialchars($post['city'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="mt-4 text-end">
                                <button type="button" class="btn btn-outline-light btn-next"
                                    data-next="equipment-tab">Suivant <i class="fas fa-arrow-right ms-2"></i></button>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="equipment">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label text-white">Télescope / Objectif</label>
                                    <input type="text" name="telescope" class="form-control form-control-light"
                                        value="<?= htmlspecialchars($post['telescope'] ?? '') ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-white">Caméra Principale</label>
                                    <input type="text" name="camera" class="form-control form-control-light"
                                        value="<?= htmlspecialchars($post['camera'] ?? '') ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-white">Diamètre en mm</label>
                                    <input type="number" name="diameter" class="form-control form-control-light"
                                        value="<?= htmlspecialchars($post['diameter'] ?? '') ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-white">Longueur Focale en mm</label>
                                    <input type="number" name="focal_length" class="form-control form-control-light"
                                        value="<?= htmlspecialchars($post['focal_length'] ?? '') ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-white">Monture</label>
                                    <input type="text" name="mount" class="form-control form-control-light"
                                        value="<?= htmlspecialchars($post['mount'] ?? '') ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-white">Filtres</label>
                                    <input type="text" name="filters" class="form-control form-control-light"
                                        value="<?= htmlspecialchars($post['filters'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="mt-4 d-flex justify-content-between">
                                <button type="button" class="btn btn-outline-secondary btn-prev"
                                    data-prev="general-tab"><i class="fas fa-arrow-left me-2"></i> Précédent</button>
                                <button type="button" class="btn btn-outline-light btn-next"
                                    data-next="acquisition-tab">Suivant <i class="fas fa-arrow-right ms-2"></i></button>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="acquisition">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label text-white">Temps de pose</label>
                                    <input type="text" name="exposure_time" class="form-control form-control-light"
                                        value="<?= htmlspecialchars($post['exposure_time'] ?? '') ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label text-white">Nombre de poses</label>
                                    <input type="number" name="exposure_count" class="form-control form-control-light"
                                        value="<?= htmlspecialchars($post['exposure_count'] ?? '') ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label text-white">ISO / Gain</label>
                                    <input type="text" name="gain_iso" class="form-control form-control-light"
                                        value="<?= htmlspecialchars($post['gain_iso'] ?? '') ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-white">Logiciel de Traitement</label>
                                    <input type="text" name="soft_processing" class="form-control form-control-light"
                                        value="<?= htmlspecialchars($post['soft_processing'] ?? '') ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-white">Qualité du ciel (1-9)</label>
                                    <input type="number" name="bortle_scale" min="1" max="9"
                                        class="form-control form-control-light"
                                        value="<?= htmlspecialchars($post['bortle_scale'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="mt-4 d-flex justify-content-between">
                                <button type="button" class="btn btn-outline-secondary btn-prev"
                                    data-prev="equipment-tab"><i class="fas fa-arrow-left me-2"></i> Précédent</button>
                                <button type="submit" class="btn btn-primary px-5 fw-bold">METTRE À JOUR</button>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-4">

                    <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin'): ?>
                        <div class="card bg-danger border-light mb-4 text-white">
                            <div class="card-header fw-bold border-light">
                                <i class="fas fa-user-shield me-2"></i>Administration
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">État de la publication</label>
                                    <select name="status_post" class="form-select">
                                        <option value="0" <?= $post['status_post'] == 0 ? 'selected' : '' ?>>Brouillon (Caché)
                                        </option>
                                        <option value="1" <?= $post['status_post'] == 1 ? 'selected' : '' ?>>Publié (Visible)
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">État de suppression</label>
                                    <select name="is_deleted" class="form-select">
                                        <option value="0" <?= $post['is_deleted'] == 0 ? 'selected' : '' ?>>Actif</option>
                                        <option value="1" <?= $post['is_deleted'] == 1 ? 'selected' : '' ?>>Supprimé
                                            (Corbeille)</option>
                                    </select>
                                </div>
                                <div class="form-text text-white-50 small">
                                    * Ces options ne sont visibles que par les administrateurs.
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </form>
    </div>
</section>
<script>
    document.addEventListener('DOMContentLoaded', function () {

        // ============================================================
        // 1. GESTION DE LA NAVIGATION DES ONGLETS (Suivant / Précédent)
        // ============================================================

        // Boutons "Suivant"
        const nextBtns = document.querySelectorAll('.btn-next');
        nextBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                const nextTabId = this.getAttribute('data-next');
                const nextTabElement = document.getElementById(nextTabId);
                if (nextTabElement) {
                    const nextTab = new bootstrap.Tab(nextTabElement);
                    nextTab.show();
                }
            });
        });

        // Boutons "Précédent"
        const prevBtns = document.querySelectorAll('.btn-prev');
        prevBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                const prevTabId = this.getAttribute('data-prev');
                const prevTabElement = document.getElementById(prevTabId);
                if (prevTabElement) {
                    const prevTab = new bootstrap.Tab(prevTabElement);
                    prevTab.show();
                }
            });
        });


        // ============================================================
        // 2. GESTION AVANCÉE DES IMAGES (Aperçu + Suppression)
        // ============================================================

        const imageInput = document.getElementById('image-input');
        const previewContainer = document.getElementById('preview-container');

        // "Boîte virtuelle" pour stocker et manipuler les fichiers
        let dt = new DataTransfer();

        // On vérifie que les éléments existent pour éviter les erreurs JS
        if (imageInput && previewContainer) {

            imageInput.addEventListener('change', function () {

                // A. Ajouter les NOUVEAUX fichiers à la boîte virtuelle
                for (let i = 0; i < this.files.length; i++) {
                    let file = this.files[i];

                    // Anti-doublon basique (Même nom et même taille)
                    let isDuplicate = false;
                    for (let j = 0; j < dt.items.length; j++) {
                        if (dt.items[j].getAsFile().name === file.name && dt.items[j].getAsFile().size === file.size) {
                            isDuplicate = true;
                            break;
                        }
                    }

                    if (!isDuplicate) {
                        dt.items.add(file);
                    }
                }

                // B. Mettre à jour l'input réel avec la liste complète
                this.files = dt.files;

                // C. Rafraîchir l'affichage
                updateImagePreview();
            });
        }

        // Fonction de mise à jour de l'affichage
        function updateImagePreview() {
            previewContainer.innerHTML = ''; // On vide la zone

            for (let i = 0; i < dt.files.length; i++) {
                let file = dt.files[i];

                // On ne traite que les images
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        // Création de la colonne Bootstrap
                        const col = document.createElement('div');
                        col.className = 'col-6 col-md-3 col-lg-2 mt-2';

                        // Wrapper pour positionner le bouton relatif à l'image
                        const wrapper = document.createElement('div');
                        wrapper.className = 'position-relative';

                        // L'image
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'img-thumbnail bg-dark border-secondary';
                        img.style.width = '100%';
                        img.style.height = '100px';
                        img.style.objectFit = 'cover';

                        // Le bouton de suppression (X)
                        const btn = document.createElement('button');
                        // Styles inline pour être sûr que ça marche sans fichier CSS externe
                        btn.innerHTML = '<i class="fas fa-times"></i>';
                        btn.type = 'button';
                        btn.style.position = 'absolute';
                        btn.style.top = '5px';
                        btn.style.right = '5px';
                        btn.style.background = 'rgba(220, 53, 69, 0.9)'; // Rouge
                        btn.style.color = 'white';
                        btn.style.border = 'none';
                        btn.style.borderRadius = '50%';
                        btn.style.width = '25px';
                        btn.style.height = '25px';
                        btn.style.cursor = 'pointer';
                        btn.style.display = 'flex';
                        btn.style.alignItems = 'center';
                        btn.style.justifyContent = 'center';

                        // Événement Supprimer
                        btn.addEventListener('click', function () {
                            dt.items.remove(i);       // 1. Supprime du DataTransfer
                            imageInput.files = dt.files; // 2. Met à jour l'input
                            updateImagePreview();     // 3. Ré-affiche tout
                        });

                        // Assemblage
                        wrapper.appendChild(img);
                        wrapper.appendChild(btn);
                        col.appendChild(wrapper);
                        previewContainer.appendChild(col);
                    }

                    // Lecture du fichier
                    reader.readAsDataURL(file);
                }
            }
        }

    });
</script>