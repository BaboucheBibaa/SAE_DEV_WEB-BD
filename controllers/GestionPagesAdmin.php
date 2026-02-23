<?php
require_once 'models/Fonction.php';
require_once 'models/Boutique.php';
class GestionPagesAdmin
{

    public function profil_admin()
    {
        // Vérifier si l'utilisateur est connecté et s'il est admin
        if (empty($_SESSION['user'])) {
            header('Location: index.php?action=afficheConnexion');
            exit;
        }
        
        if (!isset($_SESSION['user']['ID_FONCTION']) || $_SESSION['user']['ID_FONCTION'] != ADMINID) {
            header('Location: index.php?action=profil');
            exit;
        }
        $title = "Profil Administrateur";
        $employees = $this->recupTousEmployes();
        $zones = Zone::toutRecup();
        $boutiques = Boutique::toutRecup();
        
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
            'id_fonction' => $_POST['id_fonction_cree'] ?? null,
            'login' => $_POST['login_cree'] ?? null,
            'id_remplacant' => !empty($_POST['id_remplacant_cree']) ? $_POST['id_remplacant_cree'] : null,
            'id_superieur' => !empty($_POST['id_superieur_cree']) ? $_POST['id_superieur_cree'] : null
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
        $liste_roles = Fonction::recupToutesLesFonctions();
        $liste_employes = User::toutRecup();
        $employee = User::recupParID($id);

        if (!$employee) {
            header('Location: index.php?action=admin_dashboard');
            exit;
        }
        //Récupération pour affichage par défaut du rôle actuel de l'employé
        $job = Fonction::recupNomFonctionParID($employee['ID_FONCTION']);

        $title = "Modifier un Employé";
        $view = 'views/administrateur/edit_employee.php';
        require_once 'views/includes.php';
    }


    public function majEmployee($id)
    {
        //Met à jour les données d'un employé dans la base de données en fonction de l'id passé en paramètre

        // récup les données de l'employé via son ID
        $employee = User::recupParID($id);

        //on modifie le champ id_fonction_modif pour qu'il contienne l'id de la fonction correspondant au nom de la fonction sélectionnée dans le form
        $nom_fonction = $_POST['fonction_modif'] ?? null;
        if (!(empty($nom_fonction))) {
            $id_fonction = Fonction::recupIDFonctionParNom($nom_fonction);
            $_POST['id_fonction_modif'] = $id_fonction['ID_FONCTION'];
        }
        // Si le champ mot de passe n'est pas vide on prend le nouveau mot de passe hashé sinon on garde l'ancien mot de passe
        $password = !empty($_POST['MDP_modif']) ? password_hash($_POST['MDP_modif'], PASSWORD_DEFAULT) : $employee['MDP'];

        $data = [
            'nom' => $_POST['nom_modif'] ?? null,
            'prenom' => $_POST['prenom_modif'] ?? null,
            'mail' => $_POST['mail_modif'] ?? null,
            'MDP' => $password,
            'date_entree' => $_POST['date_entree_modif'] ?? null,
            'salaire' => $_POST['salaire_modif'] ?? null,
            'id_fonction' => $_POST['id_fonction_modif'] ?? null,
            'login' => $_POST['login_modif'] ?? null,
            'id_remplacant' => !empty($_POST['id_remplacant_modif']) ? $_POST['id_remplacant_modif'] : null,
            'id_superieur' => !empty($_POST['id_superieur_modif']) ? $_POST['id_superieur_modif'] : null
        ];

        User::maj($id, $data);
        header('Location: index.php?action=admin_dashboard');
        exit;
    }

    public function creationEmployee()
    {
        //Affiche la page de création d'un nouvel employé
        $liste_fonctions = Fonction::recupToutesLesFonctions();
        $liste_employes = User::toutRecup();

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

    // ========== Gestion des Boutiques ==========

    public function creationBoutique()
    {
        //Affiche la page de création d'une nouvelle boutique
        $zones = Zone::toutRecup();
        $employees = User::toutRecup();
        $title = "Créer une Boutique";
        $view = 'views/administrateur/create_boutique.php';
        require_once 'views/includes.php';
    }

    public function ajoutBoutique()
    {
        //Ajoute une nouvelle boutique à la base de données
        $data = [
            'id_manager' => !empty($_POST['id_manager_cree']) ? $_POST['id_manager_cree'] : null,
            'id_zone' => $_POST['id_zone_cree'] ?? null,
            'nom_boutique' => $_POST['nom_boutique_cree'] ?? null,
            'description_boutique' => $_POST['description_boutique_cree'] ?? null
        ];

        Boutique::creer($data);
        header('Location: index.php?action=admin_dashboard');
        exit;
    }

    public function editionBoutique($id)
    {
        //Affiche la page d'édition de la boutique
        if (!$id) {
            header('Location: index.php?action=admin_dashboard');
            exit;
        }

        $boutique = Boutique::recupParID($id);
        if (!$boutique) {
            header('Location: index.php?action=admin_dashboard');
            exit;
        }

        $zones = Zone::toutRecup();
        $employees = User::toutRecup();
        $title = "Modifier une Boutique";
        $view = 'views/administrateur/edit_boutique.php';
        require_once 'views/includes.php';
    }

    public function majBoutique($id)
    {
        //Met à jour les données d'une boutique
        $data = [
            'id_manager' => !empty($_POST['id_manager_modif']) ? $_POST['id_manager_modif'] : null,
            'id_zone' => $_POST['id_zone_modif'] ?? null,
            'nom_boutique' => $_POST['nom_boutique_modif'] ?? null,
            'description_boutique' => $_POST['description_boutique_modif'] ?? null
        ];

        Boutique::maj($id, $data);
        header('Location: index.php?action=admin_dashboard');
        exit;
    }

    public function supprBoutique($id)
    {
        //Supprime une boutique de la base de données
        Boutique::suppr($id);
        header('Location: index.php?action=admin_dashboard');
        exit;
    }

    // ========== Gestion des Zones ==========

    public function creationZone()
    {
        //Affiche la page de création d'une nouvelle zone
        $employees = User::toutRecup();
        $title = "Créer une Zone";
        $view = 'views/administrateur/create_zone.php';
        require_once 'views/includes.php';
    }

    public function ajoutZone()
    {
        //Ajoute une nouvelle zone à la base de données
        $data = [
            'nom_zone' => $_POST['nom_zone_cree'] ?? null,
            'id_manager' => !empty($_POST['id_manager_cree']) ? $_POST['id_manager_cree'] : null
        ];

        Zone::creer($data);
        header('Location: index.php?action=admin_dashboard');
        exit;
    }

    public function editionZone($id)
    {
        //Affiche la page d'édition de la zone
        if (!$id) {
            header('Location: index.php?action=admin_dashboard');
            exit;
        }

        $zone = Zone::recupParID($id);
        if (!$zone) {
            header('Location: index.php?action=admin_dashboard');
            exit;
        }

        $employees = User::toutRecup();
        $title = "Modifier une Zone";
        $view = 'views/administrateur/edit_zone.php';
        require_once 'views/includes.php';
    }

    public function majZone($id)
    {
        //Met à jour les données d'une zone
        $data = [
            'nom_zone' => $_POST['nom_zone_modif'] ?? null,
            'id_manager' => !empty($_POST['id_manager_modif']) ? $_POST['id_manager_modif'] : null
        ];

        Zone::maj($id, $data);
        header('Location: index.php?action=admin_dashboard');
        exit;
    }

    public function supprZone($id)
    {
        //Supprime une zone de la base de données
        Zone::suppr($id);
        header('Location: index.php?action=admin_dashboard');
        exit;
    }
}
