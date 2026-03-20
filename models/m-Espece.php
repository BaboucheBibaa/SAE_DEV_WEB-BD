<?php
class Espece
{
    public function toutRecup()
    {
        $db = Database::getConnection();
        $sql = "SELECT * FROM Espece ORDER BY NOM_ESPECE";
        $stid = oci_parse($db, $sql);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $result = [];
        oci_fetch_all($stid, $result, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        return $result;
    }

    public function recupParID($id)
    {
        $db = Database::getConnection();

        $query = "SELECT * FROM Espece WHERE ID_ESPECE = :id_espece";
        $stid = oci_parse($db, $query);
        oci_bind_by_name($stid, ':id_espece', $id);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        return oci_fetch_assoc($stid);
    }



    public function moteurRechercheRecup($searchTerm)
    {
        $db = Database::getConnection();

        $sql = "SELECT * FROM ESPECE WHERE LOWER(NOM_ESPECE) LIKE LOWER(:searchTerm)";
        $stid = oci_parse($db, $sql);
        $likeTerm = '%' . $searchTerm . '%';
        oci_bind_by_name($stid, ':searchTerm', $likeTerm);

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
