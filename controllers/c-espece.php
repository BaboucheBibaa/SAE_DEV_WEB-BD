<?php

class EspeceController extends BaseController {
    private $serviceEspece;

    public function __construct()
    {
        $this->serviceEspece = new ServiceEspece();
    }

    /**
     * Affiche le profil d'une espèce avec ses animaux et espèces compatibles
     *
     * @param int $id Identifiant de l'espèce
     * @return void
     */
    public function profilEspece(int $id): void
    {
        if ($id == null) {
            $this->redirectWithMessage('home', 'Espèce non trouvée.', 'error');
        }

        $espece = $this->serviceEspece->getParID($id);
        if (!$espece) {
            $this->redirectWithMessage('home', 'Espèce non trouvée.', 'error');
        }

        $especesCompatibles = $this->serviceEspece->getEspecesCompatibles($id);
        $animaux = $this->serviceEspece->getAnimauxParEspece($id);

        $title = "Profil de {$espece['NOM_ESPECE']} - Zoo'land";
        $this->render('espece/v-profil', [
            'title' => $title,
            'espece' => $espece,
            'especesCompatibles' => $especesCompatibles,
            'animaux' => $animaux
        ]);
    }
}