<main class="flex-grow-1">
    <div class="container my-5">
        <!-- Titre et breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php?action=home">Accueil</a></li>
                <li class="breadcrumb-item active"><?= htmlspecialchars($espece['NOM_ESPECE'] ?? 'Espèce') ?></li>
            </ol>
        </nav>

        <!-- En-tête du profil -->
        <div class="row mb-5">
            <div class="col-lg-8">
                <h1 class="display-4 mb-3 text-primary">
                    <?= htmlspecialchars($espece['NOM_ESPECE'] ?? 'Espèce inconnue') ?>
                </h1>
                <p class="lead text-muted">Profil détaillé de l'espèce</p>
            </div>
        </div>

        <!-- Accordéon des sections -->
        <div class="accordion" id="accordionEspece">
            <!-- Informations générales -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInfoGenerales">
                        <i class="bi bi-info-circle me-2"></i> Informations générales
                    </button>
                </h2>
                <div id="collapseInfoGenerales" class="accordion-collapse collapse show" data-bs-parent="#accordionEspece">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <strong style="min-width: 150px;">Nom Latin:</strong>
                                    <span class="ms-2">
                                        <?php
                                        if (!empty($espece['NOM_LATIN_ESPECE'])) {
                                            echo '<em>' . htmlspecialchars($espece['NOM_LATIN_ESPECE']) . '</em>';
                                        } else {
                                            echo '<span class="text-muted">Non spécifié</span>';
                                        }
                                        ?>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <strong style="min-width: 150px;">Statut de protection:</strong>
                                    <span class="ms-2">
                                        <?php
                                        if (!empty($espece['EST_MENACEE'])) {
                                            echo '<span class="badge bg-danger"><i class="bi bi-exclamation-triangle"></i> Espèce menacée</span>';
                                        } else {
                                            echo '<span class="badge bg-success"><i class="bi bi-check-circle"></i> Non menacée</span>';
                                        }
                                        ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Espèces compatibles -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCompatibles">
                        <i class="bi bi-heart-handshake me-2"></i> Espèces compatibles (<?= count($especesCompatibles ?? []) ?>)
                    </button>
                </h2>
                <div id="collapseCompatibles" class="accordion-collapse collapse" data-bs-parent="#accordionEspece">
                    <div class="accordion-body">
                        <?php if (!empty($especesCompatibles) && is_array($especesCompatibles)): ?>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nom</th>
                                            <th>Nom scientifique</th>
                                            <th>Statut</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($especesCompatibles as $esp): ?>
                                            <tr>
                                                <td><strong><?= htmlspecialchars($esp['NOM_ESPECE'] ?? 'N/A') ?></strong></td>
                                                <td><em><?= htmlspecialchars($esp['NOM_LATIN_ESPECE'] ?? 'N/A') ?></em></td>
                                                <td>
                                                    <?php
                                                    if (!empty($esp['EST_MENACEE'])) {
                                                        echo '<span class="badge bg-danger">Menacée</span>';
                                                    } else {
                                                        echo '<span class="badge bg-success">Non menacée</span>';
                                                    }
                                                    ?>
                                                </td>
                                                <td class="text-center">
                                                    <a href="index.php?action=profilEspece&id=<?= urlencode($esp['ID_ESPECE']) ?>" class="btn btn-sm btn-outline-primary">
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
                                <i class="bi bi-info-circle"></i> Aucune espèce compatible enregistrée.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Animaux de cette espèce -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAnimaux">
                        <i class="bi bi-paw me-2"></i> Animaux de cette espèce (<?= count($animaux ?? []) ?>)
                    </button>
                </h2>
                <div id="collapseAnimaux" class="accordion-collapse collapse" data-bs-parent="#accordionEspece">
                    <div class="accordion-body">
                        <?php if (!empty($animaux) && is_array($animaux)): ?>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nom</th>
                                            <th>Date de naissance</th>
                                            <th>Poids</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($animaux as $animal): ?>
                                            <tr>
                                                <td><strong><?= htmlspecialchars($animal['NOM_ANIMAL'] ?? 'N/A') ?></strong></td>
                                                <td>
                                                    <?php
                                                    if (!empty($animal['DATE_NAISSANCE'])) {
                                                        $dateNaissance = htmlspecialchars($animal['DATE_NAISSANCE']);
                                                        $date = DateTime::createFromFormat('d-M-y', $dateNaissance) ?: DateTime::createFromFormat('Y-m-d', $dateNaissance);
                                                        if ($date) {
                                                            echo $date->format('d/m/Y');
                                                            $maintenant = new DateTime();
                                                            $age = $maintenant->diff($date)->y;
                                                            echo " <span class='badge bg-secondary'>$age ans</span>";
                                                        } else {
                                                            echo htmlspecialchars($dateNaissance);
                                                        }
                                                    } else {
                                                        echo '<span class="text-muted">Non spécifiée</span>';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if (!empty($animal['POIDS'])) {
                                                        echo htmlspecialchars($animal['POIDS']) . ' kg';
                                                    } else {
                                                        echo '<span class="text-muted">Non spécifié</span>';
                                                    }
                                                    ?>
                                                </td>
                                                <td class="text-center">
                                                    <a href="index.php?action=profilAnimal&id=<?= urlencode($animal['ID_ANIMAL']) ?>" class="btn btn-sm btn-outline-info">
                                                        <i class="bi bi-eye"></i> Profil
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning mb-0" role="alert">
                                <i class="bi bi-exclamation-triangle"></i> Aucun animal enregistré pour cette espèce.
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
                    <a href="index.php?action=editionEspece&id=<?= htmlspecialchars($espece['ID_ESPECE'] ?? '') ?>" class="btn btn-primary">
                        <i class="bi bi-pencil"></i> Modifier
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>
