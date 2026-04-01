<?php
// Ce fichier affiche la page de moteur de recherche
// Ce fichier affiche la page de moteur de recherche
$searchTerm = $searchTerm ?? '';
$results = $results ?? [];
$message = $message ?? '';
// Filtres avancés récupérés depuis l'URL
$filter_espece = $_GET['filter_espece'] ?? '';
$filter_zone = $_GET['filter_zone'] ?? '';
$filter_regime = $_GET['filter_regime'] ?? '';
$filter_type_enclos = $_GET['filter_type_enclos'] ?? '';
?>

<main class="container my-5 flex-grow-1">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="mb-4"><i class="bi bi-search"></i> Moteur de Recherche</h1>

            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">Recherche Globale</h5>

                    <!-- FORMULAIRE PRINCIPAL -->
                    <form method="GET" action="index.php" class="mb-3">
                        <input type="hidden" name="action" value="search">
                        <input type="hidden" name="search_action" value="recherche_globale">

                        <div class="input-group mb-3" style="max-width: 600px;">
                            <input
                                type="text"
                                class="form-control form-control-lg"
                                name="q"
                                placeholder="Rechercher un animal, une espèce, une zone, un employé..."
                                value="<?= htmlspecialchars($searchTerm) ?>"
                                autocomplete="off">
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-search"></i> Rechercher
                            </button>
                        </div>

                        <!-- 🔽 FILTRES AVANCÉS -->
                        <div class="card p-3 bg-light border">
                            <h6 class="mb-3"><i class="bi bi-funnel"></i> Filtres avancés</h6>

                            <div class="row g-3">

                                <!-- Filtre Espèce -->
                                <div class="col-md-3">
                                    <label class="form-label">Espèce</label>
                                    <input type="text" name="filter_espece" class="form-control"
                                        placeholder="Ex : Lion"
                                        value="<?= htmlspecialchars($filter_espece) ?>">
                                </div>

                                <!-- Filtre Zone -->

                                <div class="col-md-3">
                                    <label class="form-label">Zone</label>
                                    <select name="filter_zone" class="form-select">
                                        <option value="">Sélectionnez une zone</option>

                                        <?php foreach ($zones as $z): ?>
                                            <option value="<?= htmlspecialchars($z['ID_ZONE']) ?>">
                                                <?= htmlspecialchars($z['NOM_ZONE']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>


                                <!-- Filtre Régime alimentaire -->
                                <div class="col-md-3">
                                    <label class="form-label">Régime alimentaire</label>
                                    <select name="filter_regime" class="form-select">
                                        <option value="">Tous</option>
                                        <option value="Carnivore" <?= $filter_regime === "Carnivore" ? "selected" : "" ?>>Carnivore</option>
                                        <option value="Herbivore" <?= $filter_regime === "Herbivore" ? "selected" : "" ?>>Herbivore</option>
                                        <option value="Omnivore" <?= $filter_regime === "Omnivore" ? "selected" : "" ?>>Omnivore</option>
                                    </select>
                                </div>

                                <!-- Filtre Type d'enclos -->
                                <div class="col-md-3">
                                    <label class="form-label">Type d'enclos</label>
                                    <input type="text" name="filter_type_enclos" class="form-control"
                                        placeholder="Ex : Extérieur"
                                        value="<?= htmlspecialchars($filter_type_enclos) ?>">
                                </div>
                            </div>

                            <div class="mt-3 text-end">
                                <button class="btn btn-secondary" type="submit">
                                    <i class="bi bi-funnel"></i> Appliquer les filtres
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Message d'information -->
                    <?php if (!empty($message)): ?>
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <i class="bi bi-info-circle"></i> <?= htmlspecialchars($message) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Résultats -->
                    <?php if (!empty($searchTerm) || !empty($filter_espece) || !empty($filter_zone) || !empty($filter_regime) || !empty($filter_type_enclos)): ?>
                        <div class="search-results">
                            <!-- Animaux -->
                            <?php if (!empty($results['animals'])): ?>
                                <div class="mb-4">
                                    <h5 class="mb-3">
                                        <i class="bi bi-paw"></i> Animaux
                                        <span class="badge bg-primary"><?= count($results['animals']) ?></span>
                                    </h5>
                                    <div class="list-group">
                                        <?php foreach ($results['animals'] as $animal): ?>
                                            <a href="index.php?action=profilAnimal&id=<?= $animal['ID_ANIMAL'] ?>" class="list-group-item list-group-item-action">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h6 class="mb-1"><?= htmlspecialchars($animal['NOM_ANIMAL']) ?></h6>
                                                    <small class="text-muted"><?= htmlspecialchars($animal['REGIME_ALIMENTAIRE']) ?></small>
                                                </div>
                                                <p class="mb-1 text-muted">
                                                    <small>
                                                        Poids: <?= htmlspecialchars($animal['POIDS'] ?? 'N/A') ?> kg |
                                                        Né le: <?= htmlspecialchars($animal['DATE_NAISSANCE'] ?? 'N/A') ?>
                                                    </small>
                                                </p>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <!-- (Les autres sections restent identiques) -->
                            <!-- Espèces -->
                            <?php if (!empty($results['especes'])): ?>
                                <div class="mb-4">
                                    <h5 class="mb-3">
                                        <i class="bi bi-diagram-2"></i> Espèces
                                        <span class="badge bg-success"><?= count($results['especes']) ?></span>
                                    </h5>
                                    <div class="list-group">
                                        <?php foreach ($results['especes'] as $espece): ?>
                                            <a href="index.php?action=profilEspece&id=<?= $espece['ID_ESPECE'] ?>" class="list-group-item list-group-item-action">
                                                <h6 class=" mb-1"><?= htmlspecialchars($espece['NOM_ESPECE'] ?? 'N/A') ?></h6>
                                                <p class="mb-0 text-muted">
                                                    <small><?= htmlspecialchars($espece['NOM_LATIN_ESPECE'] ?? 'N/A') ?></small>
                                                </p>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <!-- Zones -->
                            <?php if (!empty($results['zones'])): ?>
                                <div class="mb-4">
                                    <h5 class="mb-3">
                                        <i class="bi bi-map"></i> Zones
                                        <span class="badge bg-warning"><?= count($results['zones']) ?></span>
                                    </h5>
                                    <div class="list-group">
                                        <?php foreach ($results['zones'] as $zone): ?>
                                            <div class="list-group-item">
                                                <a href="index.php?action=profilZone&id=<?= htmlspecialchars($zone['ID_ZONE'] ?? '') ?>" class="text-decoration-none">
                                                    <h6 class="mb-1"><?= htmlspecialchars($zone['NOM_ZONE'] ?? 'N/A') ?></h6>
                                                </a>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <!-- Enclos -->
                            <?php if (!empty($results['enclos'])): ?>
                                <div class="mb-4">
                                    <h5 class="mb-3">
                                        <i class="bi bi-paw"></i> Enclos
                                        <span class="badge bg-primary"><?= count($results['enclos']) ?></span>
                                    </h5>
                                    <div class="list-group">
                                        <?php foreach ($results['enclos'] as $enclos): ?>
                                            <a href="index.php?action=profilEnclos&latitude=<?= $enclos['LATITUDE'] ?>&longitude=<?= $enclos['LONGITUDE'] ?>" class="list-group-item list-group-item-action">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h6 class="mb-1"><?= htmlspecialchars($enclos['TYPE_ENCLOS']) ?></h6>
                                                </div>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <!-- Employés -->
                            <?php if (!empty($results['employes'])): ?>
                                <div class="mb-4">
                                    <h5 class="mb-3">
                                        <i class="bi bi-person-workspace"></i> Employés
                                        <span class="badge bg-info"><?= count($results['employes']) ?></span>
                                    </h5>
                                    <div class="list-group">
                                        <?php foreach ($results['employes'] as $employe): ?>
                                            <div class="list-group-item">
                                                <a href="index.php?action=profil&id=<?= htmlspecialchars($employe['ID_PERSONNEL'] ?? '') ?>" class="text-decoration-none">
                                                    <h6 class="mb-1"><?= htmlspecialchars(($employe['NOM'] ?? '') . ' ' . ($employe['PRENOM'] ?? '')) ?></h6>
                                                    <p class="mb-0 text-muted">
                                                        <small>
                                                            Email: <?= htmlspecialchars($employe['MAIL'] ?? 'N/A') ?>
                                                        </small>
                                                    </p>
                                                </a>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <!-- Boutiques -->
                            <?php if (!empty($results['boutiques'])): ?>
                                <div class="mb-4">
                                    <h5 class="mb-3">
                                        <i class="bi bi-shop"></i> Boutiques
                                        <span class="badge bg-danger"><?= count($results['boutiques']) ?></span>
                                    </h5>
                                    <div class="list-group">
                                        <?php foreach ($results['boutiques'] as $boutique): ?>
                                            <div class="list-group-item">
                                                <a href="index.php?action=profilBoutique&id=<?= htmlspecialchars($boutique['ID_BOUTIQUE'] ?? '') ?>" class="text-decoration-none">
                                                    <h6 class="mb-1"><?= htmlspecialchars($boutique['NOM_BOUTIQUE'] ?? 'N/A') ?></h6>
                                                    <p class="mb-0 text-muted">
                                                        <small><?= htmlspecialchars($boutique['DESCRIPTION_BOUTIQUE'] ?? 'N/A') ?></small>
                                                    </p>
                                                </a>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-light text-center py-5" role="alert">
                            <i class="bi bi-search" style="font-size: 3rem; opacity: 0.3;"></i>
                            <p class="mt-3 text-muted">Commencez votre recherche en entrant un terme ou en utilisant les filtres</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>