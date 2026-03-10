<?php

class ServiceEmployee {
    public function recupTousEmployes()
    {
        //Récupère tous les employés de la base de données pour les retourner sous forme de tableau pour les afficher dans le dashboard admin
        return User::toutRecup();
    }

    public function supprEmployee($id)
    {
        //Supprime un employé de la base de données en fonction de l'id passé en paramètre
        return User::suppr($id);
    }
    public function ajoutEmployee()
    {
        //Ajoute un nouvel employé à la base de données en récupérant les données du formulaire de création d'employé

        // Vérifier que la fonction est bien définie, sinon utiliser une fonction par défaut (ne devrait jamais arriver avec required)
        $id_fonction = $_POST['id_fonction_cree'] ?? null;
        if (empty($id_fonction)) {
            $fonctions = Fonction::recupToutesLesFonctions();
            $id_fonction = !empty($fonctions) ? $fonctions[0]['ID_FONCTION'] : null;
        }

        $data = [
            'nom' => $_POST['nom_cree'] ?? null,
            'prenom' => $_POST['prenom_cree'] ?? null,
            'mail' => $_POST['mail_cree'] ?? null,
            'MDP' => Utils::hashPassword($_POST['MDP_cree']),
            'date_entree' => $_POST['date_entree_cree'] ?? null,
            'salaire' => $_POST['salaire_cree'] ?? null,
            'id_fonction' => $id_fonction,
            'login' => $_POST['login_cree'] ?? null,
            'id_remplacant' => !empty($_POST['id_remplacant_cree']) ? $_POST['id_remplacant_cree'] : null,
            'id_superieur' => !empty($_POST['id_superieur_cree']) ? $_POST['id_superieur_cree'] : null
        ];
        return User::creer($data);
    }

    public function dataEditionEmployee($id)
    {
        //Retourne les données nécessaires à l'affichage du formulaire d'édition d'un employé en fonction de l'id passé en paramètre
        if (!$id) {
            return null;
        }
        $liste_roles = Fonction::recupToutesLesFonctions();
        $liste_employes = User::toutRecup();
        $employee = User::recupParID($id);

        if (!$employee) {
            return null; // Employé non trouvé
        }
        //Récupération pour affichage par défaut du rôle actuel de l'employé
        $job = Fonction::recupNomFonctionParID($employee['ID_FONCTION']);

        $title = "Modifier un Employé";

        return [
            'title' => $title,
            'employee' => $employee,
            'liste_roles' => $liste_roles,
            'liste_employes' => $liste_employes,
            'job' => $job
        ];
    }


    public function majEmployee($id)
    {
        //Met à jour les données d'un employé dans la base de données en fonction de l'id passé en paramètre

        // récup les données de l'employé via son ID
        $employee = User::recupParID($id);

        //on modifie le champ id_fonction_modif pour qu'il contienne l'id de la fonction correspondant au nom de la fonction sélectionnée dans le form
        $nom_fonction = $_POST['role_modif'] ?? null;
        $id_fonction_final = $employee['ID_FONCTION']; // Par défaut, garder la fonction actuelle

        if (!empty($nom_fonction)) {
            $id_fonction = Fonction::recupIDFonctionParNom($nom_fonction);
            $id_fonction_final = $id_fonction['ID_FONCTION'];
        }

        // Si le champ mot de passe n'est pas vide on prend le nouveau mot de passe hashé sinon on garde l'ancien mot de passe
        $password = !empty($_POST['MDP_modif']) ? password_hash($_POST['MDP_modif'], PASSWORD_DEFAULT) : $employee['MDP'];

        // Si aucun remplaçant n'est spécifié, l'employé est son propre remplaçant
        $id_remplacant = !empty($_POST['id_remplacant_modif']) ? $_POST['id_remplacant_modif'] : $id;

        $data = [
            'nom' => $_POST['nom_modif'] ?? null,
            'prenom' => $_POST['prenom_modif'] ?? null,
            'mail' => $_POST['mail_modif'] ?? null,
            'MDP' => $password,
            'date_entree' => $_POST['date_entree_modif'] ?? null,
            'salaire' => $_POST['salaire_modif'] ?? null,
            'id_fonction' => $id_fonction_final,
            'login' => $_POST['login_modif'] ?? null,
            'id_remplacant' => $id_remplacant,
            'id_superieur' => !empty($_POST['id_superieur_modif']) ? $_POST['id_superieur_modif'] : null
        ];

        return User::maj($id, $data);
    }

    public function dataCreationEmployee()
    {
        //Retourne les données nécessaires à l'affichage du formulaire de création d'un employé
        $liste_fonctions = Fonction::recupToutesLesFonctions();
        $liste_employes = User::toutRecup();
        $generatedPassword = Utils::generatePassword(10);
        if (!$liste_fonctions || !$liste_employes) {
            return null; // Erreur lors de la récupération des données nécessaires à la création d'un employé
        }
                    $title = 'Création d\'un employé';

        return [
            'title' => $title,
            'liste_fonctions' => $liste_fonctions,
            'liste_employes' => $liste_employes,
            'generatedPassword' => $generatedPassword
        ];
    }
}
