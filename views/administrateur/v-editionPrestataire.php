<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3>Modifier le prestataire</h3>
                </div>
                <div class="card-body">
                    <!-- ID prestataire en hidden pour se référencer lors de l'update -->
                    <form action="index.php?action=updatePrestataire&id=<?= htmlspecialchars($prestataire['ID_PRESTATAIRE'] ?? '') ?>" method="POST">
                        <input type="hidden" name="id_prestataire" value="<?= htmlspecialchars($prestataire['ID_PRESTATAIRE'] ?? '') ?>">

                        <div class="mb-3">
                            <label for="nom_modif" class="form-label">Nom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nom_modif" name="nom_modif" 
                                   value="<?= htmlspecialchars($prestataire['NOM_PRESTATAIRE'] ?? '') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="prenom_modif" class="form-label">Prénom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="prenom_modif" name="prenom_modif" 
                                   value="<?= htmlspecialchars($prestataire['PRENOM_PRESTATAIRE'] ?? '') ?>" required>
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
