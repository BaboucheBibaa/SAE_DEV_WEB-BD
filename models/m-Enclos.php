<?php

class Enclos extends BaseModel
{
    public function getAll()
    {
        $sql = "SELECT E.*, Z.NOM_ZONE FROM Enclos E LEFT JOIN ZONE Z ON E.ID_ZONE = Z.ID_ZONE";
        return $this->executeQueryAll($sql);
    }

    public function getParCoordonnees($latitude, $longitude)
    {
        $sql = "SELECT E.*, Z.NOM_ZONE FROM ENCLOS E LEFT JOIN ZONE Z ON E.ID_ZONE = Z.ID_ZONE WHERE E.LATITUDE = :latitude AND E.LONGITUDE = :longitude";
        return $this->executeQuery($sql, [':latitude' => $latitude, ':longitude' => $longitude]);
    }

    public function getParZone($id_zone)
    {
        $sql = "SELECT Enclos.* FROM Enclos WHERE Enclos.ID_ZONE = :id_zone";
        return $this->executeQueryAll($sql, [':id_zone' => $id_zone]);
    }

    public function moteurRechercheRecup($searchTerm)
    {
        $sql = "SELECT TYPE_ENCLOS, LONGITUDE, LATITUDE FROM ENCLOS WHERE LOWER(TYPE_ENCLOS) LIKE LOWER(:searchTerm)";
        return $this->executeQueryAll($sql, [':searchTerm' => '%' . $searchTerm . '%']);
    }
}
