<?php
class ContratTravail
{
    public static function recupParPersonnel($id_personnel)
    {
        $db = Database::getConnection();
        $query = "SELECT CT.*, F.NOM_FONCTION
                  FROM Contrat_Travail CT
                  JOIN Fonction F ON CT.ID_FONCTION = F.ID_FONCTION
                  WHERE CT.ID_PERSONNEL = :id_personnel
                  ORDER BY CT.DATE_DEBUT DESC";
        $stid = oci_parse($db, $query);
        oci_bind_by_name($stid, ':id_personnel', $id_personnel);

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