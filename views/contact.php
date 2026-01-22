<div class="container py-5">

    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold text-white">Contactez-nous</h1>
        <p class="lead text-white-50">Une question sur le matériel ? Une suggestion pour le site ? <br>L'espace est
            vaste, mais nous sommes à portée de clic.</p>
    </div>

    <div class="row g-5">

        <div class="col-lg-5">
            <div class="card bg-dark border-secondary text-white h-100">
                <div class="card-body p-4">
                    <h3 class="card-title h4 mb-4 text-primary"><i class="fas fa-satellite-dish me-2"></i>Coordonnées
                    </h3>

                    <div class="d-flex align-items-start mb-4">
                        <div class="flex-shrink-0 btn-sm btn-outline-primary rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 40px; height: 40px;">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="fw-bold mb-1">Siège AstroSight</h6>
                            <p class="text-white-50 mb-0">
                                Avenue de la Voie Lactée, 42<br>
                                6000 Charleroi (Belgique)
                            </p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start mb-4">
                        <div class="flex-shrink-0 btn-sm btn-outline-primary rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 40px; height: 40px;">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="fw-bold mb-1">Email</h6>
                            <p class="text-white-50 mb-0">kevin.urbain.pro@gmail.com</p>
                        </div>
                    </div>

                    <hr class="border-secondary my-4">

                    <h6 class="fw-bold mb-3">Suivez-nous</h6>
                    <div class="d-flex gap-3">
                        <!-- <a href="#" class="btn btn-outline-light rounded-circle"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="btn btn-outline-light rounded-circle"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="btn btn-outline-light rounded-circle"><i class="fab fa-instagram"></i></a> -->
                        <a href="https://github.com/KevinUrbain" class="btn btn-outline-light rounded-circle"
                            target="_blank"><i class="fab fa-github"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card bg-dark border-secondary text-white">
                <div class="card-body p-4">
                    <h3 class="card-title h4 mb-4"><i class="fas fa-paper-plane me-2 text-primary"></i>Envoyer un
                        message
                    </h3>

                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0 ps-3">
                                <?php foreach ($errors as $e): ?>
                                    <li>
                                        <?= htmlspecialchars($e) ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?php if ($success): ?>
                        <div class="alert alert-success d-flex align-items-center">
                            <i class="fas fa-check-circle me-2 fs-4"></i>
                            <div>
                                <?= $success ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nom / Pseudo *</label>
                                <input type="text" class="form-control bg-dark text-white border-secondary" id="name"
                                    name="name" value="<?= isset($name) ? htmlspecialchars($name, ENT_QUOTES) : '' ?>"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control bg-dark text-white border-secondary" id="email"
                                    name="email"
                                    value="<?= isset($email) ? htmlspecialchars($email, ENT_QUOTES) : '' ?>" required>
                            </div>
                            <div class="col-12">
                                <label for="subject" class="form-label">Sujet *</label>
                                <select class="form-select bg-dark text-white border-secondary" id="subject"
                                    name="subject">
                                    <option value="Question générale" <?= (isset($subject) && $subject === 'Question générale') ? 'selected' : '' ?>>Question générale</option>
                                    <option value="Support technique" <?= (isset($subject) && $subject === 'Support technique') ? 'selected' : '' ?>>Problème technique / Bug</option>
                                    <option value="Partenariat" <?= (isset($subject) && $subject === 'Partenariat') ? 'selected' : '' ?>>Proposition de partenariat</option>
                                    <option value="Autre" <?= (isset($subject) && $subject === 'Autre') ? 'selected' : '' ?>>Autre
                                    </option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="message" class="form-label">Message *</label>
                                <textarea class="form-control bg-dark text-white border-secondary" id="message"
                                    name="message" rows="5" required
                                    placeholder="Votre message..."><?= isset($message) ? htmlspecialchars($message, ENT_QUOTES) : '' ?></textarea>
                            </div>
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary px-4 fw-bold">
                                    <i class="fas fa-rocket me-2"></i>Envoyer
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>