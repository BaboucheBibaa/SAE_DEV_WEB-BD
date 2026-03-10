<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3><i class="fas fa-edit"></i> Modifier la zone</h3>
                </div>
                <div class="card-body">
                    <form action="index.php?action=majZone&id=<?= htmlspecialchars($zone['ID_ZONE']) ?>" method="POST">
                        <div class="mb-3">
                            <label for="nom_zone_modif" class="form-label">Nom de la zone <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nom_zone_modif" name="nom_zone_modif" value="<?= htmlspecialchars($zone['NOM_ZONE'] ?? '') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="id_manager_modif" class="form-label">Manager (optionnel)</label>
                            <select name="id_manager_modif" id="id_manager_modif" class="form-control">
                                <option value="">-- Aucun manager --</option>
                                <?php
                                if (!empty($employees)) {
                                    foreach ($employees as $employee) {
                                        $selected = (isset($zone['ID_MANAGER']) && $employee['ID_PERSONNEL'] == $zone['ID_MANAGER']) ? 'selected' : '';
                                        echo '<option value="' . htmlspecialchars($employee['ID_PERSONNEL']) . '" ' . $selected . '>';
                                        echo htmlspecialchars($employee['NOM'] . ' ' . $employee['PRENOM']);
                                        echo '</option>';
                                    }
                                }
                                ?>
                            </select>
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
