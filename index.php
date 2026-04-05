<?php
define("ADMINID", 1);
define("RESPSOIG", 2);
define("SOIGNEUR", 3);
define("RESPBOUTIQUE", 4);
define("EMPLOYEE_BOUTIQUE", 5);
define("ENTRETIEN", 6);
define("COMPTABLE", 7);
define("VETERINAIRE", 8);

session_start();

require_once 'myparams.inc.php';

require_once 'config/database.php';

require_once 'models/BaseModel.php';

require_once 'models/m-Prestataire.php';
require_once 'models/m-Parrainage.php';
require_once 'models/m-Compatibilite.php';
require_once 'models/m-Enclos.php';
require_once 'models/m-Reparation.php';
require_once 'models/m-Soin.php';
require_once 'models/m-Nourriture.php';
require_once 'models/m-Fonction.php';
require_once 'models/m-Boutique.php';
require_once 'models/m-Animal.php';
require_once 'models/m-Espece.php';
require_once 'models/m-Enclos.php';
require_once 'models/m-User.php';
require_once 'models/m-Zone.php';
require_once 'models/m-ContratTravail.php';
require_once 'models/m-CA.php';
require_once 'models/m-LogWriter.php';
require_once 'models/m-Comptable.php';
require_once 'models/m-AffectationBoutique.php';
require_once 'models/m-AffectationZone.php';

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
require_once 'services/ServiceEspece.php';
require_once 'services/ServiceCompatibilite.php';
require_once 'services/ServiceComptable.php';
require_once 'services/ServiceAffectationBoutique.php';
require_once 'services/ServiceAffectationZone.php';

require_once 'controllers/c-base.php';
require_once 'controllers/c-soigneurs.php';
require_once 'controllers/c-profil.php';
require_once 'controllers/c-connexion.php';
require_once 'controllers/c-respSoigneurs.php';
require_once 'controllers/c-respBoutique.php';
require_once 'controllers/c-profilAnimal.php';
require_once 'controllers/c-profilEnclos.php';
require_once 'controllers/c-profilAdmin.php';
require_once 'controllers/c-search.php';
require_once 'controllers/c-profilZone.php';
require_once 'controllers/c-personnelEntretien.php';
require_once 'controllers/c-profilBoutique.php';
require_once 'controllers/c-profilPrestataire.php';
require_once 'controllers/c-espece.php';
require_once 'controllers/c-comptable.php';

if (!file_exists('logs.txt')) {
    touch('logs.txt');
}

//toutes les pages se chargeront par index.php via la méthode GET action, une seule page sera affichée
$action = $_GET['action'] ?? 'home';

// On instancie UNIQUEMENT les contrôleurs nécessaires au fonctionnement de la page demandée par GET.
switch ($action) {
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
    case 'profilEspece':
        $controller = new EspeceController();
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
    case 'supprimerCA':
    case 'supprimerSoin':
    case 'supprimerNourriture':
    case 'supprimerEspece':
    case 'formCreationEspece':
    case 'ajoutEspece':
    case 'formEditionEspece':
    case 'updateEspece':
    case 'formCreationCompatibilite':
    case 'ajoutCompatibilite':
    case 'supprCompatibilite':
    case 'creationPrestataire':
    case 'ajoutPrestataire':
    case 'editionPrestataire':
    case 'updatePrestataire':
    case 'supprPrestataire':
    case 'creationEnclos':
    case 'ajoutEnclos':
    case 'editionEnclos':
    case 'majEnclos':
    case 'supprEnclos':
    case 'supprContrat':
    case 'supprReparation':
    case 'modifReparation':
    case 'formEditionReparation':
    case 'updateReparation':
    case 'creationTravauxBoutique':
    case 'ajoutTravauxBoutique':
    case 'supprTravauxBoutique':
    case 'creationAffectationZone':
    case 'ajoutAffectationZone':
    case 'supprAffectationZone':
        $controller = new AdminController();
        break;
    case 'respZoneDashboard':
        $controller = new RespSoigneurController();
        break;
    case "respBoutiqueDashboard":
    case "statsBoutique":
    case "renderGraphiqueCA":
    case 'creationCA':
    case 'ajoutCA':
        $controller = new RespBoutiqueController();
        break;
    case 'profilAnimal':
    case 'ajouterParrainage':
    case 'supprimerParrainage':
    case 'creationParente':
    case 'ajouterParente':
    case 'supprimerParente':
        $controller = new ProfilAnimalController();
        break;
    case 'profilEnclos':
        $controller = new EnclosController();
        break;
    case 'search':
        $controller = new SearchController();
        break;
    case 'profilZone':
        $controller = new ProfilZoneController();
        break;
    case 'soigneursDashboard':
    case 'formAjoutSoin':
    case 'ajoutSoin':
    case 'formAjoutNourriture':
    case 'ajoutNourriture':
    case 'addNourriture':
    case 'listerSoins':
    case 'statsSoigneurs':
        $controller = new SoigneursController();
        break;
    case 'personnelEntretienDashboard':
    case 'formAjoutEntretien':
    case 'ajoutEntretien':
    case 'listerEntretiens':
    case 'supprimerEntretien':
        $controller = new PersonnelEntretienController();
        break;
    case 'profilBoutique':
        $controller = new BoutiqueProfilController();
        break;
    case 'profilPrestataire':
        $controller = new ProfilPrestaireController();
        break;
    case 'comptableDashboard':
    case 'statsBoutiques':
    case 'statsZones':
    case 'statsMasseSalariale':
        $controller = new ComptableController();
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

    case 'supprimerCA':
        $controller->supprCA($_GET['idBoutique'], urldecode($_GET['date']));
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

    case 'ajouterParente':
        $controller->ajouterParente();
        break;

    case 'supprimerParente':
        $controller->supprimerParente();
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
    case 'personnelEntretienDashboard':
        $controller->dashboard();
        break;
    case 'formAjoutEntretien':
        $controller->formAjoutEntretien();
        break;
    case 'ajoutEntretien':
        $controller->ajoutEntretien();
        break;
    case 'listerEntretiens':
        $controller->listerEntretiens();
        break;
    case 'profilZone':
        $controller->profileZone($_GET['id']);
        break;
    case 'creationCA':
        $controller->afficherFormCA();
        break;
    case 'ajoutCA':
        $controller->ajoutCA();
        break;
    case 'profilBoutique':
        $controller->profilBoutique($_GET['id']);
        break;

    case 'profilPrestataire':
        $controller->profilPrestataire($_GET['id']);
        break;

    case 'supprimerSoin':
        $controller->supprSoin($_GET['idAnimal'], urldecode($_GET['dateSoin']));
        break;
    case 'supprimerNourriture':
        $controller->supprNourriture($_GET['idAnimal'], $_GET['idSoigneur'], urldecode($_GET['dateNourrit']));
        break;
    case 'supprimerEspece':
        $controller->supprEspece($_GET['id']);
        break;
    case 'formCreationEspece':
        $controller->formCreationEspece();
        break;
    case 'ajoutEspece':
        $controller->ajoutEspece();
        break;
    case 'formEditionEspece':
        $controller->formEditionEspece($_GET['id']);
        break;
    case 'updateEspece':
        $controller->updateEspece($_GET['id']);
        break;
    case 'formCreationCompatibilite':
        $controller->formCreationCompatibilite();
        break;
    case 'ajoutCompatibilite':
        $controller->ajoutCompatibilite();
        break;
    case 'supprCompatibilite':
        $controller->supprCompatibilite();
        break;
    case 'profilEspece':
        $controller->profilEspece($_GET['id']);
        break;
    case 'creationPrestataire':
        $controller->formCreationPrestataire();
        break;
    case 'ajoutPrestataire':
        $controller->ajoutPrestataire();
        break;
    case 'editionPrestataire':
        $controller->formEditionPrestataire($_GET['id']);
        break;
    case 'updatePrestataire':
        $controller->majPrestataire($_GET['id']);
        break;
    case 'supprPrestataire':
        $controller->supprPrestataire($_GET['id']);
        break;

    case 'supprContrat':
        $controller->supprContrat($_GET['id']);
        break;

    case 'creationTravauxBoutique':
        $controller->formCreationEmployeeBoutique();
        break;
    case 'ajoutTravauxBoutique':
        $controller->ajoutTravauxBoutique();
        break;
    case 'supprTravauxBoutique':
        $controller->supprTravauxBoutique($_GET['id_boutique'], $_GET['id_personnel']);
        break;

    case 'creationAffectationZone':
        $controller->formCreationAffectationZone();
        break;
    case 'ajoutAffectationZone':
        $controller->ajoutAffectationZone();
        break;
    case 'supprAffectationZone':
        $controller->supprAffectationZone($_GET['id_zone'], $_GET['id_personnel']);
        break;

    case 'creationParente':
        $controller->creationParente();
        break;

    case 'modifReparation':
        $controller->formEditionReparation(urldecode($_GET['dateReparation']), $_GET['latitude'], $_GET['longitude']);
    case 'creationEnclos':
        $controller->formCreationEnclos();
        break;
    case 'ajoutEnclos':
        $controller->ajoutEnclos();
        break;
    case 'editionEnclos':
        $controller->formEditionEnclos();
        break;
    case 'majEnclos':
        $controller->majEnclos();
        break;
    case 'supprEnclos':
        $controller->supprEnclos();
        break;
    case 'supprReparation':
        $controller->supprReparation(urldecode($_GET['dateReparation']), $_GET['longitude'], $_GET['latitude']);
        break;
    case 'formEditionReparation':
        $controller->formEditionReparation(urldecode($_GET['date_debut']), $_GET['latitude'], $_GET['longitude']);
        break;
    case 'updateReparation':
        $controller->updateReparation();
        break;

    case 'comptableDashboard':
        $controller->dashboard();
        break;
    case 'statsBoutiques':
        $controller->statsBoutiques();
        break;
    case 'statsZones':
        $controller->statsZones();
        break;
    case 'statsMasseSalariale':
        $controller->statsMasseSalariale();
        break;

    case 'search':
        $controller->gererRequete();
        break;

    default:
        echo "Page introuvable";
}
