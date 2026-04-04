<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3>Créer un nouvel enclos</h3>
                </div>
                <div class="card-body">
                    <form action="index.php?action=ajoutEnclos" method="POST">
                        <div class="mb-3">
                            <label for="latitude_cree" class="form-label">Latitude <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="latitude_cree" name="latitude_cree" placeholder="Ex: 48.856" step="0.000001" required>
                        </div>

                        <div class="mb-3">
                            <label for="longitude_cree" class="form-label">Longitude <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="longitude_cree" name="longitude_cree" placeholder="Ex: 2.295" step="0.000001" required>
                        </div>

                        <div class="mb-3">
                            <label for="id_zone_cree" class="form-label">Zone <span class="text-danger">*</span></label>
                            <select class="form-select" id="id_zone_cree" name="id_zone_cree" required>
                                <option value="">-- Sélectionner une zone --</option>
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
                            <label for="type_enclos_cree" class="form-label">Type d'enclos <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="type_enclos_cree" name="type_enclos_cree" placeholder="Ex: Savane, Forêt, Aquatique" required>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Créer l'enclos
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
