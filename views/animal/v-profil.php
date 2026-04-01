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

        <!-- Accordéon des sections -->
        <div class="accordion" id="accordionAnimal">
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
                                    <strong style="min-width: 150px;">Espèce:</strong>
                                    <span class="ms-2"><?= htmlspecialchars($animal['NOM_ESPECE'] ?? 'Non spécifiée') ?></span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <strong style="min-width: 150px;">Date de naissance:</strong>
                                    <span class="ms-2">
                                        <?php
                                        if (!empty($animal['DATE_NAISSANCE'])) {
                                            $dateNaissance = htmlspecialchars($animal['DATE_NAISSANCE']);
                                            $date = DateTime::createFromFormat('d-M-y', $dateNaissance) ?: DateTime::createFromFormat('Y-m-d', $dateNaissance);
                                            if ($date) {
                                                echo $date->format('d/m/Y');
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
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Caractéristiques physiques -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCaracteristiques">
                        <i class="bi bi-heart-pulse me-2"></i> Caractéristiques physiques
                    </button>
                </h2>
                <div id="collapseCaracteristiques" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <strong style="min-width: 150px;">Poids:</strong>
                                    <span class="ms-2">
                                        <?php
                                        if (!empty($animal['POIDS'])) {
                                            echo htmlspecialchars($animal['POIDS']) . ' kg';
                                        } else {
                                            echo '<span class="text-muted">Non spécifié</span>';
                                        }
                                        ?>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <strong style="min-width: 150px;">Régime alimentaire:</strong>
                                    <span class="ms-2">
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
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Localisation -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLocalisation">
                        <i class="bi bi-geo-alt me-2"></i> Localisation
                    </button>
                </h2>
                <div id="collapseLocalisation" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <strong style="min-width: 150px;">Latitude:</strong>
                                    <span class="ms-2">
                                        <?= !empty($animal['LATITUDE_ENCLOS'])
                                            ? htmlspecialchars($animal['LATITUDE_ENCLOS'])
                                            : '<span class="text-muted">Non spécifiée</span>'
                                        ?>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <strong style="min-width: 150px;">Longitude:</strong>
                                    <span class="ms-2">
                                        <?= !empty($animal['LONGITUDE_ENCLOS'])
                                            ? htmlspecialchars($animal['LONGITUDE_ENCLOS'])
                                            : '<span class="text-muted">Non spécifiée</span>'
                                        ?>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <a href="index.php?action=profilEnclos&latitude=<?= htmlspecialchars($animal['LATITUDE_ENCLOS']) ?>&longitude=<?= htmlspecialchars($animal['LONGITUDE_ENCLOS']) ?>" class="btn btn-sm btn-outline-info mb-3">
                                        <i class="bi bi-eye"></i> Voir le profil de l'enclos
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Doses de nourriture -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNourriture">
                        <i class="bi bi-egg me-2"></i> Doses de nourriture
                    </button>
                </h2>
                <div id="collapseNourriture" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <?php if (!empty($nourritures) && isset($nourritures[0])): ?>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Date de nourriture</th>
                                            <th>Personnel</th>
                                            <th>Dose (kg)</th>
                                            <?php if (isset($_SESSION['user']['ID_FONCTION']) && $_SESSION['user']['ID_FONCTION'] == ADMINID): ?>
                                                <th>Actions</th>
                                            <?php endif; ?>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($nourritures as $nourriture):
                                            $dateNourrit = htmlspecialchars($nourriture['DATE_NOURRIT'] ?? '');
                                            $nomPersonnel = htmlspecialchars($nourriture['NOM'] ?? 'Non spécifié');
                                            $prenomPersonnel = htmlspecialchars($nourriture['PRENOM'] ?? '');
                                            $dose = htmlspecialchars($nourriture['DOSE_NOURRITURE'] ?? '');
                                        ?>
                                            <tr>
                                                <td><strong><?= $dateNourrit ?></strong></td>
                                                <td><?= $nomPersonnel . " " . $prenomPersonnel ?></td>
                                                <td><span class='badge bg-success'><?= $dose ?> kg</span></td>
                                                <?php if (isset($_SESSION['user']['ID_FONCTION']) && $_SESSION['user']['ID_FONCTION'] == ADMINID): ?>
                                                    <td> <a href="index.php?action=supprimerNourriture&idAnimal=<?= $nourriture['ID_ANIMAL'] ?>&dateNourrit=<?= urlencode($nourriture['DATE_NOURRIT']) ?>&idSoigneur=<?= $nourriture['ID_PERSONNEL'] ?>" class='btn btn-outline-danger' onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce soin ?')">
                                                            <i class='bi bi-trash'></i> Supprimer
                                                        </a>
                                                    </td>

                                                <?php endif; ?>

                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning mb-0" role="alert">
                                <i class="bi bi-exclamation-triangle"></i> Aucune dose de nourriture enregistrée pour cet animal.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Historique des soins -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSoins">
                        <i class="bi bi-hospital me-2"></i> Historique des soins
                    </button>
                </h2>
                <div id="collapseSoins" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <?php if (!empty($soins) && isset($soins) && is_array($soins)): ?>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Date du soin</th>
                                            <th>Personnel</th>
                                            <th>Description</th>
                                            <?php if (isset($_SESSION['user']['ID_FONCTION']) && $_SESSION['user']['ID_FONCTION'] == ADMINID): ?>
                                                <th>Actions</th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($soins as $soin): ?>
                                            <tr>
                                                <td><strong><?= htmlspecialchars($soin['DATE_SOIN'] ?? ''); ?></strong></td>
                                                <td><?= htmlspecialchars($soin['NOM'] ?? 'Non spécifié') . " " . htmlspecialchars($soin['NOM'] ?? 'Non spécifié'); ?></td>
                                                <td><span class='badge bg-info'><?= htmlspecialchars($soin['DESCRIPTION_SOIN'] ?? 'Non spécifiée'); ?></span></td>

                                                <?php if (isset($_SESSION['user']['ID_FONCTION']) && $_SESSION['user']['ID_FONCTION'] == ADMINID): ?>
                                                    <td>
                                                        <a href="index.php?action=supprimerSoin&idAnimal=<?= $animal['ID_ANIMAL'] ?>&dateSoin=<?= urlencode($soin['DATE_SOIN']) ?>" class='btn btn-outline-danger' onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce soin ?')">
                                                            <i class='bi bi-trash'></i> Supprimer
                                                        </a>
                                                    </td>
                                                <?php endif; ?>

                                            </tr>
                                        <?php endforeach; ?>


                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning mb-0" role="alert">
                                <i class="bi bi-exclamation-triangle"></i> Aucun soin enregistré pour cet animal.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Parrains -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseParrains">
                        <i class="bi bi-people-fill me-2"></i> Parrains
                    </button>
                </h2>
                <div id="collapseParrains" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <?php if (!empty($parrains) && is_array($parrains)): ?>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nom du Visiteur</th>
                                            <th>Niveau de Parrainage</th>
                                            <?php if (isset($_SESSION['user']['ID_FONCTION']) && $_SESSION['user']['ID_FONCTION'] == ADMINID): ?>
                                                <th>Actions</th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($parrains as $parrain):
                                            $id_visiteur = htmlspecialchars($parrain['ID_VISITEUR'] ?? '');
                                            $nomVisiteur = htmlspecialchars($parrain['NOM_VISITEUR'] ?? 'Non spécifié');
                                            $niveau = htmlspecialchars($parrain['LIBELLE'] ?? 'Non spécifié');

                                            // Couleur du badge selon le niveau
                                            $badgeClass = 'bg-secondary';
                                            if (stripos($niveau, 'diamant') !== false) {
                                                $badgeClass = 'bg-info';
                                            } elseif (stripos($niveau, 'platine') !== false) {
                                                $badgeClass = 'bg-warning text-dark';
                                            } elseif (stripos($niveau, 'or') !== false) {
                                                $badgeClass = 'bg-success';
                                            } elseif (stripos($niveau, 'argent') !== false) {
                                                $badgeClass = 'bg-dark';
                                            } elseif (stripos($niveau, 'bronze') !== false) {
                                                $badgeClass = 'bg-danger';
                                            } ?>

                                            <tr>
                                                <td><strong><?= $nomVisiteur; ?></strong></td>
                                                <td><span class='badge <?= $badgeClass ?>'><?= $niveau ?></span>
                                                    <?php if (isset($_SESSION['user']['ID_FONCTION']) && $_SESSION['user']['ID_FONCTION'] == ADMINID): ?>
                                                <td><a href="index.php?action=supprimerParrainage&idAnimal=<?= $animal['ID_ANIMAL']  ?>&idVisiteur=<?= $parrain['ID_VISITEUR'] ?>" class='btn btn-outline-danger' onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet employé ?')" title='Supprimer'>
                                                        <i class='bi bi-trash'></i>Supprimer
                                                    </a>
                                                <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning mb-0" role="alert">
                                <i class="bi bi-exclamation-triangle"></i> Aucun parrain enregistré pour cet animal.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Ajouter un parrain (Réservé RESPSOIG et ADMIN) -->
            <?php if (isset($_SESSION['user']['ID_FONCTION']) && ($_SESSION['user']['ID_FONCTION'] == RESPSOIG || $_SESSION['user']['ID_FONCTION'] == ADMINID)): ?>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAjouterParrain">
                            <i class="bi bi-person-plus me-2"></i> Ajouter un Parrain
                        </button>
                    </h2>
                    <div id="collapseAjouterParrain" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <form action="index.php?action=ajouterParrainage" method="POST" class="needs-validation">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="id_visiteur" class="form-label">Sélectionner un Visiteur</label>
                                            <select class="form-select" id="id_visiteur" name="id_visiteur" required>
                                                <option value="">-- Choisir un visiteur --</option>
                                                <?php
                                                if (!empty($visiteurs) && is_array($visiteurs)):
                                                    foreach ($visiteurs as $visiteur):
                                                        $id_visiteur = htmlspecialchars($visiteur['ID_VISITEUR'] ?? '');
                                                        $nom_visiteur = htmlspecialchars($visiteur['NOM_VISITEUR'] ?? 'Visiteur inconnu');
                                                        echo "<option value=\"{$id_visiteur}\">{$nom_visiteur}</option>";
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="libelle" class="form-label">Type de Parrainage</label>
                                            <select class="form-select" id="libelle" name="libelle" required>
                                                <option value="">-- Choisir un type --</option>
                                                <?php
                                                if (!empty($libelles) && is_array($libelles)):
                                                    foreach ($libelles as $libelle):
                                                        $nom_niveau = htmlspecialchars($libelle['LIBELLE'] ?? 'Non spécifié');
                                                        echo "<option value=\"{$libelle['LIBELLE']}\">{$nom_niveau}</option>";
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="id_animal" value="<?= htmlspecialchars($animal['ID_ANIMAL'] ?? '') ?>">
                                <div class="row mt-3">
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-success">
                                            <i class="bi bi-check-circle"></i> Ajouter le parrainage
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
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
                    <a href="index.php?action=editionAnimal&id=<?= htmlspecialchars($animal['ID_ANIMAL'] ?? '') ?>&edit=1" class="btn btn-primary">
                        <i class="bi bi-pencil"></i> Modifier
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>