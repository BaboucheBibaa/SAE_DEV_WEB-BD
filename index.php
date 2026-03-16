<?php
define("ADMINID",10);
define("RESPSOIG",11);
define("SOIGNEUR",12);
define("EMPLOYEE_BOUTIQUE",15);
define("RESPBOUTIQUE",14);

session_start();

require_once 'config/myparams.inc.php';

require_once 'config/database.php';

require_once 'models/m-Parrainage.php';
require_once 'models/m-Compatibilite.php';
require_once 'models/m-Enclos.php';
require_once 'models/m-Reparation.php';
require_once 'models/m-HistoriqueSoins.php';
require_once 'models/m-Fonction.php';
require_once 'models/m-Boutique.php';
require_once 'models/m-Animal.php';
require_once 'models/m-Espece.php';
require_once 'models/m-Enclos.php';
require_once 'models/m-User.php';
require_once 'models/m-Zone.php';
require_once 'models/m-ContratTravail.php';
require_once 'models/m-CA.php';

require_once 'utilities/Utils.php';

require_once 'services/ServiceAnimal.php';
require_once 'services/ServiceBoutique.php';
require_once 'services/ServiceEmployee.php';
require_once 'services/ServiceZone.php';
require_once 'services/ServiceSearch.php';
require_once 'services/ServiceSoin.php';
require_once 'services/ServiceCA.php';
require_once 'services/ServiceParrainage.php';
require_once 'services/ServiceEnclos.php';
require_once 'services/ServiceReparation.php';

require_once 'controllers/c-base.php';
require_once 'controllers/c-soigneurs.php';
require_once 'controllers/c-employeBoutique.php';
require_once 'controllers/c-profil.php';
require_once 'controllers/c-connexion.php';
require_once 'controllers/c-respSoigneurs.php';
require_once 'controllers/c-respBoutique.php';
require_once 'controllers/c-profilAnimal.php';
require_once 'controllers/c-profilEnclos.php';
require_once 'controllers/c-profilAdmin.php';
require_once 'controllers/c-search.php';
require_once 'controllers/c-profilZone.php';


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
    case 'updatePassword':
        $controller = new ProfilController();
        break;
    case 'adminDashboard':    
    case 'supprEmployee':
    case 'archiverEmployee':
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
    case 'respZoneDashboard':
        $controller = new RespSoigneurController();
        break;
    case "respBoutiqueDashboard":
    case "statsBoutique":
    case "renderGraphiqueCA":
        $controller = new RespBoutiqueController();
        break;
    case 'profilAnimal':
    case 'ajouterParrainage':
    case 'supprimerParrainage':
        $controller = new ProfilAnimalController();
        break;
    case 'profilEnclos':
        $controller = new EnclosController();
        break;
    case 'search':
        $controller = new SearchController();
        break;
    case 'profilZone':
        $controller = new ProfilZone();
        break;
    case 'soigneursDashboard':
    case 'formAjoutSoin':
    case 'ajoutSoin':
    case 'formAjoutNourriture':
    case 'ajoutNourriture':
    case 'addNourriture':
    case 'listerSoins':
        $controller = new Soigneurs();
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

    case 'updatePassword':
        $controller->updatePassword();
        break;

    case 'adminDashboard':
        $controller->profilAdmin();
        break;

    case 'supprEmployee':
        $controller->supprEmployee($_GET['id']);
        break;

    case 'archiverEmployee':
        $controller->archiverEmployee($_GET['id']);
        break;

    case 'creationEmployee':
        $controller->formCreationEmployee();
        break;

    case 'ajoutEmployee':
        $controller->ajoutEmployee();
        break;

    case 'editionEmployee':
        $controller->formEditionEmployee($_GET['id']);
        break;

    case 'updateEmployee':
        $controller->majEmployee($_GET['id']);
        break;

    // Routes pour les boutiques
    case 'creationBoutique':
        $controller->formCreationBoutique();
        break;

    case 'ajoutBoutique':
        $controller->ajoutBoutique();
        break;

    case 'editionBoutique':
        $controller->formEditionBoutique($_GET['id']);
        break;

    case 'majBoutique':
        $controller->majBoutique($_GET['id']);
        break;

    case 'supprBoutique':
        $controller->supprBoutique($_GET['id']);
        break;

    // Routes pour les zones
    case 'creationZone':
        $controller->formCreationZone();
        break;

    case 'ajoutZone':
        $controller->ajoutZone();
        break;

    case 'editionZone':
        $controller->formEditionZone($_GET['id']);
        break;

    case 'majZone':
        $controller->majZone($_GET['id']);
        break;

    case 'supprZone':
        $controller->supprZone($_GET['id']);
        break;

    // Routes pour les animaux
    case 'creationAnimal':
        $controller->formCreationAnimal();
        break;

    case 'ajoutAnimal':
        $controller->ajoutAnimal();
        break;

    case 'editionAnimal':
        $controller->formEditionAnimal($_GET['id']);
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

    case 'respZoneDashboard':
        $controller->afficherPage();
        break;
    case 'respBoutiqueDashboard':
        $controller->afficherPage();
        break;
    case 'statsBoutique':
        $controller->afficherStatsBoutique();
        break;
    case 'renderGraphiqueCA':
        //$controller->renderGraphiqueCA();
        break;
    case 'profilAnimal':
        $controller->profilAnimal($_GET['id']);
        break;

    case 'ajouterParrainage':
        $controller->ajouterParrainage();
        break;

    case 'supprimerParrainage':
        $controller->supprimerParrainage();
        break;

    case 'soigneursDashboard':
        $controller->index();
        break;
    case 'formAjoutSoin':
        $controller->formCreationSoin();
        break;
    case 'ajoutSoin':
        $controller->ajoutSoin();
        break;
    case 'formAjoutNourriture':
        $controller->formCreationAjoutNourriture();
        break;
    case 'ajoutNourriture':
        $controller->ajoutNourriture();
        break;
    case 'listerSoins':
        $controller->listerSoins();
        break;
    case 'profilZone':
        $controller->profileZone($_GET['id']);
        break;

    case 'search':
        $controller->gererRequete();
        break;
        
    default:
        echo "Page introuvable";
}
