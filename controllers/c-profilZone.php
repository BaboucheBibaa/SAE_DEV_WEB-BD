<?php

class ProfilZone extends BaseController {

    private $serviceZone;
    private $serviceEnclos;

    public function __construct() {
        $this->serviceZone = new ServiceZone();
        $this->serviceEnclos = new ServiceEnclos();
    }

    public function profileZone($id_zone) {
        if ($id_zone === null) {
            $this->redirectWithMessage('home', 'Zone non trouvée.', 'error');
        }

        $zone = $this->serviceZone->getZoneParID($id_zone);
        if (!$zone) {
            $this->redirectWithMessage('home', 'Zone non trouvée.', 'error');
        }
        $enclos = $this->serviceEnclos->getEnclosParZone($id_zone);
        $title = "Profil de la zone - Zoo'land";
        $this->render('zone/v-profil', ['title' => $title, 'zone' => $zone, 'enclos' => $enclos]);
    }
}