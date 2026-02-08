<?php
require_once 'models/User.php';

class GestionPagesAdmin
{

    public function profil_admin()
    {
        if (empty($_SESSION['user'])) {
            if ($_SESSION['user']['est_admin'] == true) {
                header('Location: index.php?action=profil');
                exit;
            }
        }
        $title = "Profil Administrateur";
        $employees = $this->recupTousEmployes();
        if (isset($_SESSION["nom_cree"])) {
            echo "prout";
        }
        $view = 'views/administrateur/dashboard.php';

        require_once 'views/includes.php';
    }

    public function recupTousEmployes()
    {
        //Récupère tous les employés de la base de données pour les retourner sous forme de tableau pour les afficher dans le dashboard admin
        return User::toutRecup();
    }

    public function supprEmployee($id)
    {
        //Supprime un employé de la base de données en fonction de l'id passé en paramètre
        User::suppr($id);
        header('Location: index.php?action=admin_dashboard');
        exit;
    }
    public function ajoutEmployee()
    {
        //Ajoute un nouvel employé à la base de données en récupérant les données du formulaire de création d'employé
        $data = [
            'nom' => $_POST['nom_cree'] ?? null,
            'prenom' => $_POST['prenom_cree'] ?? null,
            'mail' => $_POST['mail_cree'] ?? null,
            'MDP' => password_hash($_POST['MDP_cree'], PASSWORD_DEFAULT),
            'date_entree' => $_POST['date_entree_cree'] ?? null,
            'salaire' => $_POST['salaire_cree'] ?? null,
            'id_role' => $_POST['id_role_cree'] ?? null,
            'login' => $_POST['login_cree'] ?? null
        ];

        User::creer($data);
        header('Location: index.php?action=admin_dashboard');
        exit;
    }

    public function editionEmployee($id)
    {
        //Affiche la page d'édition de l'employé
        if (!$id) {
            header('Location: index.php?action=admin_dashboard');
            exit;
        }

        $employee = User::recupParID($id);

        if (!$employee) {
            header('Location: index.php?action=admin_dashboard');
            exit;
        }

        $title = "Modifier un Employé";
        $view = 'views/administrateur/edit_employee.php';
        require_once 'views/includes.php';
    }


    public function majEmployee($id)
    {
        //Met à jour les données d'un employé dans la base de données en fonction de l'id passé en paramètre

        // Récupération du mot de passe actuel
        $employee = User::recupParID($id);

        // Si le champ mot de passe est vide, on garde l'ancien, sinon on hash le nouveau
        $password = !empty($_POST['MDP_modif']) ? password_hash($_POST['MDP_modif'], PASSWORD_DEFAULT) : $employee['MDP'];

        $data = [
            'nom' => $_POST['nom_modif'] ?? null,
            'prenom' => $_POST['prenom_modif'] ?? null,
            'mail' => $_POST['mail_modif'] ?? null,
            'MDP' => $password,
            'date_entree' => $_POST['date_entree_modif'] ?? null,
            'salaire' => $_POST['salaire_modif'] ?? null,
            'id_role' => $_POST['id_role_modif'] ?? null,
            'login' => $_POST['login_modif'] ?? null
        ];

        User::maj($id, $data);
        header('Location: index.php?action=admin_dashboard');
        exit;
    }
    public function creationEmployee()
    {
        //Affiche la page de création d'un nouvel employé
        $title = "Ajouter un Employé";
        $generatedPassword = $this->genereMDP();
        $view = 'views/administrateur/create_employee.php';
        require_once 'views/includes.php';
    }

    public function genereMDP()
    {
        //Génération d'un MDP aléatoire pour les nouveaux employés
        $password = '';
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 10; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
