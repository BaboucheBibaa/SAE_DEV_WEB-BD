<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3>Modifier l'enclos</h3>
                </div>
                <div class="card-body">
                    <form action="index.php?action=majEnclos&latitude=<?= htmlspecialchars($enclos['LATITUDE'] ?? '') ?>&longitude=<?= htmlspecialchars($enclos['LONGITUDE'] ?? '') ?>" method="POST">
                        <input type="hidden" name="latitude" value="<?= htmlspecialchars($enclos['LATITUDE'] ?? '') ?>">
                        <input type="hidden" name="longitude" value="<?= htmlspecialchars($enclos['LONGITUDE'] ?? '') ?>">

                        <div class="mb-3">
                            <label for="latitude_display" class="form-label">Latitude</label>
                            <input type="text" class="form-control" id="latitude_display" disabled 
                                   value="<?= htmlspecialchars($enclos['LATITUDE'] ?? '') ?>">
                        </div>

                        <div class="mb-3">
                            <label for="longitude_display" class="form-label">Longitude</label>
                            <input type="text" class="form-control" id="longitude_display" disabled 
                                   value="<?= htmlspecialchars($enclos['LONGITUDE'] ?? '') ?>">
                        </div>

                        <div class="mb-3">
                            <label for="id_zone_modif" class="form-label">Zone <span class="text-danger">*</span></label>
                            <select class="form-select" id="id_zone_modif" name="id_zone_modif" required>
                                <option value="">-- Sélectionner une zone --</option>
                                <?php if (!empty($zones)): ?>
                                    <?php foreach ($zones as $zone): ?>
                                        <option value="<?= htmlspecialchars($zone['ID_ZONE']) ?>" 
                                            <?= ($enclos['ID_ZONE'] == $zone['ID_ZONE']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($zone['NOM_ZONE']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="type_enclos_modif" class="form-label">Type d'enclos <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="type_enclos_modif" name="type_enclos_modif" 
                                   value="<?= htmlspecialchars($enclos['TYPE_ENCLOS'] ?? '') ?>" required>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Enregistrer les modifications
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
