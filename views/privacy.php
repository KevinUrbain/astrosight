<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <h1 class="text-white fw-bold mb-4">Politique de Confidentialité</h1>
            <p class="text-white-50 mb-5">Dernière mise à jour :
                <?= date('d/m/Y') ?>
            </p>

            <div class="card bg-dark border-secondary text-white shadow-lg">
                <div class="card-body p-5">

                    <section class="mb-5">
                        <h2 class="h4 text-primary mb-3"><i class="fas fa-user-secret me-2"></i>1. Introduction</h2>
                        <p class="text-white-50">
                            Bienvenue sur AstroSight. La protection de vos données personnelles est une priorité pour
                            nous.
                            Cette politique de confidentialité explique quelles informations nous collectons, comment
                            nous les utilisons et quels sont vos droits.
                        </p>
                    </section>

                    <hr class="border-secondary my-4">

                    <section class="mb-5">
                        <h2 class="h4 text-primary mb-3"><i class="fas fa-database me-2"></i>2. Les données que nous
                            collectons</h2>
                        <p class="text-white-50">Pour assurer le bon fonctionnement de la plateforme, nous collectons
                            les informations suivantes :</p>
                        <ul class="text-white-50">
                            <li class="mb-2"><strong>Données d'inscription :</strong> Pseudo, adresse email, mot de
                                passe (crypté), nom et prénom.</li>
                            <li class="mb-2"><strong>Contenu utilisateur :</strong> Les photos d'astronomie que vous
                                publiez, ainsi que les descriptions associées.</li>
                        </ul>
                    </section>
                    <hr class="border-secondary my-4">

                    <section class="mb-5">
                        <h2 class="h4 text-primary mb-3"><i class="fas fa-cogs me-2"></i>3. Comment nous utilisons vos
                            données</h2>
                        <p class="text-white-50">Vos données sont utilisées uniquement pour :</p>
                        <ul class="text-white-50">
                            <li>Vous permettre de vous connecter et de gérer votre profil.</li>
                            <li>Afficher vos publications aux autres membres et visiteurs.</li>
                            <li>Vous contacter en cas de problème technique ou de modération.</li>
                        </ul>
                        <div class="alert alert-info bg-opacity-10 border-info text-info mt-3">
                            <i class="fas fa-info-circle me-2"></i>Nous ne vendons ni ne partageons vos données
                            personnelles à des tiers.
                        </div>
                    </section>

                    <hr class="border-secondary my-4">

                    <section class="mb-5">
                        <h2 class="h4 text-primary mb-3"><i class="fas fa-cookie-bite me-2"></i>4. Cookies</h2>
                        <p class="text-white-50">
                            AstroSight utilise uniquement des cookies "techniques" essentiels au fonctionnement du site
                            (par exemple, pour maintenir votre session active une fois connecté).
                            Nous n'utilisons pas de cookies publicitaires ou de traçage tiers.
                        </p>
                    </section>

                    <hr class="border-secondary my-4">

                    <section class="mb-5">
                        <h2 class="h4 text-primary mb-3"><i class="fas fa-shield-alt me-2"></i>5. Vos droits</h2>
                        <p class="text-white-50">Conformément à la réglementation (RGPD), vous disposez des droits
                            suivants :</p>
                        <ul class="text-white-50">
                            <li><strong>Droit d'accès et de modification :</strong> Vous pouvez modifier vos
                                informations personnelles à tout moment via la page <a
                                    href="<?= BASE_URL ?>/profile-edit" class="text-info">"Modifier mon profil"</a>.
                            </li>
                            <li><strong>Droit à l'oubli :</strong> Vous pouvez supprimer vos publications
                                individuellement. Pour supprimer l'intégralité de votre compte, veuillez nous contacter.
                            </li>
                        </ul>
                    </section>

                    <hr class="border-secondary my-4">

                    <section>
                        <h2 class="h4 text-primary mb-3"><i class="fas fa-envelope me-2"></i>6. Nous contacter</h2>
                        <p class="text-white-50">
                            Pour toute question relative à cette politique de confidentialité ou pour exercer vos
                            droits, vous pouvez nous contacter via la page <a href="<?= BASE_URL ?>/contact"
                                class="text-info">Contact</a> ou directement par email à : <span
                                class="text-white">kevin.urbain.pro@gmail.com</span>.
                        </p>
                    </section>

                </div>
            </div>

            <div class="text-center mt-4">
                <a href="<?= BASE_URL ?>/home" class="btn btn-outline-light"><i
                        class="fas fa-arrow-left me-2"></i>Retour à l'accueil</a>
            </div>

        </div>
    </div>
</div>