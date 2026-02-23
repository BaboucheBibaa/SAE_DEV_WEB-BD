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
                                            <th>Email</th>
                                            <th>Date d'entrée</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($employes as $employe): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($employe['NOM']) ?></td>
                                                <td><?= htmlspecialchars($employe['PRENOM']) ?></td>
                                                <td><?= htmlspecialchars($employe['MAIL'] ?? 'N/A') ?></td>
                                                <td><?= htmlspecialchars($employe['DATE_ENTREE'] ?? 'N/A') ?></td>
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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($enclos as $enclo): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($enclo['LATITUDE']) ?></td>
                                                <td><?= htmlspecialchars($enclo['LONGITUDE']) ?></td>
                                                <td><?= htmlspecialchars($enclo['TYPE_ENCLOS']) ?></td>
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
                                            <th>Date de naissance</th>
                                            <th>Poids</th>
                                            <th>Régime Alimentaire</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($animaux as $animal): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($animal['NOM_ANIMAL']) ?></td>
                                                <td><?= htmlspecialchars($animal['DATE_NAISSANCE']) ?></td>
                                                <td><?= htmlspecialchars($animal['POIDS']) ?></td>
                                                <td><?= htmlspecialchars($animal['REGIME_ALIMENTAIRE']) ?></td>
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