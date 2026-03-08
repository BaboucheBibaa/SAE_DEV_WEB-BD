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
                                    echo number_format((float)$enclos['LATITUDE'], 6);
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
                                    echo number_format((float)$enclos['LONGITUDE'], 6);
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
                        <?php if (!empty($enclos['NOM_ANIMAL'])): ?>
                            <div class="alert alert-light border-start border-success border-3">
                                <h6 class="mb-2">
                                    <strong><?= htmlspecialchars($enclos['NOM_ANIMAL']) ?></strong>
                                </h6>
                                <a href="index.php?action=profilAnimal&id=<?= urlencode($enclos['ID_ANIMAL']) ?>" class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-eye"></i> Voir le profil de l'animal
                                </a>
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