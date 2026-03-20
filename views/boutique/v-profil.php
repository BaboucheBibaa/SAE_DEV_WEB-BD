<div class="container py-5">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="bg-primary bg-opacity-10 rounded-3 p-3">
                    <i class="bi bi-shop fs-3 text-primary"></i>
                </div>
                <div>
                    <h1 class="h3 mb-0 fw-bold"><?= htmlspecialchars($boutique['NOM_BOUTIQUE'] ?? '') ?></h1>
                    <p class="text-muted small mb-0">Zoo'land - Boutique</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 text-end">
            <?php if (isset($_SESSION['user']['ID_FONCTION']) && $_SESSION['user']['ID_FONCTION'] == ADMINID): ?>
                <a href="index.php?action=editionBoutique&id=<?= $boutique['ID_BOUTIQUE'] ?>" class="btn btn-primary">
                    <i class="bi bi-pencil-square"></i> Modifier
                </a>
            <?php endif; ?>
            <a href="index.php?action=home" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="row g-4">
        <!-- Left Column: Main Info -->
        <div class="col-lg-8">
            <!-- Description Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-info-circle text-primary"></i> Informations
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="text-muted small fw-bold">Zone d'installation</label>
                            <p class="mb-0"><?= htmlspecialchars($boutique['NOM_ZONE'] ?? 'N/A') ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label class="text-muted small fw-bold">Description</label>
                            <p class="mb-0">
                                <?= !empty($boutique['DESCRIPTION_BOUTIQUE']) 
                                    ? htmlspecialchars($boutique['DESCRIPTION_BOUTIQUE']) 
                                    : '<em class="text-muted">Aucune description disponible</em>' ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Staff Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-people text-primary"></i> Personnel de la boutique
                    </h5>
                </div>
                <div class="card-body">
                    <?php 
                    $employes = $boutique['EMPLOYES'] ?? [];
                    if (!empty($employes)): 
                    ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">Nom</th>
                                        <th scope="col">Prénom</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($employes as $employe): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($employe['NOM'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($employe['PRENOM'] ?? '') ?></td>
                                        <td>
                                            <a href="index.php?action=profil&id=<?= $employe['ID_PERSONNEL'] ?>" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i> Voir profil
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted text-center mb-0">
                            <i class="bi bi-inbox"></i> Aucun personnel affecté à cette boutique
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Right Column: Summary -->
        <div class="col-lg-4">
            <!-- Status Card -->
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0 fw-bold text-primary">
                        <i class="bi bi-speedometer2"></i> Résumé
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                        <span class="text-muted">Effectif</span>
                        <span class="badge bg-info rounded-pill">
                            <?= count($employes) ?>
                        </span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Responsable</span>
                        <span class="small">
                            <?= !empty($boutique['NOM_MANAGER']) 
                                ? htmlspecialchars($boutique['NOM_MANAGER']." ".$boutique['PRENOM_MANAGER']) 
                                : '<em class="text-muted">Non assigné</em>' ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0 fw-bold text-primary">
                        <i class="bi bi-lightning"></i> Actions rapides
                    </h6>
                </div>
                <div class="card-body d-flex flex-column gap-2">

                    <?php if (isset($_SESSION['user']['ID_FONCTION']) && $_SESSION['user']['ID_FONCTION'] == RESPBOUTIQUE): ?>
                        <a href="index.php?action=statsBoutique&id=<?= $boutique['ID_BOUTIQUE'] ?>" 
                           class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-bar-chart"></i> Statistiques
                        </a>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['user']['ID_FONCTION']) && $_SESSION['user']['ID_FONCTION'] == ADMINID): ?>
                        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirmDelete">
                            <i class="bi bi-trash"></i> Supprimer
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<?php if (isset($_SESSION['user']['ID_FONCTION']) && $_SESSION['user']['ID_FONCTION'] == ADMINID): ?>
<div class="modal fade" id="confirmDelete" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger bg-opacity-10">
                <h5 class="modal-title" id="confirmDeleteLabel">
                    <i class="bi bi-exclamation-triangle text-danger"></i> Confirmation de suppression
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer la boutique 
                   <strong><?= htmlspecialchars($boutique['NOM_BOUTIQUE'] ?? '') ?></strong> ?
                </p>
                <p class="text-muted small">Cette action est irréversible.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form method="POST" action="index.php" style="display: inline;">
                    <input type="hidden" name="action" value="deleteBoutique">
                    <input type="hidden" name="id" value="<?= $boutique['ID_BOUTIQUE'] ?>">
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
