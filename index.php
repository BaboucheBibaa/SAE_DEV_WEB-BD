<?php
session_start();
require_once 'controllers/GestionProfil.php';
require_once 'controllers/GestionConnexion.php';
require_once 'controllers/GestionPagesAdmin.php';
//toutes les pages se chargeront par index.php via la méthode GET action, une seule page sera affichée
$action = $_GET['action'] ?? 'home';

$controller = new GestionConnexion();
$controller_admin = new GestionPagesAdmin();
$controller_profil = new GestionProfil();

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

    default:
        echo "Page introuvable";
}
