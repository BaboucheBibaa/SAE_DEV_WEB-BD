<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Créer un nouvel employé</h3>
                </div>
                <div class="card-body">
                    <form action="index.php?action=add_employee" method="POST">
                        <div class="mb-3">
                            <label for="nom_cree" class="form-label">Nom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nom_cree" name="nom_cree" required>
                        </div>

                        <div class="mb-3">
                            <label for="prenom_cree" class="form-label">Prénom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="prenom_cree" name="prenom_cree" required>
                        </div>

                        <div class="mb-3">
                            <label for="mail_cree" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="mail_cree" name="mail_cree" required>
                        </div>

                        <div class="mb-3">
                            <label for="MDP_cree" class="form-label">Mot de passe <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="MDP_cree" name="MDP_cree" value="<?= 
                            ($generatedPassword ?? '') ?>" readonly required>
                                <button class="btn btn-outline-secondary" type="button" onclick="location.reload()">
                                    <i class="fas fa-sync-alt"></i> Régénérer
                                </button>
                            </div>
                            <small class="text-muted">Mot de passe généré aléatoirement.</small>
                        </div>

                        <div class="mb-3">
                            <label for="date_entree_cree" class="form-label">Date d'entrée</label>
                            <input type="date" class="form-control" id="date_entree_cree" name="date_entree_cree">
                        </div>

                        <div class="mb-3">
                            <label for="salaire_cree" class="form-label">Salaire<span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="salaire_cree" name="salaire_cree" required>
                        </div>

                        <div class="mb-3">
                            <label for="id_role_cree" class="form-label">ID Role</label>
                            <input type="text" class="form-control" id="id_role_cree" name="id_role_cree" placeholder="Ex: Soigneur, Vétérinaire, Guide...">
                        </div>

                        <div class="mb-3">
                            <label for="login_cree" class="form-label">Login</label>
                            <input type="text" class="form-control" id="login_cree" name="login_cree" placeholder="Ex: Soigneur, Vétérinaire, Guide...">
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Créer l'employé
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