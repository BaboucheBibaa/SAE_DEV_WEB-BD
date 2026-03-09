<main class="flex-grow-1">
    <div class="container my-5">
        <!-- Titre et breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php?action=home">Accueil</a></li>
                <li class="breadcrumb-item active">Profil Enclos</li>
            </ol>
        </nav>

        <!-- En-tête du profil -->
        <div class="row mb-5">
            <div class="col-lg-8">
                <h1 class="display-4 mb-3 text-primary">
                    Enclos
                </h1>
                <p class="lead text-muted">Détails de l'enclos</p>
            </div>
        </div>

        <!-- Cartes d'informations -->
        <div class="row g-4">
            <!-- Informations générales -->
            <div class="col-lg-6">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-info-circle"></i> Informations générales
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <strong>Type d'enclos:</strong>
                            </div>
                            <div class="col-sm-8">
                                <span class="badge bg-info">
                                    <?= htmlspecialchars($enclos['TYPE_ENCLOS'] ?? 'Non spécifié') ?>
                                </span>
                            </div>
                        </div>

                        <hr>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <strong>Zone:</strong>
                            </div>
                            <div class="col-sm-8">
                                <span class="badge bg-warning text-dark">
                                    <?= htmlspecialchars($enclos['NOM_ZONE'] ?? 'Non spécifiée') ?>
                                </span>
                            </div>
                        </div>

                        <hr>

                        <div class="alert alert-success d-flex align-items-center" role="alert">
                            <div>
                                <strong>État:</strong><br>
                                Enclos en bon état
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Localisation géographique -->
            <div class="col-lg-6">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-geo-alt"></i> Localisation géographique
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <strong>Latitude:</strong>
                            </div>
                            <div class="col-sm-8">
                                <?php
                                if (!empty($enclos['LATITUDE'])) {
                                    echo htmlspecialchars($enclos['LATITUDE']);
                                } else {
                                    echo '<span class="text-muted">Non spécifiée</span>';
                                }
                                ?>
                            </div>
                        </div>

                        <hr>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <strong>Longitude:</strong>
                            </div>
                            <div class="col-sm-8">
                                <?php
                                if (!empty($enclos['LONGITUDE'])) {
                                    echo htmlspecialchars($enclos['LONGITUDE']);
                                } else {
                                    echo '<span class="text-muted">Non spécifiée</span>';
                                }
                                ?>
                            </div>
                        </div>

                        <hr>

                        <div class="alert alert-info d-flex align-items-center" role="alert">
                            <div>
                                <strong>Coordonnées:</strong><br>
                                Cet enclos est situé aux coordonnées GPS ci-dessus.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Animaux de l'enclos -->
        <div class="row g-4 mt-2">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-paw"></i> Animaux présents dans cet enclos
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($animaux) && isset($animaux[0])): ?>
                            <div class="alert alert-light border-start border-success border-3">
                                <?php
                                //Nombre d'animaux dans la liste
                                $countAnimaux = count($animaux);
                                for ($i = 0; $i < $countAnimaux; $i++) {
                                ?>
                                    <h6 class="mb-2">
                                        <strong><?= htmlspecialchars($animaux[$i]['NOM_ANIMAL']) ?></strong>
                                    </h6>
                                    <a href="index.php?action=profilAnimal&id=<?= urlencode($animaux[$i]['ID_ANIMAL']) ?>" class="btn btn-sm btn-outline-info mb-3">
                                        <i class="bi bi-eye"></i> Voir le profil de l'animal
                                    </a>
                                    <hr>
                                <?php } ?>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning" role="alert">
                                <i class="bi bi-exclamation-triangle"></i> Aucun animal enregistré dans cet enclos pour le moment.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Réparations de l'enclos -->
        <div class="row g-4 mt-2">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-tools"></i> Réparations de l'enclos
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php
                        $hasReparations = !empty($reparations);
                        if ($hasReparations):
                        ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Date de réparation</th>
                                            <th>Nature de la réparation</th>
                                            <th>Personnel responsable</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count = count($reparations);
                                        for ($i = 0; $i < $count; $i++) {
                                        ?>
                                            <tr>
                                                <td>
                                                    <strong><?= htmlspecialchars($reparations[$i]['DATE_DEBUT_REPARATION'] ?? 'N/A') ?></strong>
                                                </td>
                                                <td>
                                                    <?= htmlspecialchars($reparations[$i]['NATURE_REPARATION'] ?? 'Non spécifiée') ?>
                                                </td>
                                                <td>
                                                    <span class="badge bg-secondary">
                                                        <?php if ($reparations[$i]['ID_PERSONNEL'] == null): ?>
                                                            <?= htmlspecialchars(trim(($reparations[$i]['NOM_PRESTATAIRE'] ?? ''))) ?>
                                                        <?php else: ?>
                                                            <?= htmlspecialchars(trim(($reparations[$i]['PRENOM'] ?? '') . ' ' . ($reparations[$i]['NOM'] ?? ''))) ?>
                                                        <?php endif; ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info" role="alert">
                                <i class="bi bi-info-circle"></i> Aucune réparation enregistrée pour cet enclos.
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
            <div class="col-auto">
                <a href="index.php?action=home" class="btn btn-outline-secondary">
                    <i class="bi bi-house"></i> Accueil
                </a>
            </div>
        </div>
    </div>
</main>