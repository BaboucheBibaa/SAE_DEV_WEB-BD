<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? "Zoo'land") ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>

<body class="d-flex flex-column min-vh-100">
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
            <div class="container">
                <a class="navbar-brand" href="index.php?action=home">Zoo'land</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?action=home">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?action=search"><i class="bi bi-search"></i> Recherche</a>
                        </li>
                        <?php if (isset($_SESSION['user']['ID_FONCTION']) && $_SESSION['user']['ID_FONCTION'] == ADMINID) { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?action=adminDashboard">Dashboard Administrateur</a>
                            </li>
                        <?php }
                        if (isset($_SESSION['user']['ID_FONCTION']) && $_SESSION['user']['ID_FONCTION'] == RESPBOUTIQUE) { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?action=respBoutiqueDashboard">Dashboard Responsable de Boutique</a>
                            </li>
                        <?php }
                        if (isset($_SESSION['user']['ID_FONCTION']) && $_SESSION['user']['ID_FONCTION'] == RESPSOIG) { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?action=respZoneDashboard">Dashboard Responsable de Zone</a>
                            </li>
                        <?php }
                        if (isset($_SESSION['user']['ID_FONCTION']) && $_SESSION['user']['ID_FONCTION'] == SOIGNEUR) { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?action=soigneursDashboard">Dashboard Soigneur</a>
                            </li>

                        <?php }
                        if (isset($_SESSION['user']['ID_FONCTION']) && $_SESSION['user']['ID_FONCTION'] == ENTRETIEN) { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?action=personnelEntretienDashboard">Dashboard Personnel d'entretien</a>
                            </li>

                        <?php }
                        if (isset($_SESSION['user']['ID_FONCTION']) && $_SESSION['user']['ID_FONCTION'] == COMPTABLE) { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?action=comptableDashboard">Dashboard Comptable</a>
                            </li>
                        <?php }
                        if (!empty($_SESSION['user'])): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?= htmlspecialchars($_SESSION['user']['NOM'] ?? '') . " " . htmlspecialchars($_SESSION['user']['PRENOM'] ?? '') ?>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="index.php?action=profil&id=<?= $_SESSION['user']['ID_PERSONNEL'] ?>">Mon profil</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="index.php?action=deconnexion">Déconnexion</a></li>
                                </ul>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?action=connexion">Connexion</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="flex-grow-1 py-4">
        <div class="container">

            <?php if (!empty($_SESSION['flash'])): ?>
                <?php if ($_SESSION['flash']['type'] === 'error'): ?>
                    <div class="alert alert-danger border border-danger alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                        <i class="bi bi-exclamation-circle-fill flex-shrink-0"></i>
                        <div><strong>Erreur : </strong><?= htmlspecialchars($_SESSION['flash']['message']); ?></div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php elseif ($_SESSION['flash']['type'] === 'warning'): ?>
                    <div class="alert alert-warning border border-warning alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                        <i class="bi bi-exclamation-triangle-fill flex-shrink-0"></i>
                        <div><strong>Attention : </strong><?= htmlspecialchars($_SESSION['flash']['message']); ?></div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php else: ?>
                    <div class="alert alert-success border border-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                        <i class="bi bi-check-circle-fill flex-shrink-0"></i>
                        <div><strong>Succès : </strong><?= htmlspecialchars($_SESSION['flash']['message']); ?></div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                <?php unset($_SESSION['flash']); ?>
            <?php endif; ?>

            <?php require $view; ?>
        </div>
    </main>

    <footer class="bg-light border-top mt-auto">
        <div class="container py-3">
            <div class="text-center text-muted">
                <p class="mb-0"><?= date('Y') ?> - Zoo'land</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>