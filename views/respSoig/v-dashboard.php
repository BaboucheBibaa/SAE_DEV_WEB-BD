<main class="flex-grow-1">
    <div class="container my-5">
        <!-- Titre et breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php?action=home">Accueil</a></li>
                <li class="breadcrumb-item active">Dashboard Responsable Soigneurs</li>
            </ol>
        </nav>

        <!-- En-tête du dashboard -->
        <div class="row mb-5">
            <div class="col-lg-8">
                <h1 class="display-4 mb-3 text-primary">
                    Gestion des Soigneurs
                </h1>
                <p class="lead text-muted">Bienvenue, <?= htmlspecialchars($user['PRENOM'] . ' ' . $user['NOM']) ?></p>
                <?php if (isset($zone)): ?>
                    <p class="text-muted">Zone : <strong><?= htmlspecialchars($zone['NOM_ZONE']) ?></strong></p>
                <?php endif; ?>
            </div>
        </div>

        <?php if (isset($zone)): ?>
        <!-- Accordéon des sections -->
        <div class="accordion" id="accordionDashboard">
            <!-- Liste des soigneurs -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSoigneurs">
                        <i class="bi bi-people-fill me-2"></i> Liste des soigneurs de ma zone (<?= count($employes) ?>)
                    </button>
                </h2>
                <div id="collapseSoigneurs" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        <?php if (!empty($employes)): ?>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nom</th>
                                            <th>Prénom</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($employes as $employe): ?>
                                            <tr>
                                                <td><strong><?= htmlspecialchars($employe['NOM']) ?></strong></td>
                                                <td><?= htmlspecialchars($employe['PRENOM']) ?></td>
                                                <td class="text-center">
                                                    <a href="index.php?action=profil&id=<?= htmlspecialchars($employe['ID_PERSONNEL']) ?>" class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-eye"></i> Profil
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info mb-0" role="alert">
                                <i class="bi bi-info-circle"></i> Aucun employé n'est actuellement affecté à cette zone.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Liste des enclos -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEnclos">
                        <i class="bi bi-bounding-box me-2"></i> Liste des enclos de ma zone (<?= count($enclos) ?>)
                    </button>
                </h2>
                <div id="collapseEnclos" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <?php if (!empty($enclos)): ?>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Latitude</th>
                                            <th>Longitude</th>
                                            <th>Type d'Enclos</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($enclos as $enclo): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($enclo['LATITUDE']) ?></td>
                                                <td><?= htmlspecialchars($enclo['LONGITUDE']) ?></td>
                                                <td><span class="badge bg-success"><?= htmlspecialchars($enclo['TYPE_ENCLOS']) ?></span></td>
                                                <td class="text-center">
                                                    <a href="index.php?action=profilEnclos&latitude=<?= urlencode($enclo['LATITUDE']) ?>&longitude=<?= urlencode($enclo['LONGITUDE']) ?>" class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-eye"></i> Profil
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info mb-0" role="alert">
                                <i class="bi bi-info-circle"></i> Aucun enclos n'est présent dans cette zone.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Liste des animaux -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAnimaux">
                        <i class="bi bi-paw me-2"></i> Liste des animaux de ma zone (<?= count($animaux) ?>)
                    </button>
                </h2>
                <div id="collapseAnimaux" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <?php if (!empty($animaux)): ?>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nom de l'animal</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($animaux as $animal): ?>
                                            <tr>
                                                <td><strong><?= htmlspecialchars($animal['NOM_ANIMAL']) ?></strong></td>
                                                <td class="text-center">
                                                    <a href="index.php?action=profilAnimal&id=<?= htmlspecialchars($animal['ID_ANIMAL']) ?>" class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-eye"></i> Profil
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info mb-0" role="alert">
                                <i class="bi bi-info-circle"></i> Aucun animal n'est présent dans cette zone.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="row g-3 mt-4">
            <div class="col-auto">
                <a href="index.php?action=profil&id=<?= htmlspecialchars($user['ID_PERSONNEL'] ?? '') ?>" class="btn btn-outline-primary">
                    <i class="bi bi-person"></i> Mon profil
                </a>
            </div>
            <div class="col-auto">
                <a href="index.php?action=home" class="btn btn-outline-secondary">
                    <i class="bi bi-house"></i> Accueil
                </a>
            </div>
        </div>

        <?php else: ?>
            <div class="alert alert-warning" role="alert">
                <i class="bi bi-exclamation-triangle"></i> Vous n'êtes pas encore assigné à une zone.
            </div>
        <?php endif; ?>
    </div>
</main>