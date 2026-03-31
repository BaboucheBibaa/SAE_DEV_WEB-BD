<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h3><i class="fas fa-paw"></i> Créer un nouvel animal</h3>
                </div>
                <div class="card-body">
                    <form action="index.php?action=ajoutAnimal" method="POST">
                        <div class="mb-3">
                            <label for="nom_animal_cree" class="form-label">Nom de l'animal <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nom_animal_cree" name="nom_animal_cree" value="<?= htmlspecialchars($formData['nom_animal']) ?>" required placeholder="Ex: Simba">
                        </div>

                        <div class="mb-3">
                            <label for="id_espece_cree" class="form-label">Espèce <span class="text-danger">*</span></label>
                            <select name="id_espece_cree" id="id_espece_cree" class="form-control" required>
                                <option value="">-- Sélectionner une espèce --</option>
                                <?php
                                if (!empty($especes)) {
                                    foreach ($especes as $espece) {
                                        $selected = ($formData['id_espece'] == $espece['ID_ESPECE']) ? 'selected' : '';
                                        echo '<option value="' . htmlspecialchars($espece['ID_ESPECE']) . '" ' . $selected . '>';
                                        if (!empty($espece['NOM_LATIN_ESPECE'])) {
                                            echo ' (' . htmlspecialchars($espece['NOM_LATIN_ESPECE']) . ')';
                                        }
                                        echo '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="id_soigneur" class="form-label">Soigneur attitré <span class="text-danger">*</span></label>
                            <select name="id_soigneur" id="id_soigneur" class="form-control" required>
                                <option value="">-- Sélectionnez son soigneur attitré --</option>
                                <?php
                                if (!empty($soigneurs)) {
                                    foreach ($soigneurs as $soigneur) {
                                        $selected = ($formData['id_espece'] == $soigneur['NOM']) ? 'selected' : '';
                                        echo '<option value="' . htmlspecialchars($soigneur['ID_PERSONNEL']) . '" ' . $selected . '>';
                                        if (!empty($espece['NOM_LATIN_ESPECE'])) {
                                            echo ' (' . htmlspecialchars($soigneur['NOM']) . ')';
                                        }
                                        echo '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>


                        <div class="mb-3">
                            <label for="date_naissance_cree" class="form-label">Date de naissance <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="date_naissance_cree" name="date_naissance_cree" value="<?= htmlspecialchars($formData['date_naissance']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="poids_cree" class="form-label">Poids (kg) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control" id="poids_cree" name="poids_cree" value="<?= htmlspecialchars($formData['poids']) ?>" required placeholder="Ex: 180.50">
                        </div>

                        <div class="mb-3">
                            <label for="regime_alimentaire_cree" class="form-label">Régime alimentaire <span class="text-danger">*</span></label>
                            <select name="regime_alimentaire_cree" id="regime_alimentaire_cree" class="form-control" required>
                                <option value="">-- Sélectionner un régime --</option>
                                <?php
                                $regimes = ['Carnivore', 'Herbivore', 'Omnivore', 'Insectivore', 'Frugivore'];
                                foreach ($regimes as $regime) {
                                    $selected = ($formData['regime_alimentaire'] == $regime) ? 'selected' : '';
                                    echo '<option value="' . htmlspecialchars($regime) . '" ' . $selected . '>' . htmlspecialchars($regime) . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="id_zone_cree" class="form-label">Zone <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <select name="id_zone_cree" id="id_zone_cree" class="form-control" required>
                                    <option value="">-- Sélectionner une zone --</option>
                                    <?php
                                    if (!empty($zones)) {
                                        foreach ($zones as $zone) {
                                            $selected = ($formData['id_zone'] == $zone['ID_ZONE']) ? 'selected' : '';
                                            echo '<option value="' . htmlspecialchars($zone['ID_ZONE']) . '" ' . $selected . '>';
                                            echo htmlspecialchars($zone['NOM_ZONE']);
                                            echo '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                                <button type="submit" formaction="index.php?action=creationAnimal" class="btn btn-outline-secondary">
                                    <i class="fas fa-sync-alt"></i> Charger les enclos
                                </button>
                            </div>
                            <small class="text-muted">Sélectionnez une zone puis cliquez sur "Charger les enclos"</small>
                        </div>

                        <div class="mb-3">
                            <label for="enclos_cree" class="form-label">Enclos <span class="text-danger">*</span></label>
                            <select name="enclos_cree" id="enclos_cree" class="form-control" required <?= empty($enclos) ? 'disabled' : '' ?>>
                                <?php if (empty($enclos)): ?>
                                    <option value="">-- Sélectionner d'abord une zone --</option>
                                <?php else: ?>
                                    <option value="">-- Sélectionner un enclos --</option>
                                    <?php
                                    foreach ($enclos as $enc) {
                                        $enclosValue = $enc['LATITUDE'] . '|' . $enc['LONGITUDE'];
                                        $currentEnclos = $formData['latitude_enclos'] . '|' . $formData['longitude_enclos'];
                                        $selected = ($enclosValue == $currentEnclos) ? 'selected' : '';
                                        echo '<option value="' . htmlspecialchars($enclosValue) . '" ' . $selected . '>';
                                        echo 'Enclos - Lat: ' . htmlspecialchars($enc['LATITUDE']) . ', Long: ' . htmlspecialchars($enc['LONGITUDE']);
                                        echo '</option>';
                                    }
                                    ?>
                                <?php endif; ?>
                            </select>
                            <input type="hidden" id="latitude_enclos_cree" name="latitude_enclos_cree" value="<?= htmlspecialchars($formData['latitude_enclos']) ?>">
                            <input type="hidden" id="longitude_enclos_cree" name="longitude_enclos_cree" value="<?= htmlspecialchars($formData['longitude_enclos']) ?>">
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Créer l'animal
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

<script>
    // Mise à jour des champs cachés lors de la sélection d'un enclos
    document.getElementById('enclos_cree').addEventListener('change', function() {
        const value = this.value;
        if (value) {
            const [latitude, longitude] = value.split('|');
            document.getElementById('latitude_enclos_cree').value = latitude;
            document.getElementById('longitude_enclos_cree').value = longitude;
        }
    });
</script>