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

                <!-- Formulaire d'assignation d'employé à une boutique -->
                <form method="POST" action="index.php?action=ajoutTravauxBoutique" class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="id_boutique" class="form-label">Sélectionner une boutique</label>
                            <select class="form-control" id="id_boutique" name="id_boutique" required>
                                <option value="">-- Choisir une boutique --</option>
                                <?php if (!empty($boutiques)): ?>
                                    <?php foreach ($boutiques as $boutique): ?>
                                        <option value="<?= htmlspecialchars($boutique['ID_BOUTIQUE']) ?>">
                                            <?= htmlspecialchars($boutique['NOM_BOUTIQUE']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="id_personnel" class="form-label">Sélectionner un employé boutique</label>
                            <select class="form-control" id="id_personnel" name="id_personnel" required>
                                <option value="">-- Choisir un employé --</option>
                                <?php if (!empty($employees)): ?>
                                    <?php foreach ($employees as $employee): ?>
                                        <option value="<?= htmlspecialchars($employee['ID_PERSONNEL']) ?>">
                                            <?= htmlspecialchars($employee['NOM'] . ' ' . $employee['PRENOM']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-plus"></i> Assigner l'employé à la boutique
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
