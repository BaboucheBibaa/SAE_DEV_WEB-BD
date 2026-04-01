<?php

class ServiceReparation
{
    private $Reparation;
    public function __construct()
    {
        $this->Reparation = new Reparation();
    }

    /**
     * Récupère toutes les réparations/entretiens enregistrés
     * @return array|null Tableau de toutes les réparations ou null
     */
    public function getAll(){
        return $this->Reparation->getAll();
    }

    /**
     * Récupère les réparations effectuées par un member du personnel
     * @param int $idPersonnel ID du member du personnel
     * @return array|null Tableau des réparations ou null
     */
    public function getReparationsParPersonnel($idPersonnel)
    {
        $reparations = $this->Reparation->getParPersonnel($idPersonnel);
        if (!$reparations) {
            return null;
        }
        return $reparations;
    }
    /**
     * Récupère les réparations d'un enclos par ses coordonnées GPS
     * @param float $latitude Latitude de l'enclos
     * @param float $longitude Longitude de l'enclos
     * @return array|null Tableau des réparations ou null
     */
    public function getReparationsParEnclos($latitude, $longitude)
    {
        $reparations = $this->Reparation->getParEnclos($latitude, $longitude);
        if (!$reparations) {
            return null;
        }
        return $reparations;
    }

    /**
     * Ajoute une nouvelle réparation/entretien
     * Vérifie les données POST et crée l'enregistrement
     * @return bool|null Résultat de la création
     */
    public function ajoutEntretien()
    {
        $dateDebut = $_POST['DATE_DEBUT_REPARATION'] ?? null;
        $latitude = isset($_POST['LATITUDE_ENCLOS']) && $_POST['LATITUDE_ENCLOS'] !== '' ? floatval($_POST['LATITUDE_ENCLOS']) : null;
        $longitude = isset($_POST['LONGITUDE_ENCLOS']) && $_POST['LONGITUDE_ENCLOS'] !== '' ? floatval($_POST['LONGITUDE_ENCLOS']) : null;
        $idPersonnel = $_SESSION['user']['ID_PERSONNEL'] ?? null;

        if (!$dateDebut || $latitude === null || $longitude === null || !$idPersonnel) {
            return null;
        }

        $data = [
            'DATE_DEBUT_REPARATION' => $dateDebut,
            'LATITUDE_ENCLOS' => $latitude,
            'LONGITUDE_ENCLOS' => $longitude,
            'ID_PERSONNEL' => intval($idPersonnel),
            'ID_PRESTATAIRE' => $_POST['ID_PRESTATAIRE'] ?? '',
            'DATE_FIN' => $_POST['DATE_FIN'] ?? '',
            'NATURE_REPARATION' => $_POST['NATURE_REPARATION'] ?? '',
            'COUT_REPARATION' => $_POST['COUT_REPARATION'] ?? ''
        ];

        return $this->Reparation->creer($data);
    }
}