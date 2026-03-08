<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h2><i class="fas fa-map-marked-alt"></i> Gestion des Soigneurs de la Zone - <?= htmlspecialchars($zone['NOM_ZONE'] ?? 'Aucune zone assignée') ?></h2>
                </div>
                <div class="card-body">
                    <?php if (isset($zone)): ?>
                        <p class="lead">Bienvenue, <?= htmlspecialchars($user['PRENOM'] . ' ' . $user['NOM']) ?>!</p>
                        <p>Vous êtes responsable de la zone : <strong><?= htmlspecialchars($zone['NOM_ZONE']) ?></strong></p>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> Vous n'êtes pas encore assigné à une zone.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php if (isset($zone)): ?>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h4><i class="fas fa-users"></i> Liste des soigneurs de ma zone (<?= count($employes) ?>)</h4>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($employes)): ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Nom</th>
                                            <th>Prénom</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($employes as $employe): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($employe['NOM']) ?></td>
                                                <td><?= htmlspecialchars($employe['PRENOM']) ?></td>
                                                <td>
                                                    <a href="index.php?action=profil&id=<?= htmlspecialchars($employe['ID_PERSONNEL']) ?>" class="btn btn-sm btn-primary" title="Voir le profil">
                                                        Voir le profil
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> Aucun employé n'est actuellement affecté à cette zone.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Colonne Enclos -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-success text-white">
                        <h4><i class="fas fa-border-all"></i> Liste des enclos de ma zone (<?= count($enclos) ?>)</h4>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($enclos)): ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Latitude</th>
                                            <th>Longitude</th>
                                            <th>Type d'Enclos</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($enclos as $enclo): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($enclo['LATITUDE']) ?></td>
                                                <td><?= htmlspecialchars($enclo['LONGITUDE']) ?></td>
                                                <td><?= htmlspecialchars($enclo['TYPE_ENCLOS']) ?></td>
                                                <td>
                                                    <a href="index.php?action=profilEnclos&latitude=<?= urlencode($enclo['LATITUDE']) ?>&longitude=<?= urlencode($enclo['LONGITUDE']) ?>" class="btn btn-sm btn-primary" title="Voir le profil de l'enclos">
                                                        Voir le profil
                                                    </a>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> Aucun enclos n'est présent dans cette zone.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Colonne Animaux -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-warning text-dark">
                        <h4><i class="fas fa-paw"></i> Liste des animaux de ma zone (<?= count($animaux) ?>)</h4>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($animaux)): ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Nom de l'animal</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($animaux as $animal): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($animal['NOM_ANIMAL']) ?></td>
                                                <td>
                                                    <a href="index.php?action=profilAnimal&id=<?= htmlspecialchars($animal['ID_ANIMAL']) ?>" class="btn btn-sm btn-primary">
                                                        Voir le profil
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> Aucun animal n'est présent dans cette zone.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>
</div>