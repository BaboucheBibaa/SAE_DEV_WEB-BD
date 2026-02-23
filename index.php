<?php
session_start();
require_once 'models/m-Fonction.php';
require_once 'models/m-Boutique.php';
require_once 'models/m-Animal.php';
require_once 'models/m-Espece.php';
require_once 'models/m-Enclos.php';
require_once 'models/m-User.php';
require_once 'models/m-Zone.php';

require_once 'utilities/Utils.php';

require_once 'controllers/c-base.php';
require_once 'controllers/c-profil.php';
require_once 'controllers/c-connexion.php';
require_once 'controllers/c-pageAdmin.php';
require_once 'controllers/c-respSoigneurs.php';

//toutes les pages se chargeront par index.php via la méthode GET action, une seule page sera affichée
$action = $_GET['action'] ?? 'home';

$controller = new ConnexionController();
$controller_admin = new AdminController();
$controller_profil = new ProfilController();
$controller_resp_zone = new respSoigneurController();


switch ($action) {
    case 'home':
        $controller->home();
        break;

    case 'afficheConnexion':
        $controller->afficheConnexion();
        break;

    case 'connexion':
        $controller->connexion();
        break;

    case 'deconnexion':
        $controller->deconnexion();
        break;

    case 'profil':
        $controller_profil->profil();
        break;

    case 'update_password':
        $controller_profil->update_password();
        break;

    case 'admin_dashboard':
        $controller_admin->profil_admin();
        break;

    case 'supprEmployee':
        $controller_admin->supprEmployee($_GET['id']);
        break;

    case 'creationEmployee':
        $controller_admin->creationEmployee();
        break;

    case 'ajoutEmployee':
        $controller_admin->ajoutEmployee();
        break;

    case 'editionEmployee':
        $controller_admin->editionEmployee($_GET['id']);
        break;
    case 'updateEmployee':
        $controller_admin->majEmployee($_GET['id']);
        break;

    case 'majEmployee':
        $controller_admin->majEmployee($_GET['id']);
        break;

    // Routes pour les boutiques
    case 'creationBoutique':
        $controller_admin->creationBoutique();
        break;

    case 'ajoutBoutique':
        $controller_admin->ajoutBoutique();
        break;

    case 'editionBoutique':
        $controller_admin->editionBoutique($_GET['id']);
        break;

    case 'majBoutique':
        $controller_admin->majBoutique($_GET['id']);
        break;

    case 'supprBoutique':
        $controller_admin->supprBoutique($_GET['id']);
        break;

    // Routes pour les zones
    case 'creationZone':
        $controller_admin->creationZone();
        break;

    case 'ajoutZone':
        $controller_admin->ajoutZone();
        break;

    case 'editionZone':
        $controller_admin->editionZone($_GET['id']);
        break;

    case 'majZone':
        $controller_admin->majZone($_GET['id']);
        break;

    case 'supprZone':
        $controller_admin->supprZone($_GET['id']);
        break;

    // Routes pour les animaux
    case 'creationAnimal':
        $controller_admin->creationAnimal();
        break;

    case 'ajoutAnimal':
        $controller_admin->ajoutAnimal();
        break;

    case 'editionAnimal':
        $controller_admin->editionAnimal($_GET['id']);
        break;

    case 'majAnimal':
        $controller_admin->majAnimal($_GET['id']);
        break;

    case 'supprAnimal':
        $controller_admin->supprAnimal($_GET['id']);
        break;

    case 'respZone_dashboard':
        $controller_resp_zone->afficherPage();
        break;

    default:
        echo "Page introuvable";
}
