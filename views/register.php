<?php if (isset($_SESSION['user'])): ?>
    <div class="container alert alert-danger">
        <div class="mx-auto" style="width: 200px;">
            Vous êtes déjà connecté !
        </div>
    </div>
<?php else: ?>
    <section class="contact-section pb-5">
        <div class="container">

            <h2 class="contact-title">Inscription</h2>
            <p class="text-center links mb-0">Déjà un compte ?</p>
            <a href="<?= BASE_URL . '/login' ?>" class="text-center d-block">Connectez-vous</a>
            <p class="contact-desc">
                Rejoignez la communauté d'observateurs AstroSight. La création d'un compte est indispensable pour
                <strong class="text-light">partager vos propres clichés astronomiques</strong>, documenter vos observations
                et contribuer à
                notre base de données
                céleste.
            </p>
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?= BASE_URL ?>/register" method="POST" enctype="multipart/form-data">
                <div class="row g-4">

                    <div class="col-md-4">
                        <label for="username" class="form-label-custom text-light">Pseudo :</label>
                        <input type="text" class="form-control form-control-light" id="username" name="username"
                            value="<?= htmlspecialchars($username, ENT_QUOTES) ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label for="email" class="form-label-custom text-light">E-mail :</label>
                        <input type="email" class="form-control form-control-light" id="email" name="email"
                            value="<?= htmlspecialchars($email) ?>" required>
                    </div>

                    <div class="col-md-4">
                        <label for="password" class="form-label-custom text-light">Mot de passe : (8caractères min.)</label>

                        <div class="input-group">
                            <input type="password" class="form-control form-control-light" id="password" name="password"
                                value="" required>

                            <button class="btn btn-outline-secondary" type="button" id="togglePassword"
                                style="border-color: #ced4da;">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="image_post" class="form-label-custom text-light">Image de profil :</label>
                        <input type="file" class="form-control form-control-light" id="image_post" name="image_post"
                            accept="image/*">
                    </div>

                    <div class="col-md-4">
                        <label for="firstname" class="form-label-custom text-light">Prénom :</label>
                        <input type="text" class="form-control form-control-light" id="firstname" name="firstname"
                            value="<?= htmlspecialchars($firstname, ENT_QUOTES) ?>" required>
                    </div>

                    <div class="col-md-4">
                        <label for="lastname" class="form-label-custom text-light">Nom :</label>
                        <input type="text" class="form-control form-control-light" id="lastname" name="lastname"
                            value="<?= htmlspecialchars($lastname, ENT_QUOTES) ?>" required>
                    </div>

                    <div class="col-12">
                        <label for="bio" class="form-label-custom text-light">Parle-nous de toi :</label>
                        <textarea class="form-control form-control-light" id="bio" name="bio"
                            rows="6"><?= htmlspecialchars($bio, ENT_QUOTES) ?></textarea>
                    </div>

                    <div class="col-12 mt-4 d-flex align-items-center">
                        <button type="submit" class="btn btn-send">S'inscrire</button>
                    </div>

                </div>
            </form>

        </div>
    </section>
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const icon = togglePassword.querySelector('i');

        togglePassword.addEventListener('click', function () {
            // 1. On bascule le type input : password <-> text
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // 2. On bascule l'icône : oeil ouvert <-> oeil barré
            // On enlève les deux classes pour être sûr, puis on ajoute la bonne
            icon.classList.remove('fa-eye', 'fa-eye-slash');

            if (type === 'text') {
                icon.classList.add('fa-eye-slash'); // Oeil barré quand visible
            } else {
                icon.classList.add('fa-eye'); // Oeil normal quand caché
            }
        });
    </script>
<?php endif; ?>