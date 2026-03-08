<?php

class Reparation
{
    public static function recupReparationsParEnclos($latitude, $longitude)
    {
        $db = Database::getConnection();
        $sql = "SELECT R.*, P.NOM, P.PRENOM FROM REPARATION R JOIN PERSONNEL P ON R.ID_PERSONNEL = P.ID_PERSONNEL WHERE R.LATITUDE = :latitude AND R.LONGITUDE = :longitude ORDER BY R.DATE_REPARATION DESC";
        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ":latitude", $latitude);
        oci_bind_by_name($stid, ":longitude", $longitude);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        $result = [];
        oci_fetch_all($stid, $result);
        return $result;
    }
}

?>