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

        <!-- Informations de la boutique -->
        <div class="row g-4 mb-5">
            <div class="col-lg-12">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-shop"></i> Informations de la boutique
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if ($boutique): ?>
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <strong>Nom:</strong>
                                </div>
                                <div class="col-sm-8">
                                    <?= htmlspecialchars($boutique['NOM_BOUTIQUE'] ?? 'Non spécifié') ?>
                                </div>
                            </div>

                            <hr>

                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <strong>ID Boutique:</strong>
                                </div>
                                <div class="col-sm-8">
                                    <span class="badge bg-primary">
                                        <?= htmlspecialchars($boutique['ID_BOUTIQUE'] ?? '') ?>
                                    </span>
                                </div>
                            </div>

                            <hr>

                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <strong>Zone:</strong>
                                </div>
                                <div class="col-sm-8">
                                    <span class="badge bg-warning text-dark">
                                        <?= htmlspecialchars($boutique['ID_ZONE'] ?? 'Non spécifiée') ?>
                                    </span>
                                </div>
                            </div>

                            <hr>

                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <strong>Description:</strong>
                                </div>
                                <div class="col-sm-8">
                                    <?php
                                    $description = htmlspecialchars($boutique['DESCRIPTION_BOUTIQUE'] ?? '');
                                    echo !empty($description) ? $description : '<span class="text-muted">Non spécifiée</span>';
                                    ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning" role="alert">
                                <i class="bi bi-exclamation-triangle"></i> Aucune boutique assignée.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Équipe de la boutique -->
        <div class="row g-4">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-people-fill"></i> Équipe de la boutique
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($employes)): ?>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nom</th>
                                            <th>Prénom</th>
                                            <th>ID Personnel</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (is_array($employes)) {
                                            // Vérifier si c'est un tableau de tableaux (format par lignes)
                                            foreach ($employes as $employe) {
                                                if (is_array($employe)) {
                                                    $nom = htmlspecialchars($employe['NOM'] ?? '');
                                                    $prenom = htmlspecialchars($employe['PRENOM'] ?? '');
                                                    $id_personnel = htmlspecialchars($employe['ID_PERSONNEL'] ?? '');

                                                    echo "<tr>";
                                                    echo "<td><strong>{$nom}</strong></td>";
                                                    echo "<td>{$prenom}</td>";
                                                    echo "<td><span class='badge bg-secondary'>{$id_personnel}</span></td>";
                                                    echo "<td>";
                                                    echo "<a href='index.php?action=profil&id={$id_personnel}' class='btn btn-sm btn-outline-primary' title='Voir le profil'>";
                                                    echo "<i class='bi bi-eye'></i>";
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
                            <div class="alert alert-warning" role="alert">
                                <i class="bi bi-exclamation-triangle"></i> Aucun employé trouvé dans cette boutique.
                            </div>
                        <?php endif; ?>
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
