<main class="flex-grow-1">
    <div class="container py-5">
        <!-- Header -->
        <div class="text-center mb-5">
            <h1 class="h2 fw-bold mb-2">Ajouter un Soin pour un animal de votre zone</h1>
            <p class="text-muted">Enregistrez un soin pour un animal</p>
        </div>

        <!-- Form Section -->
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form method="POST" action="index.php?action=ajoutSoin" novalidate>
                            <!-- Animal Selection -->
                            <div class="mb-3">
                                <label for="animalSelect" class="form-label fw-bold">
                                    <i class="bi bi-paw"></i> Animal *
                                </label>
                                <select
                                    class="form-select form-select-lg"
                                    id="animalSelect"
                                    name="ID_ANIMAL"
                                    required
                                    aria-label="Sélectionner un animal">
                                    <option value="">-- Sélectionner un animal --</option>
                                    <?php if (isset($animaux) && is_array($animaux)): ?>
                                        <?php foreach ($animaux as $animal): ?>
                                            <option value="<?= htmlspecialchars($animal['ID_ANIMAL'] ?? '') ?>">
                                                <?= htmlspecialchars($animal['NOM_ANIMAL'] ?? 'Animal sans nom') ?>
                                                (<?= htmlspecialchars($animal['NOM_ESPECE'] ?? 'Espèce inconnue') ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <small class="form-text text-muted d-block mt-1">
                                    <i class="bi bi-info-circle"></i> Sélectionnez l'animal auquel appliquer le soin
                                </small>
                            </div>

                            <!-- Date Selection -->
                            <div class="mb-3">
                                <label for="dateSoin" class="form-label fw-bold">
                                    <i class="bi bi-calendar-event"></i> Date du Soin *
                                </label>
                                <input
                                    type="date"
                                    class="form-control form-control-lg"
                                    id="dateSoin"
                                    name="DATE_SOIN"
                                    required
                                    value="<?= date('Y-m-d') ?>"
                                    max="<?= date('Y-m-d') ?>"
                                    aria-label="Date du soin">
                                <small class="form-text text-muted d-block mt-1">
                                    <i class="bi bi-info-circle"></i> La date de la date d'ajout du soin
                                </small>
                            </div>

                            <!-- Description -->
                            <div class="mb-4">
                                <label for="descriptionSoin" class="form-label fw-bold">
                                    <i class="bi bi-file-text"></i> Description du Soin *
                                </label>
                                <textarea
                                    class="form-control form-control-lg"
                                    id="descriptionSoin"
                                    name="DESCRIPTION_SOIN"
                                    rows="4"
                                    required
                                    placeholder="Décrivez le soin apporté à l'animal..."
                                    maxlength="200"
                                    aria-label="Description du soin"
                                    aria-describedby="descriptionHelp"></textarea>
                                <small id="descriptionHelp" class="form-text text-muted d-block mt-1">
                                    <i class="bi bi-info-circle"></i> Maximum 200 caractères
                                </small>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-lg btn-success flex-grow-1">
                                    <i class="bi bi-check-circle"></i> Ajouter le Soin
                                </button>
                                <a href="index.php?action=soigneursDashboard" class="btn btn-lg btn-secondary">
                                    <i class="bi bi-x-circle"></i> Annuler
                                </a>
                            </div>

                            <!-- Legend -->
                            <div class="alert alert-light border-start border-primary mt-4 mb-0">
                                <small class="text-muted">
                                    <strong>*</strong> Champ obligatoire
                                </small>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>