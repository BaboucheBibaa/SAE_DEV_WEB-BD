<?php
session_start();
require_once 'controllers/GestionProfil.php';
require_once 'controllers/GestionConnexion.php';
require_once 'controllers/GestionPagesAdmin.php';
//toutes les pages se chargeront par index.php via la méthode GET action, une seule page sera affichée
$action = $_GET['action'] ?? 'login';

$controller = new GestionConnexion();
$controller_admin = new GestionPagesAdmin();
$controller_profil = new GestionProfil();

switch ($action) {
    case 'login':
        $controller->showLogin();
        break;

    case 'loginPost':
        $controller->login();
        break;

    case 'logout':
        $controller->logout();
        break;

    case 'profil':
        $controller_profil->profile();
        break;

    case 'admin_dashboard':
        $controller_admin->admin_profile();
        break;
    
    case 'remove_employee':
        $controller_admin->remove_employee($id);
        header('Location: index.php?action=admin_dashboard');
        break;

    case 'create_employee':
        $controller_admin->create_employee();
        header('Location: index.php?action=create_employee');
        break;
    case 'add_employee':
        $controller_admin->add_employee();
        header('Location: index.php?action=admin_dashboard');
        break;
    case 'edit_employee':
        // Cette action n'est pas encore implémentée, mais elle pourrait être utilisée pour afficher un formulaire de modification d'employé
        break;

    default:
        echo "Page introuvable";
}
