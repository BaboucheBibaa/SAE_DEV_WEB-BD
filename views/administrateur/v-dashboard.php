<main class="flex-grow-1">
    <div class="container my-5">
        <!-- Titre et breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php?action=home">Accueil</a></li>
                <li class="breadcrumb-item active">Dashboard Administrateur</li>
            </ol>
        </nav>

        <!-- En-tête du dashboard -->
        <div class="row mb-5">
            <div class="col-lg-8">
                <h1 class="display-4 mb-3 text-primary">
                    Tableau de bord Administrateur
                </h1>
                <p class="lead text-muted">Bienvenue dans l'interface d'administration du Zoo</p>
                <p class="text-secondary">Vous pouvez gérer tous les employés et consulter les informations des zones.</p>
            </div>
        </div>

        <!-- Accordéon des sections -->
        <div class="accordion" id="accordionAdmin">
            <!-- Liste des Employés -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEmployes">
                        <i class="bi bi-people-fill me-2"></i> Liste des Employés (<?= count($employees) ?>)
                    </button>
                </h2>
                <div id="collapseEmployes" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        <?php $filtreArchive = $filtreArchive ?? 'tous'; ?>
                        <div class="mb-3 d-flex flex-wrap gap-2 align-items-center">
                            <a href="index.php?action=creationEmployee" class="btn btn-success">
                                <i class="bi bi-person-plus"></i> Ajouter un Employé
                            </a>
                            <div class="btn-group" role="group" aria-label="Filtre archivage employés">
                                <a href="index.php?action=adminDashboard&filtreArchive=tous" class="btn btn-outline-secondary <?= $filtreArchive === 'tous' ? 'active' : '' ?>">Tous</a>
                                <a href="index.php?action=adminDashboard&filtreArchive=actifs" class="btn btn-outline-secondary <?= $filtreArchive === 'actifs' ? 'active' : '' ?>">Non archivés</a>
                                <a href="index.php?action=adminDashboard&filtreArchive=archives" class="btn btn-outline-secondary <?= $filtreArchive === 'archives' ? 'active' : '' ?>">Archivés</a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nom</th>
                                        <th>Prénom</th>
                                        <th>Login</th>
                                        <th>Salaire</th>
                                        <th>Statut</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($employees)): ?>
                                        <?php foreach ($employees as $employee): ?>
                                            <?php $estArchive = (int) ($employee['ESTARCHIVE'] ?? 1); ?>
                                            <tr>
                                                <td><?= htmlspecialchars($employee['ID_PERSONNEL'] ?? '') ?></td>
                                                <td><strong><?= htmlspecialchars($employee['NOM'] ?? '') ?></strong></td>
                                                <td><?= htmlspecialchars($employee['PRENOM'] ?? '') ?></td>
                                                <td><?= htmlspecialchars($employee['LOGIN'] ?? 'N/A') ?></td>
                                                <td><span class="badge bg-success"><?= htmlspecialchars(number_format($employee['SALAIRE'] ?? 0, 2)) ?> €</span></td>
                                                <td>
                                                    <?php if ($estArchive === 1): ?>
                                                        <span class="badge bg-primary">Actif</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-secondary">Archivé</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <a href="index.php?action=profil&id=<?= $employee['ID_PERSONNEL'] ?>" class="btn btn-outline-info" title="Voir le profil">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                        <a href="index.php?action=editionEmployee&id=<?= $employee['ID_PERSONNEL'] ?>" class="btn btn-outline-warning" title="Modifier">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        <?php if ($estArchive === 1): ?>
                                                            <a href="index.php?action=archiverEmployee&id=<?= $employee['ID_PERSONNEL'] ?>&valeur=0&filtreArchive=<?= urlencode($filtreArchive) ?>" class="btn btn-outline-secondary" onclick="return confirm('Archiver cet employé ?')" title="Archiver">
                                                                <i class="bi bi-archive"></i>
                                                            </a>
                                                        <?php else: ?>
                                                            <a href="index.php?action=archiverEmployee&id=<?= $employee['ID_PERSONNEL'] ?>&valeur=1&filtreArchive=<?= urlencode($filtreArchive) ?>" class="btn btn-outline-success" title="Désarchiver">
                                                                <i class="bi bi-arrow-counterclockwise"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                        <a href="index.php?action=supprEmployee&id=<?= $employee['ID_PERSONNEL'] ?>" class="btn btn-outline-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet employé ?')" title="Supprimer">
                                                            <i class="bi bi-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">Aucun employé trouvé</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Liste des Espèces -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEspeces">
                        <i class="bi bi-paw me-2"></i> Liste des Espèces (<?= count($especes) ?>)
                    </button>
                </h2>
                <div id="collapseEspeces" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <div class="mb-3">
                            <a href="index.php?action=formCreationEspece" class="btn btn-success">
                                <i class="bi bi-plus-circle"></i> Ajouter une Espèce
                            </a>
                            <a href="index.php?action=formCreationCompatibilite" class="btn btn-success">
                                <i class="bi bi-plus-circle"></i> Ajouter une Compatibilité entre Espèces
                            </a>

                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nom de l'espèce</th>
                                        <th>Nom latin de l'espèce</th>
                                        <th>Est-elle menacée ?</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($especes)): ?>
                                        <?php foreach ($especes as $espece): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($espece['ID_ESPECE'] ?? '') ?></td>
                                                <td><strong><?= htmlspecialchars($espece['NOM_ESPECE'] ?? '') ?></strong></td>
                                                <td><?= htmlspecialchars($espece['NOM_LATIN_ESPECE'] ?? '') ?></td>
                                                <td><?= htmlspecialchars($espece['EST_MENACEE']) == 1 ? "Oui" : "Non" ?></td>

                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <a href="index.php?action=profilEspece&id=<?= $espece['ID_ESPECE'] ?>" class="btn btn-outline-info" title="Voir le profil">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                        <a href="index.php?action=formEditionEspece&id=<?= $espece['ID_ESPECE'] ?>" class="btn btn-outline-warning" title="Modifier">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        <a href="index.php?action=supprimerEspece&id=<?= $espece['ID_ESPECE'] ?>" class="btn btn-outline-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette espèce ?')" title="Supprimer">
                                                            <i class="bi bi-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">Aucune espèce trouvée</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Liste des Animaux -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAnimaux">
                        <i class="bi bi-paw me-2"></i> Liste des Animaux (<?= count($animals) ?>)
                    </button>
                </h2>
                <div id="collapseAnimaux" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <div class="mb-3">
                            <a href="index.php?action=creationAnimal" class="btn btn-success">
                                <i class="bi bi-plus-circle"></i> Ajouter un Animal
                            </a>
                            <a href="index.php?action=creationParente" class="btn btn-success">
                                <i class="bi bi-link-45deg"></i> Ajouter un lien de parenté
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nom</th>
                                        <th>Espèce</th>
                                        <th>Enclos</th>
                                        <th>Zone</th>

                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($animals)): ?>
                                        <?php foreach ($animals as $animal): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($animal['ID_ANIMAL'] ?? '') ?></td>
                                                <td><strong><?= htmlspecialchars($animal['NOM_ANIMAL'] ?? '') ?></strong></td>
                                                <td><strong><?= htmlspecialchars($animal['NOM_ESPECE']) ?></strong></td>
                                                <td>
                                                    <?php if (!empty($animal['LATITUDE_ENCLOS']) && !empty($animal['LONGITUDE_ENCLOS'])): ?>
                                                        <span class="badge bg-info"><?= htmlspecialchars($animal['LATITUDE_ENCLOS']) ?>, <?= htmlspecialchars($animal['LONGITUDE_ENCLOS']) ?></span>
                                                    <?php else: ?>
                                                        <span class="badge bg-secondary">Non assigné</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= htmlspecialchars($animal['NOM_ZONE']) ?></td>
                                                <td class="text-center">
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <a href="index.php?action=profilAnimal&id=<?= $animal['ID_ANIMAL'] ?>" class="btn btn-outline-info" title="Voir le profil">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                        <a href="index.php?action=editionAnimal&id=<?= $animal['ID_ANIMAL'] ?>" class="btn btn-outline-warning" title="Modifier">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        <a href="index.php?action=supprAnimal&id=<?= $animal['ID_ANIMAL'] ?>" class="btn btn-outline-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet animal ?')" title="Supprimer">
                                                            <i class="bi bi-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">Aucun animal trouvé</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Liste des Zones -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseZones">
                        <i class="bi bi-map me-2"></i> Liste des Zones (<?= count($zones) ?>)
                    </button>
                </h2>
                <div id="collapseZones" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <div class="mb-3">
                            <a href="index.php?action=creationZone" class="btn btn-success">
                                <i class="bi bi-plus-circle"></i> Créer une Zone
                            </a>
                            <a href="index.php?action=creationAffectationZone" class="btn btn-info ms-2">
                                <i class="bi bi-link-45deg"></i> Affecter du Personnel
                            </a>
                        </div>
                        <?php if (!empty($zones)): ?>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Nom de la Zone</th>
                                            <th>Manager</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($zones as $zone): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($zone['ID_ZONE'] ?? 'N/A') ?></td>
                                                <td><strong><?= htmlspecialchars($zone['NOM_ZONE'] ?? 'N/A') ?></strong></td>
                                                <td>
                                                    <?php if (!empty($zone['NOM'])): ?>
                                                        <span class="badge bg-warning text-dark"><?= htmlspecialchars($zone['NOM']) . ' ' . htmlspecialchars($zone['PRENOM']) ?></span>
                                                    <?php else: ?>
                                                        <span class="badge bg-secondary">Non assigné</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <a href="index.php?action=profilZone&id=<?= $zone['ID_ZONE'] ?>" class="btn btn-outline-info" title="Profil">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                        <a href="index.php?action=editionZone&id=<?= $zone['ID_ZONE'] ?>" class="btn btn-outline-warning" title="Modifier">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>

                                                        <a href="index.php?action=supprZone&id=<?= $zone['ID_ZONE'] ?>" class="btn btn-outline-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette zone ?')" title="Supprimer">
                                                            <i class="bi bi-trash"></i>
                                                        </a>

                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning mb-0" role="alert">
                                <i class="bi bi-exclamation-triangle"></i> Aucune zone disponible.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Liste des Enclos -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEnclos">
                        <i class="bi bi-house me-2"></i> Liste des Enclos (<?= count($enclos ?? []) ?>)
                    </button>
                </h2>
                <div id="collapseEnclos" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <div class="mb-3">
                            <a href="index.php?action=creationEnclos" class="btn btn-success">
                                <i class="bi bi-plus-circle"></i> Ajouter un Enclos
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Latitude</th>
                                        <th>Longitude</th>
                                        <th>Zone</th>
                                        <th>Type d'Enclos</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($enclos)): ?>
                                        <?php foreach ($enclos as $e): ?>
                                            <tr>
                                                <td><strong><?= htmlspecialchars($e['LATITUDE'] ?? '') ?></strong></td>
                                                <td><strong><?= htmlspecialchars($e['LONGITUDE'] ?? '') ?></strong></td>
                                                <td>
                                                    <?php if (!empty($e['NOM_ZONE'])): ?>
                                                        <span class="badge bg-success"><?= htmlspecialchars($e['NOM_ZONE']) ?></span>
                                                    <?php else: ?>
                                                        <span class="badge bg-secondary">Non assignée</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= htmlspecialchars($e['TYPE_ENCLOS'] ?? '-') ?></td>
                                                <td class="text-center">
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <a href="index.php?action=profilEnclos&latitude=<?= $e['LATITUDE'] ?>&longitude=<?= $e['LONGITUDE'] ?>" class="btn btn-outline-info" title="Voir le profil">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                        <a href="index.php?action=editionEnclos&latitude=<?= $e['LATITUDE'] ?>&longitude=<?= $e['LONGITUDE'] ?>" class="btn btn-outline-warning" title="Modifier">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        <a href="index.php?action=supprEnclos&latitude=<?= $e['LATITUDE'] ?>&longitude=<?= $e['LONGITUDE'] ?>" class="btn btn-outline-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet enclos ?')" title="Supprimer">
                                                            <i class="bi bi-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">Aucun enclos trouvé</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Liste des Prestataires -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePrestataires">
                        <i class="bi bi-briefcase me-2"></i> Liste des Prestataires (<?= count($prestataires ?? []) ?>)
                    </button>
                </h2>
                <div id="collapsePrestataires" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <div class="mb-3">
                            <a href="index.php?action=creationPrestataire" class="btn btn-success">
                                <i class="bi bi-plus-circle"></i> Ajouter un Prestataire
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nom</th>
                                        <th>Prénom</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($prestataires)): ?>
                                        <?php foreach ($prestataires as $prestataire): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($prestataire['ID_PRESTATAIRE'] ?? '') ?></td>
                                                <td><strong><?= htmlspecialchars($prestataire['NOM_PRESTATAIRE'] ?? '') ?></strong></td>
                                                <td><?= htmlspecialchars($prestataire['PRENOM_PRESTATAIRE'] ?? '') ?></td>
                                                <td class="text-center">
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <a href="index.php?action=profilPrestataire&id=<?= $prestataire['ID_PRESTATAIRE'] ?>" class="btn btn-outline-info" title="Voir le profil">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                        <a href="index.php?action=editionPrestataire&id=<?= $prestataire['ID_PRESTATAIRE'] ?>" class="btn btn-outline-warning" title="Modifier">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        <a href="index.php?action=supprPrestataire&id=<?= $prestataire['ID_PRESTATAIRE'] ?>" class="btn btn-outline-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce prestataire ?')" title="Supprimer">
                                                            <i class="bi bi-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">Aucun prestataire trouvé</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Liste des Contrats de Travail -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseContrats">
                        <i class="bi bi-file-earmark-text me-2"></i> Historique des Contrats de Travail (<?= count($contrats ?? []) ?>)
                    </button>
                </h2>
                <div id="collapseContrats" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID Contrat</th>
                                        <th>Employé</th>
                                        <th>Fonction</th>
                                        <th>Date Début</th>
                                        <th>Date Fin</th>
                                        <th class="text-center">Statut</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($contrats)): ?>
                                        <?php foreach ($contrats as $contrat): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($contrat['ID_CONTRAT'] ?? '') ?></td>
                                                <td>
                                                    <strong><?= htmlspecialchars(($contrat['NOM'] ?? '') . ' ' . ($contrat['PRENOM'] ?? '')) ?></strong>
                                                </td>
                                                <td><?= htmlspecialchars($contrat['NOM_FONCTION'] ?? '-') ?></td>
                                                <td>
                                                    <?php
                                                    $dateDebut = $contrat['DATE_DEBUT'] ?? null;
                                                    echo $dateDebut;
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $dateFin = $contrat['DATE_FIN'] ?? null;
                                                    echo $dateFin;
                                                    ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php
                                                    $dateFin = $contrat['DATE_FIN'] ?? null;
                                                    $timestamp = strtotime($dateFin);
                                                    if ($timestamp && $timestamp < time()) {
                                                        echo '<span class="badge bg-secondary">Terminé</span>';
                                                    } else {
                                                        echo '<span class="badge bg-info">Actif</span>';
                                                    }
                                                    ?>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <a href="index.php?action=supprContrat&id=<?= $contrat['ID_CONTRAT'] ?>" class="btn btn-outline-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce contrat ?')" title="Supprimer">
                                                            <i class="bi bi-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">Aucun contrat trouvé</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Liste des Boutiques -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBoutiques">
                        <i class="bi bi-shop me-2"></i> Liste des Boutiques (<?= count($boutiques) ?>)
                    </button>
                </h2>
                <div id="collapseBoutiques" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <div class="mb-3">
                            <a href="index.php?action=creationBoutique" class="btn btn-success">
                                <i class="bi bi-plus-circle"></i> Créer une Boutique
                            </a>
                            <a href="index.php?action=creationTravauxBoutique" class="btn btn-info ms-2">
                                <i class="bi bi-link-45deg"></i> Assigner des Employés
                            </a>
                        </div>
                        <?php if (!empty($boutiques)): ?>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Nom</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($boutiques as $boutique): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($boutique['ID_BOUTIQUE'] ?? 'N/A') ?></td>
                                                <td><strong><?= htmlspecialchars($boutique['NOM_BOUTIQUE'] ?? 'N/A') ?></strong></td>
                                                <td class="text-center">
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <a href="index.php?action=profilBoutique&id=<?= $boutique['ID_BOUTIQUE'] ?>" class="btn btn-outline-info btn-sm" title="Profil">
                                                            <i class="bi bi-eye"></i>
                                                        </a>

                                                        <a href="index.php?action=editionBoutique&id=<?= $boutique['ID_BOUTIQUE'] ?>" class="btn btn-outline-warning" title="Modifier">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        <a href="index.php?action=supprBoutique&id=<?= $boutique['ID_BOUTIQUE'] ?>" class="btn btn-outline-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette boutique ?')" title="Supprimer">
                                                            <i class="bi bi-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning mb-0" role="alert">
                                <i class="bi bi-exclamation-triangle"></i> Aucune boutique disponible.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="row g-3 mt-4">
            <div class="col-auto">
                <a href="index.php?action=home" class="btn btn-outline-secondary">
                    <i class="bi bi-house"></i> Accueil
                </a>
            </div>
            <div class="col-auto">
                <a href="index.php?action=profil" class="btn btn-outline-primary">
                    <i class="bi bi-person"></i> Mon profil
                </a>
            </div>
        </div>
    </div>
</main>