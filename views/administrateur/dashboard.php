<div class="container mt-4">
    <!-- Header de bienvenue -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h2><i class="fas fa-user-shield"></i> Tableau de bord Administrateur</h2>
                </div>
                <div class="card-body">
                    <p class="lead">Bienvenue dans l'interface d'administration du Zoo</p>
                    <p>Vous pouvez gérer tous les employés et consulter les informations des zones.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Employés -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h4><i class="fas fa-users"></i> Liste des Employés (<?= count($employees) ?>)</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <a href="index.php?action=creationEmployee" class="btn btn-success">
                            <i class="fas fa-user-plus"></i> Ajouter un Employé
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Email</th>
                                    <th>Login</th>
                                    <th>Salaire</th>
                                    <th>Date d'entrée</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($employees)): ?>
                                    <?php foreach ($employees as $employee): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($employee['ID_PERSONNEL'] ?? '') ?></td>
                                            <td><?= htmlspecialchars($employee['NOM'] ?? '') ?></td>
                                            <td><?= htmlspecialchars($employee['PRENOM'] ?? '') ?></td>
                                            <td><?= htmlspecialchars($employee['MAIL'] ?? 'N/A') ?></td>
                                            <td><?= htmlspecialchars($employee['LOGIN'] ?? 'N/A') ?></td>
                                            <td><?= htmlspecialchars(number_format($employee['SALAIRE'] ?? 0, 2)) ?> €</td>
                                            <td><?= htmlspecialchars($employee['DATE_ENTREE'] ?? 'N/A') ?></td>
                                            <td>
                                                <a href="index.php?action=editionEmployee&id=<?= $employee['ID_PERSONNEL'] ?>" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i> Modifier
                                                </a>
                                                <a href="index.php?action=supprEmployee&id=<?= $employee['ID_PERSONNEL'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet employé ?')">
                                                    <i class="fas fa-trash"></i> Supprimer
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center">Aucun employé trouvé</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Zones et Boutiques -->
    <div class="row mb-4">
        <!-- Colonne Zones -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-success text-white">
                    <h4><i class="fas fa-map-marked-alt"></i> Liste des Zones (<?= count($zones) ?>)</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <a href="index.php?action=creationZone" class="btn btn-success">
                            <i class="fas fa-plus"></i> Créer une Zone
                        </a>
                    </div>
                    <?php if (!empty($zones)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nom de la Zone</th>
                                        <th>Manager</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($zones as $zone): ?>
                                        <?php
                                        // Récupérer le nom du manager pour chaque zone
                                        $nomManager = !empty($zone['ID_MANAGER']) ? Zone::recupNomManager($zone['ID_ZONE']) : null;
                                        ?>
                                        <tr>
                                            <td><?= htmlspecialchars($zone['ID_ZONE'] ?? 'N/A') ?></td>
                                            <td><?= htmlspecialchars($zone['NOM_ZONE'] ?? 'N/A') ?></td>
                                            <td>
                                                <?php if (!empty($nomManager)): ?>
                                                    <?= htmlspecialchars($nomManager['PRENOM'] ?? '') ?> <?= htmlspecialchars($nomManager['NOM'] ?? '') ?>
                                                <?php else: ?>
                                                    <span class="text-muted">Non assigné</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="index.php?action=editionZone&id=<?= $zone['ID_ZONE'] ?>" class="btn btn-sm btn-primary">
                                                    Modifier
                                                </a>
                                                <a href="index.php?action=supprZone&id=<?= $zone['ID_ZONE'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette zone ?')">
                                                    Supprimer
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> Aucune zone disponible.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Colonne Boutiques -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-warning text-dark">
                    <h4><i class="fas fa-store"></i> Liste des Boutiques (<?= count($boutiques) ?>)</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <a href="index.php?action=creationBoutique" class="btn btn-success">
                            <i class="fas fa-plus"></i> Créer une Boutique
                        </a>
                    </div>
                    <?php if (!empty($boutiques)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nom</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($boutiques as $boutique): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($boutique['ID_BOUTIQUE'] ?? 'N/A') ?></td>
                                            <td><?= htmlspecialchars($boutique['NOM_BOUTIQUE'] ?? 'N/A') ?></td>
                                            <td>
                                                <a href="index.php?action=editionBoutique&id=<?= $boutique['ID_BOUTIQUE'] ?>" class="btn btn-sm btn-primary">
                                                    Modifier
                                                </a>
                                                <a href="index.php?action=supprBoutique&id=<?= $boutique['ID_BOUTIQUE'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette boutique ?')">
                                                    Supprimer
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> Aucune boutique disponible.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>