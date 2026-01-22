<?php
require_once ROOT . '/functions/createDropDownCountries.php';

check_login();
?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
                <li>
                    <?= htmlspecialchars($error) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<section class="py-5">
    <div class="container">
        <h2 class="mb-4">Ajouter une observation</h2>

        <form action="<?= BASE_URL ?>/add-post" method="POST" enctype="multipart/form-data">

            <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general"
                        type="button" role="tab" aria-controls="general" aria-selected="true">
                        <i class="fas fa-info-circle me-2"></i>Général
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="equipment-tab" data-bs-toggle="tab" data-bs-target="#equipment"
                        type="button" role="tab" aria-controls="equipment" aria-selected="false">
                        <i class="fas fa-microscope me-2"></i>Matériel
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="acquisition-tab" data-bs-toggle="tab" data-bs-target="#acquisition"
                        type="button" role="tab" aria-controls="acquisition" aria-selected="false">
                        <i class="fas fa-clock me-2"></i>Acquisition
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">

                <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label text-white">Titre *</label>
                            <input type="text" name="title" class="form-control form-control-light"
                                value="<?= isset($title) ? htmlspecialchars($title, ENT_QUOTES) : '' ?>" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label text-white">Description *</label>
                            <textarea name="content" class="form-control form-control-light" rows="5"
                                required><?= isset($content) ? htmlspecialchars($content, ENT_QUOTES) : '' ?></textarea>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label text-white">Images de l'observation *</label>

                            <input type="file" name="images[]" id="image-input" class="form-control form-control-light"
                                multiple accept="image/*" required>

                            <div class="form-text text-white-50">Maintenez "Ctrl" pour sélectionner plusieurs photos.
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div id="preview-container" class="row g-2 mt-2">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-white">Catégorie *</label>
                            <select name="category" class="form-select form-control-light">
                                <option value="Observation">Observation Visuelle</option>
                                <option value="Astrophoto">Astrophoto Ciel Profond</option>
                                <option value="Planetaire">Planétaire</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-white">Pays *</label>
                            <select name="country" class="form-select form-control-light">
                                <?= createDropDown($country_list); ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-white">Ville *</label>
                            <input type="text" name="city" class="form-control form-control-light"
                                placeholder="ex: Marseille"
                                value="<?= isset($city) ? htmlspecialchars($city, ENT_QUOTES) : '' ?>">
                        </div>
                    </div>
                    <div class="mt-4 text-end">
                        <button type="button" class="btn btn-outline-light btn-next" data-next="equipment-tab">Suivant
                            <i class="fas fa-arrow-right ms-2"></i></button>
                    </div>
                </div>

                <div class="tab-pane fade" id="equipment" role="tabpanel" aria-labelledby="equipment-tab">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-white">Télescope / Objectif</label>
                            <input type="text" name="telescope" class="form-control form-control-light"
                                placeholder="ex: Télescope Newton"
                                value="<?= isset($telescope) ? htmlspecialchars($telescope, ENT_QUOTES) : '' ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-white">Caméra Principale</label>
                            <input type="text" name="camera" class="form-control form-control-light"
                                placeholder="ex: ASI 533MC"
                                value="<?= isset($camera) ? htmlspecialchars($camera, ENT_QUOTES) : '' ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-white">Diamètre en mm</label>
                            <input type="number" name="diameter" class="form-control form-control-light"
                                placeholder="ex: 300mm"
                                value="<?= isset($diameter) ? htmlspecialchars($diameter) : '' ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-white">Longueur Focale en mm</label>
                            <input type="number" name="focal_length" class="form-control form-control-light"
                                placeholder="ex: 1200mm"
                                value="<?= isset($focal_length) ? htmlspecialchars($focal_length) : '' ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-white">Monture</label>
                            <input type="text" name="mount" class="form-control form-control-light"
                                placeholder="ex: EQ6-R"
                                value="<?= isset($mount) ? htmlspecialchars($mount, ENT_QUOTES) : '' ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-white">Filtres</label>
                            <input type="text" name="filters" class="form-control form-control-light"
                                placeholder="ex: L-Extreme"
                                value="<?= isset($filters) ? htmlspecialchars($filters, ENT_QUOTES) : '' ?>">
                        </div>
                    </div>
                    <div class="mt-4 d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-secondary btn-prev" data-prev="general-tab"><i
                                class="fas fa-arrow-left me-2"></i> Précédent</button>
                        <button type="button" class="btn btn-outline-light btn-next" data-next="acquisition-tab">Suivant
                            <i class="fas fa-arrow-right ms-2"></i></button>
                    </div>
                </div>

                <div class="tab-pane fade" id="acquisition" role="tabpanel" aria-labelledby="acquisition-tab">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label text-white">Temps de pose unitaire</label>
                            <input type="text" name="exposure_time" class="form-control form-control-light"
                                placeholder="ex: 300s"
                                value="<?= isset($exposure_time) ? htmlspecialchars($exposure_time) : '' ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-white">Nombre de poses</label>
                            <input type="number" name="exposure_count" class="form-control form-control-light"
                                placeholder="ex: 60"
                                value="<?= isset($exposure_count) ? htmlspecialchars($exposure_count) : '' ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-white">ISO / Gain</label>
                            <input type="text" name="gain_iso" class="form-control form-control-light"
                                placeholder="ex: 100"
                                value="<?= isset($gain_iso) ? htmlspecialchars($gain_iso) : '' ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-white">Logiciel de Traitement</label>
                            <input type="text" name="soft_processing" class="form-control form-control-light"
                                placeholder="ex: PixInsight"
                                value="<?= isset($soft_processing) ? htmlspecialchars($soft_processing, ENT_QUOTES) : '' ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-white">Qualité du ciel (1-9)</label>
                            <input type="number" name="bortle_scale" min="1" max="9"
                                class="form-control form-control-light"
                                value="<?= isset($bortle_scale) ? htmlspecialchars($bortle_scale) : '' ?>">
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-secondary btn-prev" data-prev="equipment-tab"><i
                                class="fas fa-arrow-left me-2"></i> Précédent</button>
                        <button type="submit" class="btn btn-primary px-5 fw-bold">PUBLIER L'IMAGE</button>
                    </div>
                </div>

            </div>
        </form>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Gestion des boutons "Suivant"
        const nextBtns = document.querySelectorAll('.btn-next');
        nextBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                const nextTabId = this.getAttribute('data-next');
                const nextTab = new bootstrap.Tab(document.getElementById(nextTabId));
                nextTab.show();
            });
        });

        // Gestion des boutons "Précédent"
        const prevBtns = document.querySelectorAll('.btn-prev');
        prevBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                const prevTabId = this.getAttribute('data-prev');
                const prevTab = new bootstrap.Tab(document.getElementById(prevTabId));
                prevTab.show();
            });
        });
        // --- GESTION DE L'APERÇU IMAGE ---
        // --- GESTION AVANCÉE DE L'APERÇU IMAGE (Avec Suppression) ---
        const imageInput = document.getElementById('image-input');
        const previewContainer = document.getElementById('preview-container');

        let dt = new DataTransfer();

        imageInput.addEventListener('change', function () {

            // 1. On ajoute les NOUVEAUX fichiers choisis à notre boîte DataTransfer
            for (let i = 0; i < this.files.length; i++) {
                let file = this.files[i];
                // Optionnel : On évite les doublons (basé sur le nom et la taille)
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

            this.files = dt.files;

            updateImagePreview();
        });

        function updateImagePreview() {
            previewContainer.innerHTML = '';

            // Je boucle sur tous les fichiers présents dans DataTransfer
            for (let i = 0; i < dt.files.length; i++) {
                let file = dt.files[i];

                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        // Création de la colonne
                        const col = document.createElement('div');
                        col.className = 'col-6 col-md-3 col-lg-2';

                        // Création du wrapper (pour le positionnement relative)
                        const wrapper = document.createElement('div');
                        wrapper.className = 'preview-item w-100';

                        // L'image
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'img-thumbnail bg-dark border-secondary';
                        img.style.width = '100%';
                        img.style.height = '100px';
                        img.style.objectFit = 'cover';

                        // Le bouton de suppression (X)
                        const btn = document.createElement('button');
                        btn.className = 'btn-remove-img';
                        btn.innerHTML = '<i class="fas fa-times"></i>';
                        btn.type = 'button';

                        // L'événement de suppression
                        btn.addEventListener('click', function () {
                            // Suppression du fichier dans le DataTransfer
                            dt.items.remove(i);
                            // Mise à jour de l'input réel
                            imageInput.files = dt.files;
                            // Mise à jour visuelle (récursive)
                            updateImagePreview();
                        });

                        // Assemblage
                        wrapper.appendChild(img);
                        wrapper.appendChild(btn);
                        col.appendChild(wrapper);
                        previewContainer.appendChild(col);
                    }

                    reader.readAsDataURL(file);
                }
            }
        }
    });
</script>