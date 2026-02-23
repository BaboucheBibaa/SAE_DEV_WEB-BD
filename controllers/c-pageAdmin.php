<?php
class AdminController extends BaseController
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
        $animals = Animal::toutRecup();

        if (isset($_SESSION["nom_cree"])) {
            echo "prout";
        }
        $this->render('administrateur/v-dashboard', [
            'title' => $title,
            'employees' => $employees,
            'zones' => $zones,
            'boutiques' => $boutiques,
            'animals' => $animals
        ]);
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
        $this->redirectWithMessage('admin_dashboard', 'Employé supprimé avec succès.', 'success');
    }
    public function ajoutEmployee()
    {
        //Ajoute un nouvel employé à la base de données en récupérant les données du formulaire de création d'employé

        // Vérifier que la fonction est bien définie, sinon utiliser une fonction par défaut (ne devrait jamais arriver avec required)
        $id_fonction = $_POST['id_fonction_cree'] ?? null;
        if (empty($id_fonction)) {
            // Récupérer la première fonction disponible comme fallback
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

        $new_id = User::creer($data);

        // Si aucun remplaçant n'a été spécifié, l'employé est son propre remplaçant
        if (empty($data['id_remplacant']) && $new_id) {
            User::majRemplacant($new_id, $new_id);
        }
        $this->redirectWithMessage('admin_dashboard', 'Employé créé avec succès.', 'success');
    }

    public function editionEmployee($id)
    {
        //Affiche la page d'édition de l'employé
        if (!$id) {
            $this->redirectWithMessage('admin_dashboard', 'Employé non trouvé.', 'error');
        }
        $liste_roles = Fonction::recupToutesLesFonctions();
        $liste_employes = User::toutRecup();
        $employee = User::recupParID($id);

        if (!$employee) {
            $this->redirectWithMessage('admin_dashboard', 'Employé non trouvé.', 'error');
        }
        //Récupération pour affichage par défaut du rôle actuel de l'employé
        echo $employee['ID_FONCTION'] . "caca";
        $job = Fonction::recupNomFonctionParID($employee['ID_FONCTION']);

        $title = "Modifier un Employé";

        $this->render("administrateur/v-edit_employee", [
            'title' => $title,
            'employee' => $employee,
            'liste_roles' => $liste_roles,
            'liste_employes' => $liste_employes,
            'job' => $job
        ]);
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

        User::maj($id, $data);
        $this->redirectWithMessage('admin_dashboard', 'Employé mis à jour avec succès.', 'success');
    }

    public function creationEmployee()
    {
        //Affiche la page de création d'un nouvel employé
        $liste_fonctions = Fonction::recupToutesLesFonctions();
        $liste_employes = User::toutRecup();
        $generatedPassword = Utils::generatePassword(10);

        $this->render('administrateur/create_employee', [
            'liste_fonctions' => $liste_fonctions,
            'liste_employes' => $liste_employes,
            'generatedPassword' => $generatedPassword
        ]);
    }



    // ========== Gestion des Boutiques ==========

    public function creationBoutique()
    {
        //Affiche la page de création d'une nouvelle boutique
        $zones = Zone::toutRecup();
        $employees = User::toutRecup();
        $title = "Créer une Boutique";
        $this->render('administrateur/create_boutique', [
            'zones' => $zones,
            'employees' => $employees,
            'title' => $title
        ]);
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
        $this->redirectWithMessage('admin_dashboard', 'Boutique créée avec succès.', 'success');
        exit;
    }

    public function editionBoutique($id)
    {
        //Affiche la page d'édition de la boutique
        if (!$id) {
            $this->redirectWithMessage('admin_dashboard', 'Boutique non trouvée.', 'error');
        }

        $boutique = Boutique::recupParID($id);
        if (!$boutique) {
            $this->redirectWithMessage('admin_dashboard', 'Boutique non trouvée.', 'error');
        }

        $zones = Zone::toutRecup();
        $employees = User::toutRecup();
        $title = "Modifier une Boutique";
        $this->render('administrateur/edit_boutique', [
            'title' => $title,
            'boutique' => $boutique,
            'zones' => $zones,
            'employees' => $employees
        ]);
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
        $this->redirectWithMessage('admin_dashboard', 'Boutique mise à jour avec succès.', 'success');
    }

    public function supprBoutique($id)
    {
        //Supprime une boutique de la base de données
        Boutique::suppr($id);
        $this->redirectWithMessage('admin_dashboard', 'Boutique supprimée avec succès.', 'success');
    }

    // ========== Gestion des Zones ==========

    public function creationZone()
    {
        //Affiche la page de création d'une nouvelle zone
        $employees = User::toutRecup();
        $title = "Créer une Zone";
        $this->render('administrateur/create_zone', [
            'employees' => $employees,
            'title' => $title
        ]);
    }

    public function ajoutZone()
    {
        //Ajoute une nouvelle zone à la base de données
        $data = [
            'nom_zone' => $_POST['nom_zone_cree'] ?? null,
            'id_manager' => !empty($_POST['id_manager_cree']) ? $_POST['id_manager_cree'] : null
        ];

        Zone::creer($data);
        $this->redirectWithMessage('admin_dashboard', 'Zone créée avec succès.', 'success');
        exit;
    }

    public function editionZone($id)
    {
        //Affiche la page d'édition de la zone
        if (!$id) {
            $this->redirectWithMessage('admin_dashboard', 'Zone non trouvée.', 'error');
        }

        $zone = Zone::recupParID($id);
        if (!$zone) {
            $this->redirectWithMessage('admin_dashboard', 'Zone non trouvée.', 'error');
        }

        $employees = User::toutRecup();
        $title = "Modifier une Zone";
        $this->render('administrateur/edit_zone', [
            'title' => $title,
            'zone' => $zone,
            'employees' => $employees
        ]);
    }

    public function majZone($id)
    {
        //Met à jour les données d'une zone
        $data = [
            'nom_zone' => $_POST['nom_zone_modif'] ?? null,
            'id_manager' => !empty($_POST['id_manager_modif']) ? $_POST['id_manager_modif'] : null
        ];

        Zone::maj($id, $data);
        $this->redirectWithMessage('admin_dashboard', 'Zone mise à jour avec succès.', 'success');
    }

    public function supprZone($id)
    {
        //Supprime une zone de la base de données
        Zone::suppr($id);
        $this->redirectWithMessage('admin_dashboard', 'Zone supprimée avec succès.', 'success');
    }

    // ========== Gestion des Animaux ==========

    public function creationAnimal()
    {
        //Affiche la page de création d'un nouvel animal
        $especes = Espece::toutRecup();
        $zones = Zone::toutRecup();

        // Récupérer les données du formulaire pour pré-remplissage
        $formData = [
            'nom_animal' => $_POST['nom_animal_cree'] ?? '',
            'id_espece' => $_POST['id_espece_cree'] ?? '',
            'date_naissance' => $_POST['date_naissance_cree'] ?? '',
            'poids' => $_POST['poids_cree'] ?? '',
            'regime_alimentaire' => $_POST['regime_alimentaire_cree'] ?? '',
            'id_zone' => $_POST['id_zone_cree'] ?? '',
            'latitude_enclos' => $_POST['latitude_enclos_cree'] ?? '',
            'longitude_enclos' => $_POST['longitude_enclos_cree'] ?? ''
        ];

        // Charger les enclos si une zone est sélectionnée
        $enclos = [];
        if (!empty($formData['id_zone'])) {
            $enclos = Enclos::recupEnclosZone($formData['id_zone']);
        }

        $title = "Créer un Animal";
        $this->render('administrateur/create_animal', [
            'formData' => $formData,
            'enclos' => $enclos,
            'title' => $title
        ]);
    }

    public function ajoutAnimal()
    {
        //Ajoute un nouvel animal à la base de données
        $data = [
            'nom_animal' => $_POST['nom_animal_cree'] ?? null,
            'date_naissance' => $_POST['date_naissance_cree'] ?? null,
            'poids' => $_POST['poids_cree'] ?? null,
            'regime_alimentaire' => $_POST['regime_alimentaire_cree'] ?? null,
            'id_espece' => $_POST['id_espece_cree'] ?? null,
            'latitude_enclos' => $_POST['latitude_enclos_cree'] ?? null,
            'longitude_enclos' => $_POST['longitude_enclos_cree'] ?? null
        ];

        Animal::creer($data);
        $this->redirectWithMessage('admin_dashboard', 'Animal créé avec succès.', 'success');
    }

    public function editionAnimal($id)
    {
        //Affiche la page d'édition de l'animal
        if (!$id) {
            $this->redirectWithMessage('admin_dashboard', 'Animal non trouvé.', 'error');
        }

        $animal = Animal::recupParID($id);
        if (!$animal) {
            $this->redirectWithMessage('admin_dashboard', 'Animal non trouvé.', 'error');
        }

        $especes = Espece::toutRecup();
        $zones = Zone::toutRecup();

        // Récupérer la zone sélectionnée (soit depuis le formulaire, soit depuis l'animal)
        $id_zone_selected = $_POST['id_zone_modif'] ?? $_GET['id_zone_modif'] ?? null;

        // Si pas de zone sélectionnée, trouver la zone de l'enclos actuel
        if (empty($id_zone_selected) && !empty($animal['LATITUDE_ENCLOS']) && !empty($animal['LONGITUDE_ENCLOS'])) {
            foreach ($zones as $zone) {
                $enclos_zone = Enclos::recupEnclosZone($zone['ID_ZONE']);
                foreach ($enclos_zone as $enc) {
                    if ($enc['LATITUDE'] == $animal['LATITUDE_ENCLOS'] && $enc['LONGITUDE'] == $animal['LONGITUDE_ENCLOS']) {
                        $id_zone_selected = $zone['ID_ZONE'];
                        break 2;
                    }
                }
            }
        }

        // Charger les enclos de la zone sélectionnée
        $enclos = [];
        if (!empty($id_zone_selected)) {
            $enclos = Enclos::recupEnclosZone($id_zone_selected);
        }

        $title = "Modifier un Animal";
        $this->render('administrateur/edit_animal', [
            'animal' => $animal,
            'especes' => $especes,
            'zones' => $zones,
            'enclos' => $enclos,
            'id_zone_selected' => $id_zone_selected,
            'title' => $title
        ]);
    }

    public function majAnimal($id)
    {
        //Met à jour les données d'un animal
        $data = [
            'nom_animal' => $_POST['nom_animal_modif'] ?? null,
            'date_naissance' => $_POST['date_naissance_modif'] ?? null,
            'poids' => $_POST['poids_modif'] ?? null,
            'regime_alimentaire' => $_POST['regime_alimentaire_modif'] ?? null,
            'id_espece' => $_POST['id_espece_modif'] ?? null,
            'latitude_enclos' => $_POST['latitude_enclos_modif'] ?? null,
            'longitude_enclos' => $_POST['longitude_enclos_modif'] ?? null
        ];

        Animal::maj($id, $data);
        $this->redirectWithMessage('admin_dashboard', 'Animal mis à jour avec succès.', 'success');
    }

    public function supprAnimal($id)
    {
        //Supprime un animal de la base de données
        Animal::suppr($id);
        $this->redirectWithMessage('admin_dashboard', 'Animal supprimé avec succès.', 'success');
    }
}
