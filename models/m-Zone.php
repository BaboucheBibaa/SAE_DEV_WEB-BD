<?php
class Zone
{
    public function toutRecup()
    {
        /*Récupère toutes les zones du zoo
        */
        $db = Database::getConnection();
        $sql = "SELECT *
                FROM ZONE";
        $stid = oci_parse($db, $sql);
        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        $zones = [];
        oci_fetch_all($stid, $zones, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        return $zones;
    }

    public function recupZoneParEnclos($latitude, $longitude)
    {

        $db = Database::getConnection();
        $sql = "SELECT Z.ID_ZONE FROM ZONE Z, ENCLOS E WHERE Z.ID_ZONE = E.ID_ZONE AND LATITUDE = :latitude AND LONGITUDE = :longitude;";
        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ':latitude', $latitude);
        oci_bind_by_name($stid, ':longitude', $longitude);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        return oci_fetch($stid);
    }

    public function recupNomManager($id_zone)
    {
        /*Récupère la zone dont l'employé est le manager
        */
        $db = Database::getConnection();
        $sql = "SELECT PERSONNEL.NOM, PERSONNEL.PRENOM
                FROM PERSONNEL
                JOIN ZONE ON PERSONNEL.ID_PERSONNEL = ZONE.ID_MANAGER
                WHERE ZONE.ID_ZONE = :id_zone";
        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ':id_zone', $id_zone);
        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        return oci_fetch_assoc($stid);
    }

    public function recupZoneDuManager($id_manager)
    {
        /*Récupère la zone dont l'employé est le manager
        */
        $db = Database::getConnection();
        $sql = "SELECT ZONE.NOM_ZONE, ZONE.ID_ZONE
                FROM ZONE
                WHERE ZONE.ID_MANAGER = :id_manager";
        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ':id_manager', $id_manager);
        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        return oci_fetch_assoc($stid);
    }

    /**
     * Récupère une zone par son ID
     */
    public function recupParID($id)
    {
        $db = Database::getConnection();
        $sql = "SELECT * FROM ZONE WHERE ID_ZONE = :id";
        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ':id', $id);
        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        return oci_fetch_assoc($stid);
    }

    /**
     * Crée une nouvelle zone
     */
    public function creer($data)
    {
        $db = Database::getConnection();
        $sql = "INSERT INTO ZONE (ID_ZONE, NOM_ZONE, ID_MANAGER) 
            VALUES ((SELECT NVL(MAX(ID_ZONE), 0) + 1 FROM ZONE), :nom_zone, :id_manager)";
        $stid = oci_parse($db, $sql);

        $nom_zone = $data['nom_zone'] ?? null;
        $id_manager = $data['id_manager'] ?? null;

        oci_bind_by_name($stid, ':nom_zone', $nom_zone);
        oci_bind_by_name($stid, ':id_manager', $id_manager);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        return $r;
    }

    /**
     * Met à jour une zone
     */
    public function maj($id, $data)
    {
        $db = Database::getConnection();
        $sql = 'UPDATE ZONE 
            SET NOM_ZONE = :nom_zone, ID_MANAGER = :id_manager
            WHERE ID_ZONE = :id';
        $stid = oci_parse($db, $sql);

        $nom_zone = $data['nom_zone'] ?? null;
        $id_manager = $data['id_manager'] ?? null;

        oci_bind_by_name($stid, ':nom_zone', $nom_zone);
        oci_bind_by_name($stid, ':id_manager', $id_manager);
        oci_bind_by_name($stid, ':id', $id);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        return $r;
    }

    /**
     * Supprime une zone
     */
    public function suppr($id)
    {
        $db = Database::getConnection();
        $sql = "DELETE FROM ZONE WHERE ID_ZONE = :id";
        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ':id', $id);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        return $r;
    }


    public function moteurRechercheRecup($searchTerm)
    {
        /* Récupère les zones correspondant au terme de recherche pour le moteur de recherche
         */
        $db = Database::getConnection();
        $sql = "SELECT ID_ZONE, NOM_ZONE FROM ZONE WHERE LOWER(NOM_ZONE) LIKE LOWER(:searchTerm)";
        $stid = oci_parse($db, $sql);
        $likeTerm = '%' . $searchTerm . '%';
        oci_bind_by_name($stid, ':searchTerm', $likeTerm);
        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        $zones = [];
        oci_fetch_all($stid, $zones, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        return $zones;
    }
}
