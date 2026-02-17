<div class="row justify-content-center">
    <div class="col-lg-10">
        <!-- Hero Section -->
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold text-primary">
                <i class="bi bi-house-heart-fill"></i> Bienvenue sur Zoo'land
            </h1>
            <p class="lead text-muted">Système de gestion du personnel</p>
        </div>

        <!-- Cards Section -->
        <div class="row g-4 mb-5">
            <!-- Card 1 : Connexion -->
            <?php if (empty($_SESSION['user'])): ?>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="bi bi-person-circle text-primary" style="font-size: 3rem;"></i>
                        </div>
                        <h3 class="card-title h4">Connexion</h3>
                        <p class="card-text text-muted">
                            Accédez à votre espace personnel pour gérer votre profil et vos informations.
                        </p>
                        <a href="index.php?action=afficheConnexion" class="btn btn-primary">
                            <i class="bi bi-box-arrow-in-right"></i> Se connecter
                        </a>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="bi bi-person-badge text-success" style="font-size: 3rem;"></i>
                        </div>
                        <h3 class="card-title h4">Mon Profil</h3>
                        <p class="card-text text-muted">
                            Bonjour <strong><?= htmlspecialchars($_SESSION['user']['PRENOM'] ?? '') ?> <?= htmlspecialchars($_SESSION['user']['NOM'] ?? '') ?></strong> !<br>
                            Gérez vos informations personnelles et votre mot de passe.
                        </p>
                        <a href="index.php?action=profil" class="btn btn-success">
                            <i class="bi bi-person-circle"></i> Voir mon profil
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Card 2 : Administration -->
            <?php if (isset($_SESSION['user']['EST_ADMIN']) && $_SESSION['user']['EST_ADMIN'] == 1): ?>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100 border-primary">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="bi bi-shield-lock text-primary" style="font-size: 3rem;"></i>
                        </div>
                        <h3 class="card-title h4">Administration</h3>
                        <p class="card-text text-muted">
                            Accédez au tableau de bord administrateur pour gérer le personnel.
                        </p>
                        <a href="index.php?action=admin_dashboard" class="btn btn-primary">
                            <i class="bi bi-gear-fill"></i> Dashboard Admin
                        </a>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="bi bi-info-circle text-info" style="font-size: 3rem;"></i>
                        </div>
                        <h3 class="card-title h4">À propos</h3>
                        <p class="card-text text-muted">
                            Zoo'land est un système de gestion moderne et sécurisé pour le personnel.
                        </p>
                        <span class="badge bg-info">Version 1.0</span>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Features Section -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h3 class="card-title text-center mb-4">
                    <i class="bi bi-star-fill text-warning"></i> Fonctionnalités
                </h3>
                <div class="row text-center g-4">
                    <div class="col-md-4">
                        <i class="bi bi-shield-check text-success" style="font-size: 2rem;"></i>
                        <h5 class="mt-2">Sécurisé</h5>
                        <p class="text-muted small">Authentification sécurisée avec cryptage des mots de passe</p>
                    </div>
                    <div class="col-md-4">
                        <i class="bi bi-speedometer2 text-primary" style="font-size: 2rem;"></i>
                        <h5 class="mt-2">Rapide</h5>
                        <p class="text-muted small">Interface optimisée pour une navigation fluide</p>
                    </div>
                    <div class="col-md-4">
                        <i class="bi bi-people-fill text-info" style="font-size: 2rem;"></i>
                        <h5 class="mt-2">Collaboratif</h5>
                        <p class="text-muted small">Gestion centralisée du personnel</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Links -->
        <?php if (!empty($_SESSION['user'])): ?>
        <div class="text-center">
            <div class="btn-group" role="group">
                <a href="index.php?action=profil" class="btn btn-outline-primary">
                    <i class="bi bi-person"></i> Mon Profil
                </a>
                <?php if (isset($_SESSION['user']['EST_ADMIN']) && $_SESSION['user']['EST_ADMIN'] == 1): ?>
                <a href="index.php?action=admin_dashboard" class="btn btn-outline-primary">
                    <i class="bi bi-speedometer"></i> Dashboard
                </a>
                <?php endif; ?>
                <a href="index.php?action=deconnexion" class="btn btn-outline-danger">
                    <i class="bi bi-box-arrow-right"></i> Déconnexion
                </a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
