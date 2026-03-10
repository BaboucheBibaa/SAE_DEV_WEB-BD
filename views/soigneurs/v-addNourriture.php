<main class="flex-grow-1">
    <div class="container py-5">
        <!-- Header -->
        <div class="text-center mb-5">
            <h1 class="h2 fw-bold mb-2">Ajouter une dose de nourriture quotidienne</h1>
            <p class="text-muted">Enregistrez la nourriture donnée à un animal de votre zone</p>
        </div>

        <!-- Form Section -->
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form method="POST" action="index.php?action=addNourriture" novalidate>
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
                                    <i class="bi bi-info-circle"></i> Sélectionnez l'animal à nourrir
                                </small>
                            </div>

                            <!-- Date Selection -->
                            <div class="mb-3">
                                <label for="dateNourrit" class="form-label fw-bold">
                                    <i class="bi bi-calendar-event"></i> Date *
                                </label>
                                <input
                                    type="date"
                                    class="form-control form-control-lg"
                                    id="dateNourrit"
                                    name="DATE_NOURRIT"
                                    required
                                    value="<?= date('Y-m-d') ?>"
                                    max="<?= date('Y-m-d') ?>"
                                    aria-label="Date de nourriture">
                                <small class="form-text text-muted d-block mt-1">
                                    <i class="bi bi-info-circle"></i> La date à laquelle la nourriture a été donnée
                                </small>
                            </div>

                            <!-- Dose de nourriture -->
                            <div class="mb-4">
                                <label for="doseNourriture" class="form-label fw-bold">
                                    <i class="bi bi-cup-straw"></i> Dose de nourriture (kg) *
                                </label>
                                <input
                                    type="number"
                                    class="form-control form-control-lg"
                                    id="doseNourriture"
                                    name="DOSE_NOURRITURE"
                                    required
                                    min="0.01"
                                    max="9999.99"
                                    step="0.01"
                                    placeholder="Ex : 2.50"
                                    aria-label="Dose de nourriture en kg"
                                    aria-describedby="doseHelp">
                                <small id="doseHelp" class="form-text text-muted d-block mt-1">
                                    <i class="bi bi-info-circle"></i> Quantité en kilogrammes (max 9999.99 kg)
                                </small>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-lg btn-success flex-grow-1">
                                    <i class="bi bi-check-circle"></i> Enregistrer la dose
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
