<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Ajouter un lien de parenté</h3>
                </div>
                <div class="card-body">
                    <form action="index.php?action=ajouterParente" method="POST">
                        <div class="mb-3">
                            <label for="id_parent" class="form-label">Animal Parent <span class="text-danger">*</span></label>
                            <select name="id_parent" id="id_parent" class="form-control" required>
                                <option value="">-- Sélectionner le parent --</option>
                                <?php if (!empty($animals)): ?>
                                    <?php foreach ($animals as $animal): ?>
                                        <option value="<?= htmlspecialchars($animal['ID_ANIMAL']) ?>">
                                            <?= htmlspecialchars($animal['NOM_ANIMAL']) ?> 
                                            (ID: <?= htmlspecialchars($animal['ID_ANIMAL']) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <small class="text-muted">L'animal qui sera désigné comme parent</small>
                        </div>

                        <div class="mb-3">
                            <label for="id_enfant" class="form-label">Animal Enfant <span class="text-danger">*</span></label>
                            <select name="id_enfant" id="id_enfant" class="form-control" required>
                                <option value="">-- Sélectionner l'enfant --</option>
                                <?php if (!empty($animals)): ?>
                                    <?php foreach ($animals as $animal): ?>
                                        <option value="<?= htmlspecialchars($animal['ID_ANIMAL']) ?>">
                                            <?= htmlspecialchars($animal['NOM_ANIMAL']) ?> 
                                            (ID: <?= htmlspecialchars($animal['ID_ANIMAL']) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <small class="text-muted">L'animal qui sera désigné comme enfant</small>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Créer le lien
                            </button>
                            <a href="index.php?action=adminDashboard" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>