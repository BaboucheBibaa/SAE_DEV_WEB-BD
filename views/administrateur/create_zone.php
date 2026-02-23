<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h3><i class="fas fa-map-marked-alt"></i> Créer une nouvelle zone</h3>
                </div>
                <div class="card-body">
                    <form action="index.php?action=ajoutZone" method="POST">
                        <div class="mb-3">
                            <label for="nom_zone_cree" class="form-label">Nom de la zone <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nom_zone_cree" name="nom_zone_cree" required placeholder="Ex: Zone des Carnivores">
                        </div>

                        <div class="mb-3">
                            <label for="id_manager_cree" class="form-label">Manager (optionnel)</label>
                            <select name="id_manager_cree" id="id_manager_cree" class="form-control">
                                <option value="">-- Aucun manager --</option>
                                <?php
                                if (!empty($employees)) {
                                    foreach ($employees as $employee) {
                                        echo '<option value="' . htmlspecialchars($employee['ID_PERSONNEL']) . '">';
                                        echo htmlspecialchars($employee['NOM'] . ' ' . $employee['PRENOM']);
                                        echo '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Créer la zone
                            </button>
                            <a href="index.php?action=admin_dashboard" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
