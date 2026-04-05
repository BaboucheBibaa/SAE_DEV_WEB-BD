<main class="flex-grow-1">
    <div class="container my-5">
        <!-- Titre et breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php?action=home">Accueil</a></li>
                <li class="breadcrumb-item"><a href="index.php?action=adminDashboard">Dashboard Admin</a></li>
                <li class="breadcrumb-item active"><?= htmlspecialchars($title) ?></li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h1 class="mb-4"><?= htmlspecialchars($title) ?></h1>

                <!-- Formulaire d'affectation de personnel à une zone -->
                <form method="POST" action="index.php?action=ajoutAffectationZone" class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="id_zone" class="form-label">Sélectionner une zone</label>
                            <select class="form-control" id="id_zone" name="id_zone" required>
                                <option value="">-- Choisir une zone --</option>
                                <?php if (!empty($zones)): ?>
                                    <?php foreach ($zones as $zone): ?>
                                        <option value="<?= htmlspecialchars($zone['ID_ZONE']) ?>">
                                            <?= htmlspecialchars($zone['NOM_ZONE']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="id_personnel" class="form-label">Sélectionner un personnel d'entretien</label>
                            <select class="form-control" id="id_personnel" name="id_personnel" required>
                                <option value="">-- Choisir un personnel --</option>
                                <?php if (!empty($personnels)): ?>
                                    <?php foreach ($personnels as $personnel): ?>
                                        <option value="<?= htmlspecialchars($personnel['ID_PERSONNEL']) ?>">
                                            <?= htmlspecialchars($personnel['NOM'] . ' ' . $personnel['PRENOM']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-plus"></i> Affecter le personnel à la zone
                        </button>
                        <a href="index.php?action=adminDashboard" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Retour
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
