<!-- FOOTER -->
<footer class="bg-dark text-light pt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <h5>A propos de nous</h5>
                <p class="lh-lg">
                    AstroSight est une plateforme communautaire dédiée aux passionnés d'astronomie et
                    d'astrophotographie. Que vous soyez un observateur débutant avec une paire de jumelles ou un
                    astrophotographe chevronné, cet espace est le vôtre.
                </p>
            </div>

            <div class="col-lg-3 col-md-6 mb-4 ps-lg-5">
                <h5>Liens rapides</h5>
                <ul class="list-unstyled">
                    <li><a href="<?= BASE_URL ?>/home">Accueil</a></li>
                    <li><a href="<?= BASE_URL ?>/about">A Propos</a></li>
                    <?php if (isset($_SESSION['user'])): ?>
                        <li><a href="<?= BASE_URL ?>/register" class="d-none">S'inscrire</a></li>
                    <?php else: ?>
                        <li><a href="<?= BASE_URL ?>/register">S'inscrire</a></li>
                    <?php endif; ?>
                    <li><a href="<?= BASE_URL ?>/login">Se connecter</a></li>
                    <li><a href="<?= BASE_URL ?>/contact">Contact</a></li>
                    <li><a href="<?= BASE_URL ?>/privacy">Politique de confidentialité</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <h5>Une question ?</h5>
                <ul class="list-unstyled contact-list">
                    <li>
                        <i class="fa-solid fa-computer"></i>
                        <span>Développeur Web <br> Kevin Urbain</span>
                    </li>
                    <li>
                        <i class="far fa-envelope"></i>
                        <a href="mailto:kevin.urbain.pro@gmail.com">Envoyer un mail</a>
                    </li>
                </ul>
                <div class="footer-socials mt-3">
                    <!-- <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-facebook-messenger"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#"><i class="fab fa-snapchat-ghost"></i></a> -->
                </div>
            </div>
            <?php
            try {
                $sqlStats = "SELECT 
                    (SELECT COUNT(*) FROM users) as total_users,
                    (SELECT COUNT(*) FROM posts WHERE status_post = 1) as total_posts";
                $stmtStats = $pdo->query($sqlStats);
                $stats = $stmtStats->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) { // Changed to PDOException as it's a DB query, and log it
                log_error($e);
                $stats = ['total_users' => 0, 'total_posts' => 0];
            }
            ?>
            <div class="col-lg-3 col-md-6">
                <h4 class="text-white mb-4">La Communauté</h4>

                <div class="d-flex justify-content-between text-center mb-3">

                    <div
                        class="bg-dark border border-secondary rounded p-3 w-100 me-2 position-relative overflow-hidden">
                        <div style="position: absolute; top:-10px; right:-10px; opacity:0.1;">
                            <i class="fas fa-users fa-3x"></i>
                        </div>

                        <h5 class="text-primary mb-0 fw-bold fs-3">

                            <?= $stats['total_users'] ?>
                        </h5>
                        <small class="text-white-50 text-uppercase fw-bold" style="font-size: 0.7rem;">Membres</small>
                    </div>

                    <div class="bg-dark border border-secondary rounded p-3 w-100 position-relative overflow-hidden">
                        <div style="position: absolute; top:-10px; right:-10px; opacity:0.1;">
                            <i class="fas fa-camera fa-3x"></i>
                        </div>


                        <h5 class="text-success mb-0 fw-bold fs-3">
                            <?= $stats['total_posts'] ?>
                        </h5>
                        <small class="text-white-50 text-uppercase fw-bold" style="font-size: 0.7rem;">Clichés</small>
                    </div>
                </div>

                <p class="text-white-50 small mb-3">
                    Rejoignez la base de données d'astrophotographie amateur en pleine expansion.
                </p>
                <?php if (isset($_SESSION['user'])): ?>
                    <a href="<?= BASE_URL ?>/add-post" class="btn btn-outline-primary w-100">
                        <i class="fas fa-plus-circle me-2"></i>Partager une photo
                    </a>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>/register" class="btn btn-primary w-100 fw-bold">
                        Nous rejoindre <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="copyright-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p class="m-0">
                        © <?= date('Y'); ?> Tous droits réservés.
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- FOOTER -->