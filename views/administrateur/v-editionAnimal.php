<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3><i class="fas fa-edit"></i> Modifier l'animal</h3>
                </div>
                <div class="card-body">
                    <form action="index.php?action=majAnimal&id=<?= htmlspecialchars($animal['ID_ANIMAL']) ?>" method="POST">
                        <div class="mb-3">
                            <label for="nom_animal_modif" class="form-label">Nom de l'animal <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nom_animal_modif" name="nom_animal_modif" value="<?= htmlspecialchars($animal['NOM_ANIMAL'] ?? '') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="id_espece_modif" class="form-label">Espèce <span class="text-danger">*</span></label>
                            <select name="id_espece_modif" id="id_espece_modif" class="form-control" required>
                                <option value="">-- Sélectionner une espèce --</option>
                                <?php
                                if (!empty($especes)) {
                                    foreach ($especes as $espece) {
                                        $selected = (isset($animal['ID_ESPECE']) && $espece['ID_ESPECE'] == $animal['ID_ESPECE']) ? 'selected' : '';
                                        echo '<option value="' . htmlspecialchars($espece['ID_ESPECE']) . '" ' . $selected . '>';
                                        echo htmlspecialchars($espece['NOM_ESPECE']);
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
                            <label for="date_naissance_modif" class="form-label">Date de naissance</label>
                            <?php
                            $dateObj = DateTime::createFromFormat('d/m/y', $animal['DATE_NAISSANCE']);
                            $nouvelleDate = $dateObj->format('Y-m-d');
                            ?>
                            <input type="date" class="form-control" id="date_naissance_modif" name="date_naissance_modif" value="<?= $nouvelleDate ?>">
                            <small class="text-muted">Laisser vide pour conserver la date actuelle</small>
                        </div>

                        <div class="mb-3">
                            <label for="poids_modif" class="form-label">Poids (kg) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control" id="poids_modif" name="poids_modif" value="<?= htmlspecialchars($animal['POIDS'] ?? '') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="regime_alimentaire_modif" class="form-label">Régime alimentaire <span class="text-danger">*</span></label>
                            <select name="regime_alimentaire_modif" id="regime_alimentaire_modif" class="form-control" required>
                                <option value="">-- Sélectionner un régime --</option>
                                <?php
                                $regimes = ['Carnivore', 'Herbivore', 'Omnivore', 'Insectivore', 'Frugivore'];
                                foreach ($regimes as $regime) {
                                    $selected = (isset($animal['REGIME_ALIMENTAIRE']) && $animal['REGIME_ALIMENTAIRE'] == $regime) ? 'selected' : '';
                                    echo '<option value="' . htmlspecialchars($regime) . '" ' . $selected . '>' . htmlspecialchars($regime) . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="id_zone_modif" class="form-label">Zone <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <select name="id_zone_modif" id="id_zone_modif" class="form-control" required>
                                    <option value="">-- Sélectionner une zone --</option>
                                    <?php
                                    if (!empty($zones)) {
                                        foreach ($zones as $zone) {
                                            $selected = (!empty($id_zone_selected) && $zone['ID_ZONE'] == $id_zone_selected) ? 'selected' : '';
                                            echo '<option value="' . htmlspecialchars($zone['ID_ZONE']) . '" ' . $selected . '>';
                                            echo htmlspecialchars($zone['NOM_ZONE']);
                                            echo '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                                <button type="submit" formaction="index.php?action=editionAnimal&id=<?= htmlspecialchars($animal['ID_ANIMAL']) ?>" class="btn btn-outline-secondary">
                                    <i class="fas fa-sync-alt"></i> Charger les enclos
                                </button>
                            </div>
                            <small class="text-muted">Sélectionnez une zone puis cliquez sur "Charger les enclos"</small>
                        </div>

                        <div class="mb-3">
                            <label for="enclos_modif" class="form-label">Enclos <span class="text-danger">*</span></label>
                            <select name="enclos_modif" id="enclos_modif" class="form-control" required <?= empty($enclos) ? 'disabled' : '' ?>>
                                <?php if (empty($enclos)): ?>
                                    <option value="">-- Sélectionner d'abord une zone --</option>
                                <?php else: ?>
                                    <option value="">-- Sélectionner un enclos --</option>
                                    <?php
                                    foreach ($enclos as $enc) {
                                        $enclosValue = $enc['LATITUDE'] . '|' . $enc['LONGITUDE'];
                                        $currentEnclos = $animal['LATITUDE_ENCLOS'] . '|' . $animal['LONGITUDE_ENCLOS'];
                                        $selected = ($enclosValue == $currentEnclos) ? 'selected' : '';
                                        echo '<option value="' . htmlspecialchars($enclosValue) . '" ' . $selected . '>';
                                        echo 'Enclos - Lat: ' . htmlspecialchars($enc['LATITUDE']) . ', Long: ' . htmlspecialchars($enc['LONGITUDE']);
                                        echo '</option>';
                                    }
                                    ?>
                                <?php endif; ?>
                            </select>
                            <input type="hidden" id="latitude_enclos_modif" name="latitude_enclos_modif" value="<?= htmlspecialchars($animal['LATITUDE_ENCLOS'] ?? '') ?>">
                            <input type="hidden" id="longitude_enclos_modif" name="longitude_enclos_modif" value="<?= htmlspecialchars($animal['LONGITUDE_ENCLOS'] ?? '') ?>">
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

<script>
    // Mise à jour des champs cachés lors de la sélection d'un enclos
    document.getElementById('enclos_modif').addEventListener('change', function() {
        const value = this.value;
        if (value) {
            const [latitude, longitude] = value.split('|');
            document.getElementById('latitude_enclos_modif').value = latitude;
            document.getElementById('longitude_enclos_modif').value = longitude;
        }
    });
</script>