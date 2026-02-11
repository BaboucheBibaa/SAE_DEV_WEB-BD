<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Modifier l'employé</h3>
                </div>
                <div class="card-body">
                    <!--ID employé en hidden car l'admin a pas à le modifier mais il doit quand même être transmis pour l'update-->
                    <form action="index.php?action=updateEmployee&id=<?= $employee['ID_Personnel'] ?>" method="POST">
                        <input type="hidden" name="id_employee" value="<?= $employee['ID_Personnel'] ?>">

                        <div class="mb-3">
                            <label for="nom_modif" class="form-label">Nom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nom_modif" name="nom_modif" 
                                   value="<?= $employee['Nom'] ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="prenom_modif" class="form-label">Prénom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="prenom_modif" name="prenom_modif" 
                                   value="<?= $employee['Prenom'] ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="mail_modif" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="mail_modif" name="mail_modif" 
                                   value="<?= $employee['mail'] ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="MDP_modif" class="form-label">Nouveau mot de passe</label>
                            <input type="password" class="form-control" id="MDP_modif" name="MDP_modif" 
                                   placeholder="Laisser vide pour conserver le mot de passe actuel">
                            <small class="text-muted">Remplir uniquement si vous souhaitez modifier le mot de passe.</small>
                        </div>

                        <div class="mb-3">
                            <label for="date_entree_modif" class="form-label">Date d'entrée</label>
                            <input type="date" class="form-control" id="date_entree_modif" name="date_entree_modif" 
                                   value="<?= $employee['Date_Entree'] ?>">
                        </div>

                        <div class="mb-3">
                            <label for="salaire_modif" class="form-label">Salaire <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="salaire_modif" name="salaire_modif" 
                                   value="<?= $employee['Salaire'] ?? '' ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="id_role_modif" class="form-label">Fonction</label>
                            <?php 
                            //Affichage du menu déroulant
                            if (!empty($liste_roles)){

                                echo '<select name="role_modif" id="id_role_modif" class="form-control">';
                                echo '<option value="' .$job['Nom_Role']. '">'.$job['Nom_Role'].'</option>';
                    
                                foreach ($liste_roles as $role) {
                                    // On n'affiche pas le rôle actuel de l'employé dans la liste déroulante pour éviter les doublons
                                    if (($role['Nom_Role'] == $job['Nom_Role'])) {
                                        continue;
                                    }
                                    echo '<option value="' . $role['Nom_Role'] . '"';
                                    echo '>' . $role['Nom_Role'] . '</option>';
                                }
                                echo '</select>';
                            }
                            ?>
                        </div>

                        <div class="mb-3">
                            <label for="login_modif" class="form-label">Login</label>
                            <input type="text" class="form-control" id="login_modif" name="login_modif" 
                                   value="<?= $employee['login'] ?? '' ?>" 
                                   placeholder="Nom d'utilisateur">
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Enregistrer les modifications
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
