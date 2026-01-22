<section class="contact-section pb-5">
    <div class="container">

        <h2 class="contact-title">Se Connecter</h2>
        <p class="contact-desc">
            Rejoignez la communauté d'observateurs AstroSight. Connectez-vous pour
            <strong class="text-light">partager vos propres clichés astronomiques</strong>, documenter vos observations
            et contribuer à
            notre base de données
            céleste.
        </p>
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

        <form action="<?= BASE_URL ?>/login" method="POST">
            <div class="row g-4">

                <div class="col-md-6">
                    <label for="email" class="form-label-custom text-light">E-mail :</label>
                    <input type="email" class="form-control form-control-light" id="email" name="email"
                        value="<?= htmlspecialchars($email ?? '') ?>" required>
                </div>

                <div class="col-md-6">
                    <label for="password" class="form-label-custom text-light">Mot de passe :</label>

                    <div class="input-group">
                        <input type="password" class="form-control form-control-light" id="password" name="password"
                            value="" required>

                        <button class="btn btn-outline-secondary" type="button" id="togglePassword"
                            style="border-color: #ced4da;">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="col-12 mt-4 d-flex align-items-center">
                    <button type="submit" class="btn btn-send">Se Connecter</button>
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