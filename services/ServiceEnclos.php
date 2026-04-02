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

    /**
     * Crée un nouvel enclos
     * @param array $data Données de l'enclos
     * @return bool Succès de l'opération
     */
    public function ajoutEnclos($data)
    {
        return $this->Enclos->creer($data);
    }

    /**
     * Met à jour un enclos
     * @param float $latitude Latitude
     * @param float $longitude Longitude
     * @param array $data Données à mettre à jour
     * @return bool Succès de l'opération
     */
    public function majEnclos($latitude, $longitude, $data)
    {
        return $this->Enclos->update($latitude, $longitude, $data);
    }

    /**
     * Supprime un enclos
     * @param float $latitude Latitude
     * @param float $longitude Longitude
     * @return bool Succès de l'opération
     */
    public function supprEnclos($latitude, $longitude)
    {
        return $this->Enclos->suppr($latitude, $longitude);
    }
}