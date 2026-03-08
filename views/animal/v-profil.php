<main class="flex-grow-1">
    <div class="container my-5">
        <!-- Titre et breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php?action=home">Accueil</a></li>
                <li class="breadcrumb-item active"><?= htmlspecialchars($animal['NOM_ANIMAL'] ?? 'Animal') ?></li>
            </ol>
        </nav>

        <!-- En-tête du profil -->
        <div class="row mb-5">
            <div class="col-lg-8">
                <h1 class="display-4 mb-3 text-primary">
                    <?= htmlspecialchars($animal['NOM_ANIMAL'] ?? 'Animal inconnu') ?>
                </h1>
                <p class="lead text-muted">Profil détaillé de l'animal</p>
            </div>
        </div>

        <!-- Cartes d'informations -->
        <div class="row g-4">
            <!-- Informations principales -->
            <div class="col-lg-6">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            Informations générales
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <strong>Espèce:</strong>
                            </div>
                            <div class="col-sm-8">
                                <span><?= htmlspecialchars($animal['NOM_ESPECE'] ?? 'Non spécifiée') ?></span>
                            </div>
                        </div>

                        <hr>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <strong>Date de naissance:</strong>
                            </div>
                            <div class="col-sm-8">
                                <?php
                                if (!empty($animal['DATE_NAISSANCE'])) {
                                    $dateNaissance = htmlspecialchars($animal['DATE_NAISSANCE']);
                                    $date = DateTime::createFromFormat('d-M-y', $dateNaissance) ?: DateTime::createFromFormat('Y-m-d', $dateNaissance);
                                    if ($date) {
                                        echo $date->format('d/m/Y');

                                        // Calcul de l'âge
                                        $maintenant = new DateTime();
                                        $age = $maintenant->diff($date)->y;
                                        echo " <span class='badge bg-success'>( $age ans )</span>";
                                    } else {
                                        echo htmlspecialchars($dateNaissance);
                                    }
                                } else {
                                    echo '<span class="text-muted">Non spécifiée</span>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Caractéristiques physiques -->
            <div class="col-lg-6">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">
                            Caractéristiques physiques
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <strong>Poids:</strong>
                            </div>
                            <div class="col-sm-8">
                                <?php
                                if (!empty($animal['POIDS'])) {
                                    echo htmlspecialchars($animal['POIDS']) . ' kg';
                                } else {
                                    echo '<span class="text-muted">Non spécifié</span>';
                                }
                                ?>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <strong>Régime alimentaire:</strong>
                            </div>
                            <div class="col-sm-8">
                                <?php
                                $regime = htmlspecialchars($animal['REGIME_ALIMENTAIRE'] ?? 'Non spécifié');
                                $badgeClass = 'bg-secondary';

                                if (stripos($regime, 'carnivore') !== false) {
                                    $badgeClass = 'bg-danger';
                                } elseif (stripos($regime, 'herbivore') !== false) {
                                    $badgeClass = 'bg-success';
                                } elseif (stripos($regime, 'omnivore') !== false) {
                                    $badgeClass = 'bg-warning text-dark';
                                }

                                echo "<span class='badge $badgeClass'>$regime</span>";
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Localisation -->
        <div class="row g-4 mt-2">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="card-title mb-0">
                            Localisation
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <strong style="min-width: 120px;">Latitude:</strong>
                                    <span class="ms-2">
                                        <?= !empty($animal['LATITUDE_ENCLOS'])
                                            ? number_format((float)$animal['LATITUDE_ENCLOS'], 6)
                                            : '<span class="text-muted">Non spécifiée</span>'
                                        ?>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <strong style="min-width: 120px;">Longitude:</strong>
                                    <span class="ms-2">
                                        <?= !empty($animal['LONGITUDE_ENCLOS'])
                                            ? number_format((float)$animal['LONGITUDE_ENCLOS'], 6)
                                            : '<span class="text-muted">Non spécifiée</span>'
                                        ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Doses quotidiennes de nourriture -->
        <div class="row g-4 mt-2">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-egg"></i> Doses de nourriture
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($nourriture) && isset($nourriture['ID_ANIMAL']) && is_array($nourriture['ID_ANIMAL'])): ?>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Date de nourriture</th>
                                            <th>Personnel</th>
                                            <th>Dose (kg)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count = count($nourriture['ID_ANIMAL']);
                                        for ($i = 0; $i < $count; $i++) {
                                            $dateNourrit = htmlspecialchars($nourriture['DATE_NOURRIT'][$i] ?? '');
                                            $nomPersonnel = htmlspecialchars($nourriture['NOM'][$i] ?? 'Non spécifié');
                                            $prenomPersonnel = htmlspecialchars($nourriture['PRENOM'][$i] ?? '');
                                            $dose = htmlspecialchars($nourriture['DOSE_NOURRITURE'][$i] ?? '');
                                            
                                            echo "<tr>";
                                            echo "<td><strong>{$dateNourrit}</strong></td>";
                                            echo "<td>{$nomPersonnel} {$prenomPersonnel}</td>";
                                            echo "<td><span class='badge bg-success'>{$dose} kg</span></td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning" role="alert">
                                <i class="bi bi-exclamation-triangle"></i> Aucune dose de nourriture enregistrée pour cet animal.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Historique des soins -->
        <div class="row g-4 mt-2">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-heart-pulse"></i> Historique des soins
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($soins) && isset($soins['ID_ANIMAL']) && is_array($soins['ID_ANIMAL'])): ?>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Date du soin</th>
                                            <th>Personnel</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count = count($soins['ID_ANIMAL']);
                                        for ($i = 0; $i < $count; $i++) {
                                            $dateSoin = htmlspecialchars($soins['DATE_SOIN'][$i] ?? '');
                                            $nomPersonnel = htmlspecialchars($soins['NOM'][$i] ?? 'Non spécifié');
                                            $prenomPersonnel = htmlspecialchars($soins['PRENOM'][$i] ?? '');
                                            $description = htmlspecialchars($soins['DESCRIPTION_SOIN'][$i] ?? 'Non spécifiée');
                                            
                                            echo "<tr>";
                                            echo "<td><strong>{$dateSoin}</strong></td>";
                                            echo "<td>{$nomPersonnel} {$prenomPersonnel}</td>";
                                            echo "<td><span class='badge bg-info'>{$description}</span></td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning" role="alert">
                                <i class="bi bi-exclamation-triangle"></i> Aucun soin enregistré pour cet animal.
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
                <a href="index.php?action=editionAnimal&id=<?= htmlspecialchars($animal['ID_ANIMAL'] ?? '') ?>&edit=1" class="btn btn-primary">
                    <i class="bi bi-pencil"></i> Modifier
                </a>
            </div>
        </div>
    </div>
</main>