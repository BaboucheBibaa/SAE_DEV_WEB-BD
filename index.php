<?php
session_start();
require_once 'config/myparams.inc.php';

require_once 'config/database.php';

require_once 'models/m-Compatibilite.php';
require_once 'models/m-Enclos.php';
require_once 'models/m-HistoriqueSoins.php';
require_once 'models/m-Fonction.php';
require_once 'models/m-Boutique.php';
require_once 'models/m-Animal.php';
require_once 'models/m-Espece.php';
require_once 'models/m-Enclos.php';
require_once 'models/m-User.php';
require_once 'models/m-Zone.php';

require_once 'utilities/Utils.php';
require_once 'services/ServiceAnimal.php';
require_once 'services/ServiceBoutique.php';
require_once 'services/ServiceEmployee.php';
require_once 'services/ServiceZone.php';
require_once 'services/ServiceSearch.php';

require_once 'controllers/c-base.php';
require_once 'controllers/c-profil.php';
require_once 'controllers/c-connexion.php';
require_once 'controllers/c-pageAdmin.php';
require_once 'controllers/c-respSoigneurs.php';
require_once 'controllers/c-profilAnimal.php';
require_once 'controllers/c-search.php';
require_once 'controllers/c-respBoutique.php';
require_once 'controllers/c-enclos.php';


//toutes les pages se chargeront par index.php via la méthode GET action, une seule page sera affichée
$action = $_GET['action'] ?? 'home';


// On instancie UNIQUEMENT les contrôleurs nécessaires au fonctionnement de la page demandée par GET.
switch ($action){
    case 'home':
    case 'afficheConnexion':
    case 'connexion':
    case 'deconnexion':
        $controller = new ConnexionController();
        break;
    case 'profil':
    case 'update_password':
        $controller = new ProfilController();
        break;
    case 'admin_dashboard':    
    case 'supprEmployee':
    case 'creationEmployee':
    case 'ajoutEmployee':
    case 'editionEmployee':
    case 'updateEmployee':
    case 'creationBoutique':
    case 'ajoutBoutique':
    case 'editionBoutique':
    case 'majBoutique':
    case 'supprBoutique':
    case 'creationZone':
    case 'ajoutZone':
    case 'editionZone':
    case 'majZone':
    case 'supprZone':
    case 'creationAnimal':
    case 'ajoutAnimal':
    case 'editionAnimal':
    case 'majAnimal':
    case 'supprAnimal':
        $controller = new AdminController();
        break;
    case 'respZone_dashboard':
        $controller = new RespSoigneurController();
        break;
    case "respBoutique_dashboard":
        $controller = new RespBoutiqueController();
        break;
    case 'profilAnimal':
        $controller = new ProfilAnimalController();
        break;
    case 'profilEnclos':
        $controller = new EnclosController();
        break;
    case 'search':
        $controller = new SearchController();
        break;
    default:
        echo "Page introuvable";
        exit;
}

// Gestion des pages demandées par GET
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
        $controller->profil($_GET['id']);
        break;

    case 'update_password':
        $controller->update_password();
        break;

    case 'admin_dashboard':
        $controller->profil_admin();
        break;

    case 'supprEmployee':
        $controller->supprEmployee($_GET['id']);
        break;

    case 'creationEmployee':
        $controller->creationEmployee();
        break;

    case 'ajoutEmployee':
        $controller->ajoutEmployee();
        break;

    case 'editionEmployee':
        $controller->editionEmployee($_GET['id']);
        break;

    case 'updateEmployee':
        $controller->majEmployee($_GET['id']);
        break;

    // Routes pour les boutiques
    case 'creationBoutique':
        $controller->creationBoutique();
        break;

    case 'ajoutBoutique':
        $controller->ajoutBoutique();
        break;

    case 'editionBoutique':
        $controller->editionBoutique($_GET['id']);
        break;

    case 'majBoutique':
        $controller->majBoutique($_GET['id']);
        break;

    case 'supprBoutique':
        $controller->supprBoutique($_GET['id']);
        break;

    // Routes pour les zones
    case 'creationZone':
        $controller->creationZone();
        break;

    case 'ajoutZone':
        $controller->ajoutZone();
        break;

    case 'editionZone':
        $controller->editionZone($_GET['id']);
        break;

    case 'majZone':
        $controller->majZone($_GET['id']);
        break;

    case 'supprZone':
        $controller->supprZone($_GET['id']);
        break;

    // Routes pour les animaux
    case 'creationAnimal':
        $controller->creationAnimal();
        break;

    case 'ajoutAnimal':
        $controller->ajoutAnimal();
        break;

    case 'editionAnimal':
        $controller->editionAnimal($_GET['id']);
        break;

    case 'majAnimal':
        $controller->majAnimal($_GET['id']);
        break;

    case 'supprAnimal':
        $controller->supprAnimal($_GET['id']);
        break;

    case 'profilEnclos':
        $controller->profilEnclos($_GET['latitude'], $_GET['longitude']);
        break;

    case 'respZone_dashboard':
        $controller->afficherPage();
        break;
    case 'respBoutique_dashboard':
        $controller->afficherPage();
        break;
    case 'profilAnimal':
        $controller->profilAnimal($_GET['id']);
        break;
    
    
    case 'search':
        $controller->gererRequete();
        break;
        
    default:
        echo "Page introuvable";
}
