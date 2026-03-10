<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card ">
                <div class="card-header bg-primary text-white">
                    <h3>Modifier l'employé</h3>
                </div>
                <div class="card-body">
                    <!--ID employé en hidden car l'admin a pas à le modifier mais il doit quand même être transmis pour l'update-->
                    <form action="index.php?action=updateEmployee&id=<?= htmlspecialchars($employee['ID_PERSONNEL'] ?? '') ?>" method="POST">
                        <input type="hidden" name="id_employee" value="<?= htmlspecialchars($employee['ID_PERSONNEL'] ?? '') ?>">

                        <div class="mb-3">
                            <label for="nom_modif" class="form-label">Nom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nom_modif" name="nom_modif" 
                                   value="<?= htmlspecialchars($employee['NOM'] ?? '') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="prenom_modif" class="form-label">Prénom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="prenom_modif" name="prenom_modif" 
                                   value="<?= htmlspecialchars($employee['PRENOM'] ?? '') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="mail_modif" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="mail_modif" name="mail_modif" 
                                   value="<?= htmlspecialchars($employee['MAIL'] ?? '') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="MDP_modif" class="form-label">Nouveau mot de passe</label>
                            <input type="password" class="form-control" id="MDP_modif" name="MDP_modif" 
                                   placeholder="Laisser vide pour conserver le mot de passe actuel">
                            <small class="text-muted">Remplir uniquement si vous souhaitez modifier le mot de passe.</small>
                        </div>

                        <div class="mb-3">
                            <label for="date_entree_modif" class="form-label">Date d'entrée</label>
                            <?php
                            $dateObj = DateTime::createFromFormat('d/m/y', $employee['DATE_ENTREE']);
                            $nouvelleDate = $dateObj->format('Y-m-d');
                            ?>
                            <input type="date" class="form-control" id="date_entree_modif" name="date_entree_modif" 
                                   value="<?= htmlspecialchars($nouvelleDate) ?>">
                            <small class="text-muted">Laisser vide pour conserver la date actuelle</small>
                        </div>

                        <div class="mb-3">
                            <label for="salaire_modif" class="form-label">Salaire <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="salaire_modif" name="salaire_modif" 
                                   value="<?= htmlspecialchars($employee['SALAIRE'] ?? '') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="id_role_modif" class="form-label">Fonction <span class="text-danger">*</span></label>
                            <?php 
                            //Affichage du menu déroulant
                            if (!empty($liste_roles)){
                                echo '<select name="role_modif" id="id_role_modif" class="form-control" required>';
                                echo '<option value="' .$job['NOM_FONCTION']. '">'.htmlspecialchars($job['NOM_FONCTION']).'</option>';
                    
                                foreach ($liste_roles as $role) {
                                    // On n'affiche pas le rôle actuel de l'employé dans la liste déroulante pour éviter les doublons
                                    if (($role['NOM_FONCTION'] == $job['NOM_FONCTION'])) {
                                        continue;
                                    }
                                    echo '<option value="' . $role['NOM_FONCTION'] . '"';
                                    echo '>' . htmlspecialchars($role['NOM_FONCTION']) . '</option>';
                                }
                                echo '</select>';
                            }
                            ?>
                        </div>

                        <div class="mb-3">
                            <label for="id_remplacant_modif" class="form-label">Remplaçant <span class="text-danger">*</span></label>
                            <select name="id_remplacant_modif" id="id_remplacant_modif" class="form-control" required>
                                <option value="<?= $employee['ID_PERSONNEL'] ?>" <?= (isset($employee['ID_REMPLACANT']) && $employee['ID_REMPLACANT'] == $employee['ID_PERSONNEL']) ? 'selected' : '' ?>>Lui-même</option>
                                <?php
                                if (!empty($liste_employes)) {
                                    foreach ($liste_employes as $employe) {
                                        // Ne pas afficher l'employé lui-même dans la liste (déjà dans "Moi-même")
                                        if ($employe['ID_PERSONNEL'] == $employee['ID_PERSONNEL']) {
                                            continue;
                                        }
                                        $selected = '';
                                        if (isset($employee['ID_REMPLACANT']) && $employe['ID_PERSONNEL'] == $employee['ID_REMPLACANT']) {
                                            $selected = 'selected';
                                        }
                                        echo '<option value="' . $employe['ID_PERSONNEL'] . '" ' . $selected . '>';
                                        echo htmlspecialchars($employe['NOM'] . ' ' . $employe['PRENOM']);
                                        echo '</option>';
                                    }
                                }
                                ?>
                            </select>
                            <small class="text-muted">Sélectionnez "Lui-même" si l'employé n'a pas de remplaçant attitré</small>
                        </div>

                        <div class="mb-3">
                            <label for="id_superieur_modif" class="form-label">Supérieur hiérarchique (optionnel)</label>
                            <select name="id_superieur_modif" id="id_superieur_modif" class="form-control">
                                <option value="">-- Aucun --</option>
                                <?php
                                if (!empty($liste_employes)) {
                                    foreach ($liste_employes as $employe) {
                                        $selected = '';
                                        if (isset($employee['ID_SUPERIEUR']) && $employe['ID_PERSONNEL'] == $employee['ID_SUPERIEUR']) {
                                            $selected = 'selected';
                                        }
                                        echo '<option value="' . $employe['ID_PERSONNEL'] . '" ' . $selected . '>';
                                        echo htmlspecialchars($employe['NOM'] . ' ' . $employe['PRENOM']);
                                        echo '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="login_modif" class="form-label">Login</label>
                            <input type="text" class="form-control" id="login_modif" name="login_modif" 
                                   value="<?= $employee['LOGIN'] ?? '' ?>" 
                                   placeholder="Nom d'utilisateur">
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
