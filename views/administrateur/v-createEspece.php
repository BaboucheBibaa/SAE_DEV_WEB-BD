<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3>Créer une nouvelle espèce</h3>
                </div>
                <div class="card-body">
                    <form action="index.php?action=ajoutEspece" method="POST">
                        <div class="mb-3">
                            <label for="nom_espece_cree" class="form-label">Nom de l'espèce <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nom_espece_cree" name="nom_espece_cree" placeholder="Ex: Lion" required>
                        </div>

                        <div class="mb-3">
                            <label for="nom_latin_espece_cree" class="form-label">Nom Latin <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nom_latin_espece_cree" name="nom_latin_espece_cree" placeholder="Ex: Panthera leo" required>
                        </div>

                        <div class="mb-3">
                            <label for="est_menacee_cree" class="form-label">Espèce menacée <span class="text-danger">*</span></label>
                            <select class="form-select" id="est_menacee_cree" name="est_menacee_cree" required>
                                <option value="">-- Sélectionner --</option>
                                <option value="1">Oui, espèce menacée</option>
                                <option value="0">Non, espèce non menacée</option>
                            </select>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Créer l'espèce
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
