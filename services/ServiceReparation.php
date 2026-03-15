<?php

class ServiceReparation
{
    public function getReparationsParEnclos($latitude, $longitude)
    {
        $reparations = Reparation::recupReparationsParEnclos($latitude, $longitude);
        if (!$reparations) {
            return null;
        }
        return $reparations;
    }
}