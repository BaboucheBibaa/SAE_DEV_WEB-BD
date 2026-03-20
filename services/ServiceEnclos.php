<?php

class ServiceEnclos
{
    private $Enclos;
    public function __construct()
    {
        $this->Enclos = new Enclos();
    }
    public function getEnclosParCoordonnees($latitude, $longitude)
    {
        $enclos = $this->Enclos->recupParCoordonnees($latitude, $longitude);
        if (!$enclos) {
            return null;
        }
        return $enclos;
    }

    public function getEnclosParZone($id_zone)
    {
        $enclos = $this->Enclos->recupEnclosZone($id_zone);
        if (!$enclos) {
            return null;
        }
        return $enclos;
    }
}