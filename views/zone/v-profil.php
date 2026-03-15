<main class="flex-grow-1">
    <div class="container my-5">
        <!-- Titre et breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php?action=home">Accueil</a></li>
                <li class="breadcrumb-item active"><?= htmlspecialchars($zone['NOM_ZONE'] ?? 'Zone') ?></li>
            </ol>
        </nav>

        <!-- En-tête du profil -->
        <div class="row mb-5">
            <div class="col-lg-8">
                <h1 class="display-4 mb-3 text-primary">
                    <?= htmlspecialchars($zone['NOM_ZONE'] ?? 'Zone inconnue') ?>
                </h1>
                <p class="lead text-muted">Profil détaillé de la zone</p>
            </div>
        </div>

        <!-- Accordéon des sections -->
        <div class="accordion" id="accordionZone">
            <!-- Informations générales -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInfoGenerales">
                        <i class="bi bi-info-circle me-2"></i> Informations générales
                    </button>
                </h2>
                <div id="collapseInfoGenerales" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <strong style="min-width: 150px;">Nom de la zone :</strong>
                                    <span class="ms-2"><?= htmlspecialchars($zone['NOM_ZONE'] ?? 'Non spécifié') ?></span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <strong style="min-width: 150px;">ID Zone :</strong>
                                    <span class="ms-2">
                                        <span class="badge bg-secondary"><?= htmlspecialchars($zone['ID_ZONE'] ?? 'N/A') ?></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Liste des enclos -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEnclos">
                        <i class="bi bi-bounding-box me-2"></i> Enclos (<?= count($enclos) ?>)
                    </button>
                </h2>
                <div id="collapseEnclos" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <?php if (!empty($enclos) && is_array($enclos)): ?>
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
                                        <?php foreach ($enclos as $enc): ?>
                                            <tr>
                                                <td><strong><?= htmlspecialchars($enc['LATITUDE'] ?? 'N/A') ?></strong></td>
                                                <td><strong><?= htmlspecialchars($enc['LONGITUDE'] ?? 'N/A') ?></strong></td>
                                                <td>
                                                    <span class="badge bg-info">
                                                        <?= htmlspecialchars($enc['TYPE_ENCLOS'] ?? 'Non spécifié') ?>
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <a href="index.php?action=profilEnclos&latitude=<?= urlencode($enc['LATITUDE']) ?>&longitude=<?= urlencode($enc['LONGITUDE']) ?>" class="btn btn-sm btn-outline-primary" title="Voir le profil">
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
                                <i class="bi bi-info-circle"></i> Aucun enclos enregistré pour cette zone.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="row g-3 mt-4">
            <div class="col-auto">
                <a href="<?php echo isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php'; ?>" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left"></i> Retour
                </a>
            </div>
            <?php if (isset($_SESSION['user']['ID_FONCTION']) && $_SESSION['user']['ID_FONCTION'] == ADMINID): ?>
                <div class="col-auto">
                    <a href="index.php?action=editionZone&id=<?= htmlspecialchars($zone['ID_ZONE'] ?? '') ?>" class="btn btn-primary">
                        <i class="bi bi-pencil"></i> Modifier
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>