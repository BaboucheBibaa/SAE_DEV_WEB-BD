<main class="flex-grow-1">
    <div class="container my-5">
        <!-- Titre et breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php?action=home">Accueil</a></li>
                <li class="breadcrumb-item active"><?= htmlspecialchars($prestataire['NOM_PRESTATAIRE'] ?? 'Prestataire') ?></li>
            </ol>
        </nav>

        <!-- En-tête du profil -->
        <div class="row mb-5">
            <div class="col-lg-8">
                <h1 class="display-4 mb-3 text-primary">
                    <?= htmlspecialchars($prestataire['NOM_PRESTATAIRE'] ?? 'Prestataire inconnu') ?> 
                    <?= htmlspecialchars($prestataire['PRENOM_PRESTATAIRE'] ?? '') ?>
                </h1>
                <p class="lead text-muted">Profil détaillé du prestataire</p>
            </div>
        </div>

        <!-- Accordéon des sections -->
        <div class="accordion" id="accordionPrestataire">
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
                                    <strong style="min-width: 150px;">Nom:</strong>
                                    <span class="ms-2"><?= htmlspecialchars($prestataire['NOM_PRESTATAIRE'] ?? 'Non spécifié') ?></span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <strong style="min-width: 150px;">Prénom:</strong>
                                    <span class="ms-2"><?= htmlspecialchars($prestataire['PRENOM_PRESTATAIRE'] ?? 'Non spécifié') ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Réparations effectuées -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseReparations">
                        <i class="bi bi-tools me-2"></i> Réparations effectuées 
                        <span class="badge bg-secondary ms-2"><?= count($reparations ?? []) ?></span>
                    </button>
                </h2>
                <div id="collapseReparations" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <?php if (!empty($reparations)): ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Date Début</th>
                                            <th>Date Fin</th>
                                            <th>Nature</th>
                                            <th>Coût</th>
                                            <th>Personnel</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($reparations as $reparation): ?>
                                            <tr>
                                                <td>
                                                    <?php
                                                    if (!empty($reparation['DATE_DEBUT_REPARATION'])) {
                                                        $dateDebut = DateTime::createFromFormat('d-M-y', htmlspecialchars($reparation['DATE_DEBUT_REPARATION']));
                                                        echo $dateDebut ? $dateDebut->format('d/m/Y') : htmlspecialchars($reparation['DATE_DEBUT_REPARATION']);
                                                    } else {
                                                        echo '<span class="text-muted">Non spécifiée</span>';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if (!empty($reparation['DATE_FIN'])) {
                                                        $dateFin = DateTime::createFromFormat('d-M-y', htmlspecialchars($reparation['DATE_FIN']));
                                                        echo $dateFin ? $dateFin->format('d/m/Y') : htmlspecialchars($reparation['DATE_FIN']);
                                                    } else {
                                                        echo '<span class="text-muted">En cours</span>';
                                                    }
                                                    ?>
                                                </td>
                                                <td><?= htmlspecialchars($reparation['NATURE_REPARATION'] ?? 'Non spécifiée') ?></td>
                                                <td>
                                                    <strong><?= htmlspecialchars($reparation['COUT_REPARATION'] ?? '0') ?> €</strong>
                                                </td>
                                                <td>
                                                    <?php
                                                    $nomPersonnel = htmlspecialchars($reparation['NOM'] ?? '');
                                                    $prenomPersonnel = htmlspecialchars($reparation['PRENOM'] ?? '');
                                                    echo !empty($nomPersonnel) ? "$nomPersonnel $prenomPersonnel" : '<span class="text-muted">Non spécifié</span>';
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info mb-0" role="alert">
                                <i class="bi bi-info-circle me-2"></i>
                                Aucune réparation enregistrée pour ce prestataire.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Statistiques -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseStats">
                        <i class="bi bi-graph-up me-2"></i> Statistiques
                    </button>
                </h2>
                <div id="collapseStats" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Nombre de réparations</h5>
                                        <p class="display-6 text-primary mb-0"><?= count($reparations ?? []) ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Coût total</h5>
                                        <p class="display-6 text-success mb-0">
                                            <?php
                                            $coutTotal = 0;
                                            foreach ($reparations ?? [] as $rep) {
                                                $coutTotal += floatval($rep['COUT_REPARATION'] ?? 0);
                                            }
                                            echo number_format($coutTotal, 2, ',', ' ') . ' €';
                                            ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Coût moyen</h5>
                                        <p class="display-6 text-info mb-0">
                                            <?php
                                            $coutMoyen = 0;
                                            if (!empty($reparations)) {
                                                $coutMoyen = $coutTotal / count($reparations);
                                            }
                                            echo number_format($coutMoyen, 2, ',', ' ') . ' €';
                                            ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Boutons d'action -->
        <div class="mt-5 mb-4">
            <a href="<?php echo isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php'; ?>" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left"></i> Retour
            </a>
        </div>
    </div>
</main>
