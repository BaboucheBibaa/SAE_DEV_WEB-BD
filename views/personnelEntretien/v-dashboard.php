<main class="flex-grow-1">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="h2 fw-bold mb-2">Espace Personnel d'Entretien</h1>
            <p class="text-muted">Suivi des taches d'entretien et des interventions</p>
        </div>

        <?php if (!empty($_SESSION['user'])): ?>
            <div class="alert alert-info mb-4">
                <i class="bi bi-info-circle"></i>
                Bienvenue, <strong><?= htmlspecialchars($_SESSION['user']['PRENOM'] ?? '') ?> <?= htmlspecialchars($_SESSION['user']['NOM'] ?? '') ?></strong>
            </div>
        <?php endif; ?>

        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <div class="mb-3">
                            <i class="bi bi-wrench-adjustable" style="font-size: 2rem; color: #198754;"></i>
                        </div>
                        <h5 class="card-title">Ajouter une réparation</h5>
                        <p class="card-text text-muted small flex-grow-1">
                            Enregistrez une nouvelle intervention de réparation sur un enclos.
                        </p>
                        <a href="index.php?action=formAjoutEntretien" class="btn btn-sm btn-primary mt-auto">
                            Acceder <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <div class="mb-3">
                            <i class="bi bi-tools" style="font-size: 2rem; color: #198754;"></i>
                        </div>
                        <h5 class="card-title">Historique des réparations faites</h5>
                        <p class="card-text text-muted small flex-grow-1">
                            Consultez l'historique des réparations que vous avez effectuées sur les enclos.
                        </p>
                        <a href="index.php?action=listerEntretiens" class="btn btn-sm btn-primary mt-auto">
                            Acceder <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <div class="mb-3">
                            <i class="bi bi-person-circle" style="font-size: 2rem; color: #fd7e14;"></i>
                        </div>
                        <h5 class="card-title">Mon Profil</h5>
                        <p class="card-text text-muted small flex-grow-1">
                            Consultez et mettez à jour vos informations personnelles.
                        </p>
                        <a href="index.php?action=profil&id=<?= htmlspecialchars($_SESSION['user']['ID_PERSONNEL'] ?? '') ?>" class="btn btn-sm btn-primary mt-auto">
                            Acceder <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <div class="mb-3">
                            <i class="bi bi-house-door" style="font-size: 2rem; color: #0d6efd;"></i>
                        </div>
                        <h5 class="card-title">Retour à l'Accueil</h5>
                        <p class="card-text text-muted small flex-grow-1">
                            Revenez à la page d'accueil pour naviguer vers les autres sections du site.
                        </p>
                        <a href="index.php?action=home" class="btn btn-sm btn-primary mt-auto">
                            Acceder <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>