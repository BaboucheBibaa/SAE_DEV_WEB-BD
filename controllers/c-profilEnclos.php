<?php 


class EnclosController extends BaseController {
    private $serviceAnimal;
    private $serviceReparation;
    private $serviceEnclos;
    public function __construct() {
        $this->serviceAnimal = new ServiceAnimal();
        $this->serviceReparation = new ServiceReparation();
        $this->serviceEnclos = new ServiceEnclos();
    }
    public function profilEnclos($latitude, $longitude) {
        if ($latitude === null || $longitude === null) {
            $this->redirectWithMessage('home', 'Enclos non trouvé.', 'error');
        }

        $enclos = $this->serviceEnclos->getEnclosParCoordonnees($latitude, $longitude);
        if (!$enclos) {
            $this->redirectWithMessage('home', 'Enclos non trouvé.', 'error');
        }
        $reparations = $this->serviceReparation->getReparationsParEnclos($latitude, $longitude);
        $animaux= $this->serviceAnimal->getAnimalParCoordonnees($latitude, $longitude);
        $title = "Profil de l'enclos - Zoo'land";
        $this->render('enclos/v-profil', ['title' => $title, 'enclos' => $enclos, 'reparations' => $reparations, 'animaux' => $animaux]);
    }
}