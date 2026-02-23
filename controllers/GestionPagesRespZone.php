<?php
include 'models/Zone.php';
include 'models/Enclos.php';
include 'models/Animal.php';
class GestionPagesRespZone
{
    public function afficherPage()
    {
        // Vérifier si l'utilisateur est connecté
        if (empty($_SESSION['user'])) {
            header('Location: index.php?action=afficheConnexion');
            exit;
        }

        // Récupérer les informations de l'utilisateur connecté
        $user = User::recupParID($_SESSION['user']['ID_PERSONNEL']);
        // Vérifier si l'utilisateur a le rôle de responsable de zone
        if ($user && $user['ID_FONCTION'] == RESPSOIG) {
            // Récupérer la zone dont l'utilisateur est le manager
            $zone = Zone::recupZoneDuManager($user['ID_PERSONNEL']);
            
            // Récupérer les employés de cette zone
            $employes = [];
            $enclos = [];
            $animaux = [];
            if ($zone) {
                $employes = User::recupPersonnelDeZone($zone['ID_ZONE']);
                $enclos = Enclos::recupEnclosZone($zone['ID_ZONE']);
                $animaux = Animal::recupParZone($zone['ID_ZONE']);
            }

            $title = "Dashboard Responsable de Zone";
            $view = 'views/resp_zone/dashboard.php';
            require_once 'views/includes.php';
        } else {
            // Rediriger vers une page d'erreur ou d'accueil si l'utilisateur n'est pas autorisé
            header('Location: index.php');
            exit();
        }
    }
}