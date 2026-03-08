<?php 


class EnclosController extends BaseController {

    public function profilEnclos($latitude, $longitude) {
        if ($latitude === null || $longitude === null) {
            $this->redirectWithMessage('home', 'Enclos non trouvé.', 'error');
        }

        $enclos = Enclos::recupParCoordonnees($latitude, $longitude);
        if (!$enclos) {
            $this->redirectWithMessage('home', 'Enclos non trouvé.', 'error');
        }
        $title = "Profil de l'enclos - Zoo'land";
        $this->render('enclos/v-profil', ['title' => $title, 'enclos' => $enclos]);
    }
}