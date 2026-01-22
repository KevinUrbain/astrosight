<!-- NAV -->
<div class="top-bar">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <a href="<?= BASE_URL ?>" class="brand-logo me-3"><i class="fas fa-moon me-2"></i>AstroSight</a>
        </div>

        <div class="d-none d-md-flex align-items-center">
            <span class="quote me-4">"Sans l'astronomie, l'homme ignore la place qu'il occupe."</span>
            <div class="social-icons">
                <!-- <a href="#" class="text-secondary me-2"><i class="fab fa-google"></i></a>
                <a href="#" class="text-secondary me-2"><i class="fab fa-instagram"></i></a>
                <a href="#" class="text-secondary me-2"><i class="fab fa-twitter"></i></a>
                <a href="#" class="text-secondary"><i class="fab fa-facebook"></i></a> -->
            </div>
        </div>
    </div>
</div>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/home">Accueil</a></li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>/about">A propos</a>
                </li>
                <?php if (!isset($_SESSION['user'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>/register">S'inscrire</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>/login">Se connecter</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>/add-post">Ajouter un post</a>
                    </li>
                <?php endif; ?>

                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>/contact">Contact</a>
                </li>
            </ul>

            <?php if (isset($_SESSION['user'])): ?>
                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle hide-arrow"
                            id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="<?= BASE_URL ?>/uploads/img-avatar/<?= htmlspecialchars($_SESSION['user']['avatar'] ?? 'default.jpg') ?>"
                                alt="mdo" width="38" height="38" class="rounded-circle border border-2 border-secondary" />
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark shadow"
                            aria-labelledby="dropdownUser1">
                            <li>
                                <h6 class="dropdown-header"><?= htmlspecialchars($_SESSION['user']['username']) ?></h6>
                            </li>
                            <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin'): ?>
                                <li>
                                    <a class="dropdown-item" href="<?= BASE_URL ?>/dashboard">Dashboard Admin</a>
                                </li>
                            <?php endif; ?>
                            <li>
                                <a class="dropdown-item"
                                    href="<?= BASE_URL ?>/profile-edit?id=<?= $_SESSION['user']['id'] ?>">Modifier
                                    profil</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?= BASE_URL ?>/my-posts">Mes publications</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="<?= BASE_URL ?>/logout">Se déconnecter</a>
                            </li>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</nav>
<!-- NAV -->