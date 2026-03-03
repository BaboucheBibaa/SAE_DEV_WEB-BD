<?php

class RespSoigneurController extends BaseController
{
    public function afficherPage()
    {
        // Vérifier si l'utilisateur est connecté
        if (empty($_SESSION['user']) || !isset($_SESSION['user']['ID_FONCTION']) || $_SESSION['user']['ID_FONCTION'] != RESPSOIG) {
            $this->redirectWithMessage('afficheConnexion', 'Vous devez être connecté en tant que responsable soigneurs pour accéder à cette page.', 'error');
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
            $this->render('resp_zone/v-dashboard', [
                'user' => $user,
                'title' => $title,
                'zone' => $zone,
                'employes' => $employes,
                'enclos' => $enclos,
                'animaux' => $animaux
            ]);
        } else {
            // Rediriger vers une page d'erreur ou d'accueil si l'utilisateur n'est pas autorisé
            $this->redirectWithMessage('home', 'Vous n\'êtes pas autorisé à accéder à cette page.', 'error');
        }
    }
}