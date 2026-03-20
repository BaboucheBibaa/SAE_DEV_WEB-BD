<main class="flex-grow-1">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="h2 fw-bold mb-2">Espace Soigneurs</h1>
            <p class="text-muted">Gestion des animaux et de leurs soins</p>
        </div>

        <?php if (!empty($_SESSION['user'])): ?>
            <div class="alert alert-info mb-4">
                <i class="bi bi-info-circle"></i>
                Bienvenue, <strong><?= htmlspecialchars($_SESSION['user']['PRENOM'] ?? '') ?> <?= htmlspecialchars($_SESSION['user']['NOM'] ?? '') ?></strong>
            </div>
        <?php endif; ?>

        <!-- Options Cards -->
        <div class="row g-4">
            <!-- Card 2 : Historique des Soins -->
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <div class="mb-3">
                            <i class="bi bi-clipboard-heart" style="font-size: 2rem; color: #0d6efd;"></i>
                        </div>
                        <h5 class="card-title">Historique des Soins</h5>
                        <p class="card-text text-muted small flex-grow-1">
                            Consultez l'historique complet des soins apportés aux animaux.
                        </p>
                        <a href="index.php?action=listerSoins" class="btn btn-sm btn-primary mt-auto">
                            Accéder <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card 4 : Mon Profil -->
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <div class="mb-3">
                            <i class="bi bi-person-circle" style="font-size: 2rem; color: #fd7e14;"></i>
                        </div>
                        <h5 class="card-title">Mon Profil</h5>
                        <p class="card-text text-muted small flex-grow-1">
                            Consultez et modifiez vos informations personnelles.
                        </p>
                        <a href="index.php?action=profil&id=<?= htmlspecialchars($_SESSION['user']['ID_PERSONNEL'] ?? '') ?>" class="btn btn-sm btn-primary mt-auto">
                            Accéder <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card 5 : Rapport de Soins -->
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <div class="mb-3">
                            <i class="bi bi-file-earmark-text" style="font-size: 2rem; color: #198754;"></i>
                        </div>
                        <h5 class="card-title">Ajouter un soin sur un animal</h5>
                        <p class="card-text text-muted small flex-grow-1">
                            Enregistre les soins apportés à un animal spécifique.
                        </p>
                        <a href="index.php?action=formAjoutSoin" class="btn btn-sm btn-primary mt-auto">
                            Accéder <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <div class="mb-3">
                            <i class="bi bi-file-earmark-text" style="font-size: 2rem; color: #198754;"></i>
                        </div>
                        <h5 class="card-title">Distribution de nourriture faite</h5>
                        <p class="card-text text-muted small flex-grow-1">
                            Enregistre les distributions de nourriture effectuées.
                        </p>
                        <a href="index.php?action=formAjoutNourriture" class="btn btn-sm btn-primary mt-auto">
                            Accéder <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <div class="mb-3">
                            <i class="bi bi-file-earmark-text" style="font-size: 2rem; color: #198754;"></i>
                        </div>
                        <h5 class="card-title">Statistiques diverses et variées</h5>
                        <p class="card-text text-muted small flex-grow-1">
                            Consultez des statistiques sur les soins et la nourriture au sein du zoo.
                        </p>
                        <a href="index.php?action=statsSoigneurs" class="btn btn-sm btn-primary mt-auto">
                            Accéder <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>