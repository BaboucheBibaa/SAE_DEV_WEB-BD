<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Ajouter une compatibilité entre espèces</h3>
                </div>
                <div class="card-body">
                    <form action="index.php?action=ajoutCompatibilite" method="POST">
                        <div class="alert alert-info" role="alert">
                            <i class="bi bi-info-circle"></i> Sélectionnez deux espèces pour indiquer qu'elles sont compatibles et peuvent cohabiter dans le même enclos.
                        </div>

                        <div class="mb-3">
                            <label for="id_espece1" class="form-label">Première espèce <span class="text-danger">*</span></label>
                            <select class="form-select" id="id_espece1" name="id_espece1" required onchange="updateSecondEspece()">
                                <option value="">-- Sélectionner une espèce --</option>
                                <?php if (!empty($especes)): ?>
                                    <?php foreach ($especes as $espece): ?>
                                        <option value="<?= htmlspecialchars($espece['ID_ESPECE']) ?>">
                                            <?= htmlspecialchars($espece['NOM_ESPECE']) ?> (<?= htmlspecialchars($espece['NOM_LATIN_ESPECE']) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="id_espece2" class="form-label">Deuxième espèce <span class="text-danger">*</span></label>
                            <select class="form-select" id="id_espece2" name="id_espece2" required>
                                <option value="">-- Sélectionner une espèce --</option>
                                <?php if (!empty($especes)): ?>
                                    <?php foreach ($especes as $espece): ?>
                                        <option value="<?= htmlspecialchars($espece['ID_ESPECE']) ?>">
                                            <?= htmlspecialchars($espece['NOM_ESPECE']) ?> (<?= htmlspecialchars($espece['NOM_LATIN_ESPECE']) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="alert alert-warning" role="alert">
                            <i class="bi bi-exclamation-triangle"></i> 
                            <strong>Important :</strong> La compatibilité est symétrique.
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Ajouter la compatibilité
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
function updateSecondEspece() {
    const firstSelect = document.getElementById('id_espece1');
    const secondSelect = document.getElementById('id_espece2');
    
    // Réinitialiser la deuxième sélection
    secondSelect.value = '';
    
    // Options supplémentaires : on pourrait désactiver la même espèce dans la deuxième sélection
    // const selectedValue = firstSelect.value;
    // const options = secondSelect.getElementsByTagName('option');
    // for (let i = 0; i < options.length; i++) {
    //     options[i].disabled = options[i].value === selectedValue && options[i].value !== '';
    // }
}
</script>
