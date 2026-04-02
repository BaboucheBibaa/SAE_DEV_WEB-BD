<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3>Modifier l'espèce</h3>
                </div>
                <div class="card-body">
                    <form action="index.php?action=updateEspece&id=<?= htmlspecialchars($espece['ID_ESPECE'] ?? '') ?>" method="POST">
                        <input type="hidden" name="id_espece" value="<?= htmlspecialchars($espece['ID_ESPECE'] ?? '') ?>">

                        <div class="mb-3">
                            <label for="nom_espece_modif" class="form-label">Nom de l'espèce <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nom_espece_modif" name="nom_espece_modif" 
                                   value="<?= htmlspecialchars($espece['NOM_ESPECE'] ?? '') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="nom_latin_modif" class="form-label">Nom Latin <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nom_latin_modif" name="nom_latin_modif" 
                                   value="<?= htmlspecialchars($espece['NOM_LATIN_ESPECE'] ?? '') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="est_menacee_modif" class="form-label">Espèce menacée <span class="text-danger">*</span></label>
                            <select class="form-select" id="est_menacee_modif" name="est_menacee_modif" required>
                                <option value="">-- Sélectionner --</option>
                                <option value="1" <?= ($espece['EST_MENACEE'] == 1) ? 'selected' : '' ?>>Oui, espèce menacée</option>
                                <option value="0" <?= ($espece['EST_MENACEE'] == 0) ? 'selected' : '' ?>>Non, espèce non menacée</option>
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
