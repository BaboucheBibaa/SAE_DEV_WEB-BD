<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3>Créer un nouveau prestataire</h3>
                </div>
                <div class="card-body">
                    <form action="index.php?action=ajoutPrestataire" method="POST">
                        <div class="mb-3">
                            <label for="nom_cree" class="form-label">Nom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nom_cree" name="nom_cree" placeholder="Ex: Dupont" required>
                        </div>

                        <div class="mb-3">
                            <label for="prenom_cree" class="form-label">Prénom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="prenom_cree" name="prenom_cree" placeholder="Ex: Jean" required>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Créer le prestataire
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
