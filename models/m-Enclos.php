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
        $sql = "SELECT E.* FROM ENCLOS E WHERE LOWER(TYPE_ENCLOS) LIKE LOWER(:searchTerm)";
        return $this->executeQueryAll($sql, [':searchTerm' => '%' . $searchTerm . '%']);
    }

    /**
     * Crée un nouvel enclos
     * 
     * @param array $data Données de l'enclos (latitude, longitude, id_zone, type_enclos)
     * @return bool Succès de l'opération
     */
    public function creer($data)
    {
        $sql = "INSERT INTO ENCLOS (LATITUDE, LONGITUDE, ID_ZONE, TYPE_ENCLOS) 
                VALUES (:latitude, :longitude, :id_zone, :type_enclos)";
        return $this->executeModify($sql, [
            ':latitude' => $data['LATITUDE'],
            ':longitude' => $data['LONGITUDE'],
            ':id_zone' => $data['ID_ZONE'],
            ':type_enclos' => $data['TYPE_ENCLOS']
        ]);
    }

    /**
     * Met à jour un enclos existant
     * 
     * @param float $latitude Latitude de l'enclos
     * @param float $longitude Longitude de l'enclos
     * @param array $data Données à mettre à jour
     * @return bool Succès de l'opération
     */
    public function update($latitude, $longitude, $data)
    {
        $sql = "UPDATE ENCLOS 
                SET ID_ZONE = :id_zone, 
                    TYPE_ENCLOS = :type_enclos 
                WHERE LATITUDE = :latitude AND LONGITUDE = :longitude";
        return $this->executeModify($sql, [
            ':latitude' => $latitude,
            ':longitude' => $longitude,
            ':id_zone' => $data['ID_ZONE'],
            ':type_enclos' => $data['TYPE_ENCLOS']
        ]);
    }

    /**
     * Supprime un enclos
     * 
     * @param float $latitude Latitude de l'enclos
     * @param float $longitude Longitude de l'enclos
     * @return bool Succès de l'opération
     */
    public function suppr($latitude, $longitude)
    {
        $sql = "DELETE FROM ENCLOS WHERE LATITUDE = :latitude AND LONGITUDE = :longitude";
        return $this->executeModify($sql, [':latitude' => $latitude, ':longitude' => $longitude]);
    }

}
