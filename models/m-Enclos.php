<?php

class Enclos
{

    public function recupParCoordonnees($latitude, $longitude)
    {
        $db = Database::getConnection();
        $sql = "SELECT E.*,Z.NOM_ZONE FROM ENCLOS E LEFT JOIN ZONE Z ON E.ID_ZONE = Z.ID_ZONE WHERE E.LATITUDE = :latitude AND E.LONGITUDE = :longitude";
        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ':latitude', $latitude);
        oci_bind_by_name($stid, ':longitude', $longitude);
        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        return oci_fetch_assoc($stid);
    }
    public function recupEnclosZone($id_zone)
    {
        /*Récupère les enclos dans la zone
        */
        $db = Database::getConnection();
        $sql = "SELECT Enclos.*
                FROM Enclos
                WHERE Enclos.ID_ZONE = :id_zone";
        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ':id_zone', $id_zone);
        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        $enclos = [];
        oci_fetch_all($stid, $enclos, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        return $enclos;
    }

    public function moteurRechercheRecup($searchTerm)
    {
        $db = Database::getConnection();

        $sql = "SELECT TYPE_ENCLOS FROM ENCLOS WHERE LOWER(TYPE_ENCLOS) LIKE LOWER(:searchTerm)";
        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ':searchTerm', $searchTerm);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        $result = [];
        oci_fetch_all($stid, $result, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        return $result;
    }
}
