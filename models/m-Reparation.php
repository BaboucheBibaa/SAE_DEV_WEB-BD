<?php

class Reparation
{
    public static function recupReparationsParEnclos($latitude, $longitude)
    {
        $db = Database::getConnection();
        $sql = "SELECT R.*, P.NOM, P.PRENOM,PR.NOM_PRESTATAIRE FROM REPARATION R JOIN PERSONNEL P ON R.ID_PERSONNEL = P.ID_PERSONNEL JOIN PRESTATAIRE PR ON R.ID_PRESTATAIRE = PR.ID_PRESTATAIRE WHERE R.LATITUDE_ENCLOS = :latitude AND R.LONGITUDE_ENCLOS = :longitude ORDER BY R.DATE_DEBUT_REPARATION DESC";
        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ":latitude", $latitude);
        oci_bind_by_name($stid, ":longitude", $longitude);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        $result = [];
        oci_fetch_all($stid, $result,0,-1,OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        return $result;
    }
}

?>