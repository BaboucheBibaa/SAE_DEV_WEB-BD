<?php
class Zone extends BaseModel
{
    public function getAll()
    {
        $sql = "SELECT Z.*, P.NOM, P.PRENOM FROM ZONE Z LEFT JOIN PERSONNEL P ON Z.ID_MANAGER = P.ID_PERSONNEL";
        return $this->executeQueryAll($sql);
    }

    public function getParEnclos($latitude, $longitude)
    {
        $sql = "SELECT Z.ID_ZONE FROM ZONE Z, ENCLOS E WHERE Z.ID_ZONE = E.ID_ZONE AND LATITUDE = :latitude AND LONGITUDE = :longitude";
        return $this->executeQuery($sql, [':latitude' => $latitude, ':longitude' => $longitude]);
    }

    public function getNomManager($id_zone)
    {
        $sql = "SELECT PERSONNEL.NOM, PERSONNEL.PRENOM FROM PERSONNEL
                JOIN ZONE ON PERSONNEL.ID_PERSONNEL = ZONE.ID_MANAGER
                WHERE ZONE.ID_ZONE = :id_zone";
        return $this->executeQuery($sql, [':id_zone' => $id_zone]);
    }

    public function getZoneManager($id_manager)
    {
        $sql = "SELECT ZONE.NOM_ZONE, ZONE.ID_ZONE FROM ZONE WHERE ZONE.ID_MANAGER = :id_manager";
        return $this->executeQuery($sql, [':id_manager' => $id_manager]);
    }

    public function getParID($id)
    {
        $sql = "SELECT * FROM ZONE WHERE ID_ZONE = :id";
        return $this->executeQuery($sql, [':id' => $id]);
    }

    public function creer($data)
    {
        $sql = "INSERT INTO ZONE (ID_ZONE, NOM_ZONE, ID_MANAGER) 
            VALUES ((SELECT NVL(MAX(ID_ZONE), 0) + 1 FROM ZONE), :nom_zone, :id_manager)";
        return $this->executeModify($sql, [
            ':nom_zone' => $data['nom_zone'] ?? null,
            ':id_manager' => $data['id_manager'] ?? null
        ]);
    }

    public function maj($id, $data)
    {
        $sql = 'UPDATE ZONE SET NOM_ZONE = :nom_zone, ID_MANAGER = :id_manager WHERE ID_ZONE = :id';
        return $this->executeModify($sql, [
            ':nom_zone' => $data['nom_zone'] ?? null,
            ':id_manager' => $data['id_manager'] ?? null,
            ':id' => $id
        ]);
    }

    public function suppr($id)
    {
        $sql = "DELETE FROM ZONE WHERE ID_ZONE = :id";
        return $this->executeModify($sql, [':id' => $id]);
    }

    public function moteurRechercheRecup($searchTerm)
    {
        $sql = "SELECT ID_ZONE, NOM_ZONE FROM ZONE WHERE LOWER(NOM_ZONE) LIKE LOWER(:searchTerm)";
        return $this->executeQueryAll($sql, [':searchTerm' => '%' . $searchTerm . '%']);
    }
}
