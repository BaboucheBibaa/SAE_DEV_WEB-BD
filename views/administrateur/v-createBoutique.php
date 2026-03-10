<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h3><i class="fas fa-store"></i> Créer une nouvelle boutique</h3>
                </div>
                <div class="card-body">
                    <form action="index.php?action=ajoutBoutique" method="POST">
                        <div class="mb-3">
                            <label for="nom_boutique_cree" class="form-label">Nom de la boutique <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nom_boutique_cree" name="nom_boutique_cree" required>
                        </div>

                        <div class="mb-3">
                            <label for="description_boutique_cree" class="form-label">Description</label>
                            <textarea class="form-control" id="description_boutique_cree" name="description_boutique_cree" rows="4" placeholder="Description de la boutique..."></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="id_zone_cree" class="form-label">Zone <span class="text-danger">*</span></label>
                            <select name="id_zone_cree" id="id_zone_cree" class="form-control" required>
                                <option value="">-- Sélectionner une zone --</option>
                                <?php
                                if (!empty($zones)) {
                                    foreach ($zones as $zone) {
                                        echo '<option value="' . htmlspecialchars($zone['ID_ZONE']) . '">';
                                        echo htmlspecialchars($zone['NOM_ZONE']);
                                        echo '</option>';
                                    }
                                }
                                ?>
                            </select>
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
                                <i class="fas fa-save"></i> Créer la boutique
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
