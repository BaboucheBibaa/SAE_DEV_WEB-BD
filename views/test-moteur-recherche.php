<?php
// Ce fichier affiche la page de moteur de recherche
$searchTerm = $searchTerm ?? '';
$selectedCategory = $selectedCategory ?? '';
$results = $results ?? [];
$advancedResults = $advancedResults ?? [];
$message = $message ?? '';
$filtres = $filtres ?? [];

// Déterminer quel onglet afficher
$currentTab = isset($_GET['tab']) ? $_GET['tab'] : 'global';
?>

<main class="container my-5 flex-grow-1">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="mb-4"><i class="bi bi-search"></i> Moteur de Recherche</h1>

            <!-- Navigation par onglets (boutons) -->
            <div class="btn-group mb-4" role="group">
                <a href="index.php?action=search&tab=global" class="btn btn-outline-primary <?= $currentTab === 'global' ? 'active' : '' ?>">
                    <i class="bi bi-globe"></i> Recherche Globale
                </a>
                <a href="index.php?action=search&tab=advanced" class="btn btn-outline-primary <?= $currentTab === 'advanced' ? 'active' : '' ?>">
                    <i class="bi bi-funnel"></i> Recherche Avancée
                </a>
            </div>

            <!-- Onglet Recherche Globale -->
            <?php if ($currentTab === 'global'): ?>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Recherche Globale</h5>
                        <form method="GET" action="index.php" class="mb-3">
                            <input type="hidden" name="action" value="search">
                            <input type="hidden" name="search_action" value="recherche_globale">
                            <input type="hidden" name="tab" value="global">
                            
                            <div class="input-group mb-3" style="max-width: 600px;">
                                <input 
                                    type="text" 
                                    class="form-control form-control-lg" 
                                    name="q" 
                                    placeholder="Rechercher un animal, une espèce, une zone, un employé..."
                                    value="<?= htmlspecialchars($searchTerm) ?>"
                                    autocomplete="off"
                                >
                                <button class="btn btn-primary" type="submit">
                                    <i class="bi bi-search"></i> Rechercher
                                </button>
                            </div>
                        </form>

                        <!-- Message d'information -->
                        <?php if (!empty($message)): ?>
                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                <i class="bi bi-info-circle"></i> <?= htmlspecialchars($message) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <!-- Résultats de la recherche globale -->
                        <?php if (!empty($searchTerm)): ?>
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

                                <!-- Espèces -->
                                <?php if (!empty($results['especes'])): ?>
                                    <div class="mb-4">
                                        <h5 class="mb-3">
                                            <i class="bi bi-diagram-2"></i> Espèces 
                                            <span class="badge bg-success"><?= count($results['especes']) ?></span>
                                        </h5>
                                        <div class="list-group">
                                            <?php foreach ($results['especes'] as $espece): ?>
                                                <div class="list-group-item">
                                                    <h6 class="mb-1"><?= htmlspecialchars($espece['NOM_ESPECE'] ?? 'N/A') ?></h6>
                                                    <p class="mb-0 text-muted">
                                                        <small><?= htmlspecialchars($espece['NOM_LATIN_ESPECE'] ?? 'N/A') ?></small>
                                                    </p>
                                                </div>
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
                                                    <h6 class="mb-1"><?= htmlspecialchars($zone['NOM_ZONE'] ?? 'N/A') ?></h6>
                                                </div>
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
                                                    <h6 class="mb-1"><?= htmlspecialchars(($employe['NOM'] ?? '') . ' ' . ($employe['PRENOM'] ?? '')) ?></h6>
                                                    <p class="mb-0 text-muted">
                                                        <small>
                                                            Email: <?= htmlspecialchars($employe['MAIL'] ?? 'N/A') ?>
                                                        </small>
                                                    </p>
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
                                                    <h6 class="mb-1"><?= htmlspecialchars($boutique['NOM_BOUTIQUE'] ?? 'N/A') ?></h6>
                                                    <p class="mb-0 text-muted">
                                                        <small><?= htmlspecialchars($boutique['DESCRIPTION_BOUTIQUE'] ?? 'N/A') ?></small>
                                                    </p>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-light text-center py-5" role="alert">
                                <i class="bi bi-search" style="font-size: 3rem; opacity: 0.3;"></i>
                                <p class="mt-3 text-muted">Commencez votre recherche en entrant un terme ci-dessus</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            <!-- Onglet Recherche Avancée -->
            <?php else: ?>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Recherche Avancée</h5>
                        <form method="GET" action="index.php" class="mb-3">
                            <input type="hidden" name="action" value="search">
                            <input type="hidden" name="search_action" value="recherche_avancee">
                            <input type="hidden" name="tab" value="advanced">
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="searchTermAdv" class="form-label">Terme de recherche</label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="searchTermAdv"
                                        name="q" 
                                        placeholder="Entrez votre terme..."
                                        value="<?= htmlspecialchars($searchTerm) ?>"
                                        required
                                    >
                                </div>
                                <div class="col-md-6">
                                    <label for="categorySelect" class="form-label">Catégorie</label>
                                    <select class="form-select" id="categorySelect" name="category" required>
                                        <option value="">-- Sélectionner une catégorie --</option>
                                        <option value="animal" <?= $selectedCategory === 'animal' ? 'selected' : '' ?>>Animaux</option>
                                        <option value="espece" <?= $selectedCategory === 'espece' ? 'selected' : '' ?>>Espèces</option>
                                        <option value="zone" <?= $selectedCategory === 'zone' ? 'selected' : '' ?>>Zones</option>
                                        <option value="employe" <?= $selectedCategory === 'employe' ? 'selected' : '' ?>>Employés</option>
                                        <option value="boutique" <?= $selectedCategory === 'boutique' ? 'selected' : '' ?>>Boutiques</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Filtres pour Animaux -->
                            <?php if ($selectedCategory === 'animal'): ?>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="filterEspece" class="form-label">Espèce (optionnel)</label>
                                        <select class="form-select" id="filterEspece" name="espece">
                                            <option value="">-- Toutes les espèces --</option>
                                            <?php if (!empty($filtres['especes'])): ?>
                                                <?php foreach ($filtres['especes'] as $e): ?>
                                                    <option value="<?= $e['ID_ESPECE'] ?>"><?= htmlspecialchars($e['NOM_ESPECE']) ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="filterZone" class="form-label">Zone (optionnel)</label>
                                        <select class="form-select" id="filterZone" name="zone">
                                            <option value="">-- Toutes les zones --</option>
                                            <?php if (!empty($filtres['zones'])): ?>
                                                <?php foreach ($filtres['zones'] as $z): ?>
                                                    <option value="<?= $z['ID_ZONE'] ?>"><?= htmlspecialchars($z['NOM_ZONE']) ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Filtres pour Employés -->
                            <?php if ($selectedCategory === 'employe'): ?>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="filterFonction" class="form-label">Fonction (optionnel)</label>
                                        <select class="form-select" id="filterFonction" name="fonction">
                                            <option value="">-- Toutes les fonctions --</option>
                                            <?php if (!empty($filtres['fonctions'])): ?>
                                                <?php foreach ($filtres['fonctions'] as $f): ?>
                                                    <option value="<?= $f['ID_Fonction'] ?>"><?= htmlspecialchars($f['Nom_Fonction']) ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="d-flex gap-2">
                                <button class="btn btn-primary" type="submit">
                                    <i class="bi bi-search"></i> Rechercher
                                </button>
                                <a href="index.php?action=search&tab=advanced" class="btn btn-secondary">
                                    <i class="bi bi-arrow-counterclockwise"></i> Réinitialiser
                                </a>
                            </div>
                        </form>

                        <!-- Résultats de la recherche avancée -->
                        <?php if (!empty($advancedResults)): ?>
                            <hr class="my-4">
                            <h5 class="mb-3">
                                <i class="bi bi-card-list"></i> Résultats 
                                <span class="badge bg-primary"><?= count($advancedResults) ?></span>
                            </h5>

                            <?php if (count($advancedResults) > 0): ?>
                                <div class="list-group">
                                    <?php foreach ($advancedResults as $result): ?>
                                        <div class="list-group-item">
                                            <div class="row">
                                                <?php foreach ($result as $key => $value): ?>
                                                    <div class="col-md-6 mb-2">
                                                        <small class="text-uppercase text-muted fw-bold"><?= str_replace('_', ' ', $key) ?></small>
                                                        <p class="mb-0"><?= htmlspecialchars($value ?? 'N/A') ?></p>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        <?php elseif (!empty($message) && !empty($searchTerm)): ?>
                            <hr class="my-4">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle"></i> <?= htmlspecialchars($message) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>
