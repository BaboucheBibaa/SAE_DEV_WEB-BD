<?php
session_start();
require_once 'controllers/GestionProfil.php';
require_once 'controllers/GestionConnexion.php';
require_once 'controllers/GestionPagesAdmin.php';
//toutes les pages se chargeront par index.php via la méthode GET action, une seule page sera affichée
$action = $_GET['action'] ?? 'login';

$controller = new GestionConnexion();

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
        $controller = new GestionProfil();
        $controller->profile();
        break;
    case 'admin_dashboard':
        $controller = new GestionPagesAdmin();
        $controller->admin_profile();
        break;

    default:
        echo "Page introuvable";
}
