<div class="row justify-content-center">
    <div class="col-lg-8">
        <!-- Hero Section -->
        <div class="text-center mb-4">
            <h1 class="h2 fw-bold">Zoo'land</h1>
            <p class="text-muted small">Gestion du personnel</p>
        </div>

        <!-- Cards Section -->
        <div class="row g-3">
            <!-- Card 1 : Connexion -->
            <?php if (empty($_SESSION['user'])): ?>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center p-3">
                        <h5 class="card-title">Connexion</h5>
                        <a href="index.php?action=afficheConnexion" class="btn btn-sm btn-primary">
                            Accéder
                        </a>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center p-3">
                        <h5 class="card-title">Bienvenue</h5>
                        <p class="text-muted small mb-2">
                            <?= htmlspecialchars($_SESSION['user']['PRENOM'] ?? '') ?> <?= htmlspecialchars($_SESSION['user']['NOM'] ?? '') ?>
                        </p>
                        <a href="index.php?action=profil&id=<?= $_SESSION['user']['ID_PERSONNEL'] ?>" class="btn btn-sm btn-primary">
                            Mon profil
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Card 2 : Administration -->
            <?php if (isset($_SESSION['user']['ID_FONCTION']) && $_SESSION['user']['ID_FONCTION'] == ADMINID): ?>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center p-3">
                        <h5 class="card-title">Administration</h5>
                        <a href="index.php?action=adminDashboard" class="btn btn-sm btn-primary">
                            Dashboard
                        </a>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center p-3">
                        <h5 class="card-title">Système de gestion</h5>
                        <p class="text-muted small">Personnel et resources</p>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Quick Links -->
        <?php if (!empty($_SESSION['user'])): ?>
        <div class="text-center mt-4">
            <div class="btn-group btn-group-sm" role="group">
                <a href="index.php?action=profil&id=<?= $_SESSION['user']['ID_PERSONNEL'] ?>" class="btn btn-outline-secondary">Mon profil</a>
                <?php if (isset($_SESSION['user']['ID_FONCTION']) && $_SESSION['user']['ID_FONCTION'] == ADMINID): ?>
                <a href="index.php?action=adminDashboard" class="btn btn-outline-secondary">Dashboard</a>
                <?php endif; ?>
                <a href="index.php?action=deconnexion" class="btn btn-outline-danger">Déconnexion</a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
