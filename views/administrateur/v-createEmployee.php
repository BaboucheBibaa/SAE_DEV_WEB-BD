<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Créer un nouvel employé</h3>
                </div>
                <div class="card-body">
                    <form action="index.php?action=ajoutEmployee" method="POST">
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
                                <input type="text" class="form-control" id="MDP_cree" name="MDP_cree" value="<?= htmlspecialchars($generatedPassword ?? '') ?>" readonly required>
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
                            <label for="id_fonction_cree" class="form-label">Fonction <span class="text-danger">*</span></label>
                            <?php
                            //Affichage du menu déroulante
                            if (!empty($liste_fonctions)) {

                                echo '<select name="id_fonction_cree" id="id_fonction_cree" class="form-control" required>';

                                foreach ($liste_fonctions as $fonction) {
                                    echo '<option value="' . $fonction['ID_FONCTION'] . '"';
                                    echo '>' . htmlspecialchars($fonction['NOM_FONCTION']) . '</option>';
                                }
                                echo '</select>';
                            }
                            ?>
                        </div>

                        <div class="mb-3">
                            <label for="id_remplacant_cree" class="form-label">Remplaçant</label>
                            <select name="id_remplacant_cree" id="id_remplacant_cree" class="form-control">
                                <option value="" selected>Moi-même (par défaut)</option>
                                <?php
                                if (!empty($liste_employes)) {
                                    foreach ($liste_employes as $employe) {
                                        echo '<option value="' . $employe['ID_PERSONNEL'] . '">';
                                        echo htmlspecialchars($employe['NOM'] . ' ' . $employe['PRENOM']);
                                        echo '</option>';
                                    }
                                }
                                ?>
                            </select>
                            <small class="text-muted">Laissez "Moi-même" si l'employé n'a pas de remplaçant attitré</small>
                        </div>

                        <div class="mb-3">
                            <label for="id_superieur_cree" class="form-label">Supérieur hiérarchique (optionnel)</label>
                            <select name="id_superieur_cree" id="id_superieur_cree" class="form-control">
                                <option value="">-- Aucun --</option>
                                <?php
                                if (!empty($liste_employes)) {
                                    foreach ($liste_employes as $employe) {
                                        echo '<option value="' . $employe['ID_PERSONNEL'] . '">';
                                        echo htmlspecialchars($employe['NOM'] . ' ' . $employe['PRENOM']);
                                        echo '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="login_cree" class="form-label">Login</label>
                            <input type="text" class="form-control" id="login_cree" name="login_cree" placeholder="">
                        </div>

                        <div class="card mt-4 border-start border-4 border-primary">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Contrat de travail</h5>
                            </div>
                            <div class="card-body">
                                <div id="bloc_contrat_fields">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="date_debut_contrat_cree" class="form-label">Date debut contrat <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="date_debut_contrat_cree" name="date_debut_contrat_cree" value="<?= date('Y-m-d') ?>" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="date_fin_contrat_cree" class="form-label">Date fin contrat</label>
                                            <input type="date" class="form-control" id="date_fin_contrat_cree" name="date_fin_contrat_cree">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Créer l'employé
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