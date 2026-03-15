<?php

class RespSoigneurController extends BaseController
{
    private $serviceEmployee;
    private $serviceZone;
    private $serviceAnimal;
    private $serviceEnclos;

    public function __construct()
    {
        $this->serviceEmployee = new ServiceEmployee();
        $this->serviceZone = new ServiceZone();
        $this->serviceAnimal = new ServiceAnimal();
        $this->serviceEnclos = new ServiceEnclos();
    }

    public function afficherPage()
    {
        $this->requireRole(RESPSOIG);

        // Récupérer les informations de l'utilisateur connecté
        $user = $this->serviceEmployee->getEmployeeParID($_SESSION['user']['ID_PERSONNEL']);
        // Récupérer la zone dont l'utilisateur est le manager
        $zone = $this->serviceZone->getZoneDuManager($user['ID_PERSONNEL']);

        // Récupérer les employés de cette zone
        $employes = [];
        $enclos = [];
        $animaux = [];
        if ($zone) {
            $employes = $this->serviceEmployee->getTousEmployees(); // Ou une méthode spécifique pour récupérer le personnel d'une zone
            $enclos = $this->serviceEnclos->getEnclosParZone($zone['ID_ZONE']);
            $animaux = $this->serviceAnimal->getAnimauxParZone($zone['ID_ZONE']);
        }

        $title = "Dashboard Responsable de Zone";
        $this->render('respSoig/v-dashboard', [
            'user' => $user,
            'title' => $title,
            'zone' => $zone,
            'employes' => $employes,
            'enclos' => $enclos,
            'animaux' => $animaux
        ]);
    }
}
