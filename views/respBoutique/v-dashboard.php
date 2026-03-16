<main class="flex-grow-1">
    <div class="container my-5">
        <!-- Titre et breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php?action=home">Accueil</a></li>
                <li class="breadcrumb-item active">Dashboard Responsable de Boutique</li>
            </ol>
        </nav>

        <!-- En-tête du dashboard -->
        <div class="row mb-5">
            <div class="col-lg-8">
                <h1 class="display-4 mb-3 text-primary">
                    Dashboard Responsable de Boutique
                </h1>
                <p class="lead text-muted">Bienvenue, <?= htmlspecialchars($user['PRENOM'] ?? '') ?> <?= htmlspecialchars($user['NOM'] ?? '') ?></p>
            </div>
        </div>

        <!-- Accordéon des sections -->
        <div class="accordion mb-5" id="accordionDashboard">
            <!-- Informations de la boutique -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBoutique">
                        <i class="bi bi-shop me-2"></i> Informations de la boutique
                    </button>
                </h2>
                <div id="collapseBoutique" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        <?php if ($boutique): ?>
                            <div class="row mb-3">
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <strong style="min-width: 120px;">Nom:</strong>
                                        <span class="ms-2"><?= htmlspecialchars($boutique['NOM_BOUTIQUE'] ?? 'Non spécifié') ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <strong style="min-width: 120px;">Zone:</strong>
                                        <span class="ms-2">
                                            <span class="badge bg-warning text-dark">
                                                <?= htmlspecialchars($boutique['NOM_ZONE'] ?? 'Non spécifiée') ?>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <div>
                                        <strong>Description:</strong>
                                        <p class="ms-0 mt-2">
                                            <?php
                                            $description = htmlspecialchars($boutique['DESCRIPTION_BOUTIQUE'] ?? '');
                                            echo !empty($description) ? $description : '<span class="text-muted">Non spécifiée</span>';
                                            ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning mb-0" role="alert">
                                <i class="bi bi-exclamation-triangle"></i> Aucune boutique assignée.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Équipe de la boutique -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEquipe">
                        <i class="bi bi-people-fill me-2"></i> Équipe de la boutique
                    </button>
                </h2>
                <div id="collapseEquipe" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <?php if (!empty($employes)): ?>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nom</th>
                                            <th>Prénom</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (is_array($employes)) {
                                            foreach ($employes as $employe) {
                                                if (is_array($employe)) {
                                                    $nom = htmlspecialchars($employe['NOM'] ?? '');
                                                    $prenom = htmlspecialchars($employe['PRENOM'] ?? '');
                                                    $id_personnel = htmlspecialchars($employe['ID_PERSONNEL'] ?? '');
                                                    echo "<tr>";
                                                    echo "<td><strong>{$nom}</strong></td>";
                                                    echo "<td>{$prenom}</td>";
                                                    echo "<td class='text-center'>";
                                                    echo "<a href='index.php?action=profil&id={$id_personnel}' class='btn btn-sm btn-outline-primary' title='Voir le profil'>";
                                                    echo "<i class='bi bi-eye'></i> Profil";
                                                    echo "</a>";
                                                    echo "</td>";
                                                    echo "</tr>";
                                                }
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning mb-0" role="alert">
                                <i class="bi bi-exclamation-triangle"></i> Aucun employé trouvé dans cette boutique.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseStats">
                        <i class="bi bi-graph-up-arrow me-2"></i> Statistiques de la boutique
                    </button>
                </h2>
                <div id="collapseStats" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <p class="text-muted mb-3">Consultez une vue dédiée pour explorer les statistiques de performance de votre boutique.</p>
                        <a href="index.php?action=statsBoutique" class="btn btn-primary">
                            <i class="bi bi-bar-chart-line me-1"></i> Voir les statistiques de la boutique
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <!-- Actions -->
        <div class="row g-3 mt-4">
            <div class="col-auto">
                <a href="index.php?action=profil" class="btn btn-outline-primary">
                    <i class="bi bi-person"></i> Mon profil
                </a>
            </div>
            <div class="col-auto">
                <a href="index.php?action=home" class="btn btn-outline-secondary">
                    <i class="bi bi-house"></i> Accueil
                </a>
            </div>
        </div>
    </div>
</main>