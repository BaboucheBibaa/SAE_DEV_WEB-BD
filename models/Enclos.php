<?php 

class Enclos
{
    public static function recupEnclosZone($id_zone)
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
}

?>