<?php

class ServiceEnclos
{
    private $Enclos;
    public function __construct()
    {
        $this->Enclos = new Enclos();
    }

    /**
     * Récupère tous les enclos
     * @return array|null Tableau de tous les enclos ou null
     */
    public function getAll(){
        return $this->Enclos->getAll();
    }
    /**
     * Récupère un enclos par ses coordonnées GPS
     * @param float $latitude Latitude de l'enclos
     * @param float $longitude Longitude de l'enclos
     * @return array|null Données de l'enclos ou null
     */
    public function getEnclosParCoordonnees($latitude, $longitude)
    {
        $enclos = $this->Enclos->getParCoordonnees($latitude, $longitude);
        if (!$enclos) {
            return null;
        }
        return $enclos;
    }

    /**
     * Récupère tous les enclos d'une zone
     * @param int $id_zone ID de la zone
     * @return array|null Tableau des enclos de la zone ou null
     */
    public function getEnclosParZone($id_zone)
    {
        $enclos = $this->Enclos->getParZone($id_zone);
        if (!$enclos) {
            return null;
        }
        return $enclos;
    }
}