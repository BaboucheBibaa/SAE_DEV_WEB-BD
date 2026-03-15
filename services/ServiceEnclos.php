<?php

class ServiceEnclos
{
    public function getEnclosParCoordonnees($latitude, $longitude)
    {
        $enclos = Enclos::recupParCoordonnees($latitude, $longitude);
        if (!$enclos) {
            return null;
        }
        return $enclos;
    }

    public function getEnclosParZone($id_zone)
    {
        $enclos = Enclos::recupEnclosZone($id_zone);
        if (!$enclos) {
            return null;
        }
        return $enclos;
    }
}