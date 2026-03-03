<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3><i class="fas fa-edit"></i> Modifier la boutique</h3>
                </div>
                <div class="card-body">
                    <form action="index.php?action=majBoutique&id=<?= htmlspecialchars($boutique['ID_BOUTIQUE']) ?>" method="POST">
                        <div class="mb-3">
                            <label for="nom_boutique_modif" class="form-label">Nom de la boutique <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nom_boutique_modif" name="nom_boutique_modif" value="<?= htmlspecialchars($boutique['NOM_BOUTIQUE'] ?? '') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="description_boutique_modif" class="form-label">Description</label>
                            <textarea class="form-control" id="description_boutique_modif" name="description_boutique_modif" rows="4"><?= htmlspecialchars($boutique['DESCRIPTION_BOUTIQUE'] ?? '') ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="id_zone_modif" class="form-label">Zone <span class="text-danger">*</span></label>
                            <select name="id_zone_modif" id="id_zone_modif" class="form-control" required>
                                <option value="">-- Sélectionner une zone --</option>
                                <?php
                                if (!empty($zones)) {
                                    foreach ($zones as $zone) {
                                        $selected = (isset($boutique['ID_ZONE']) && $zone['ID_ZONE'] == $boutique['ID_ZONE']) ? 'selected' : '';
                                        echo '<option value="' . htmlspecialchars($zone['ID_ZONE']) . '" ' . $selected . '>';
                                        echo htmlspecialchars($zone['NOM_ZONE']);
                                        echo '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="id_manager_modif" class="form-label">Manager (optionnel)</label>
                            <select name="id_manager_modif" id="id_manager_modif" class="form-control">
                                <option value="">-- Aucun manager --</option>
                                <?php
                                if (!empty($employees)) {
                                    foreach ($employees as $employee) {
                                        $selected = (isset($boutique['ID_MANAGER']) && $employee['ID_PERSONNEL'] == $boutique['ID_MANAGER']) ? 'selected' : '';
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
