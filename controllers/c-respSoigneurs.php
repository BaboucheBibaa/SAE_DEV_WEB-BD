<?php

class RespSoigneurController extends BaseController
{
    private $serviceEmployee;
    private $serviceZone;
    private $serviceAnimal;

    public function __construct()
    {
        $this->serviceEmployee = new ServiceEmployee();
        $this->serviceZone = new ServiceZone();
        $this->serviceAnimal = new ServiceAnimal();
    }

    private function checkRespSoig(): void
    {
        if (empty($_SESSION['user'])) {
            header('Location: index.php?action=afficheConnexion');
            exit;
        }
        if (!isset($_SESSION['user']['ID_FONCTION']) || $_SESSION['user']['ID_FONCTION'] != RESPSOIG) {
            header('Location: index.php?action=profil');
            exit;
        }
    }
    public function afficherPage()
    {
        $this->checkRespSoig();

        // Récupérer les informations de l'utilisateur connecté
        $user = User::recupParID($_SESSION['user']['ID_PERSONNEL']);
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
    }
}
