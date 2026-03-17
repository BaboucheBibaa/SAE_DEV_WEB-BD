<?php

class ServiceReparation
{

    public function getReparationsParPersonnel($idPersonnel)
    {
        $reparations = Reparation::recupReparationParPersonnel($idPersonnel);
        if (!$reparations) {
            return null;
        }
        return $reparations;
    }
    public function getReparationsParEnclos($latitude, $longitude)
    {
        $reparations = Reparation::recupReparationsParEnclos($latitude, $longitude);
        if (!$reparations) {
            return null;
        }
        return $reparations;
    }

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

        return Reparation::creer($data);
    }
}