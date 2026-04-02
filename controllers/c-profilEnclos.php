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
    /**
     * Affiche le profil d'un enclos avec ses animaux et réparations
     *
     * @param float $latitude Latitude de l'enclos
     * @param float $longitude Longitude de l'enclos
     * @return void
     */
    public function profilEnclos(float $latitude, float $longitude): void {
        if ($latitude == null || $longitude == null) {
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