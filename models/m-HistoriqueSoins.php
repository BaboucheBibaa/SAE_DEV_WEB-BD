<?php
class HistoriqueSoins
{

    public static function toutRecup()
    {
        $db = Database::getConnection();
        $sql = "SELECT * FROM BIEN_ETRE_QUOTIDIEN";
        $stid = oci_parse($db, $sql);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        $result = [];
        oci_fetch_all($stid, $result);
        return $result;
    }

    public static function recupNourritureParPersonne($id_personnel)
    {
        $db = Database::getConnection();
        $sql = "SELECT * FROM BIEN_ETRE_QUOTIDIEN WHERE ID_PERSONNEL = :id_personnel";
        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ":id_personnel", $id_personnel);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $result = oci_fetch_assoc($stid);
        return $result;
    }

    public static function recupNourritureParAnimal($id_animal): mixed
    {
        $db = Database::getConnection();
        $sql = "SELECT B.*, P.NOM,P.PRENOM FROM BIEN_ETRE_QUOTIDIEN B JOIN PERSONNEL P ON B.ID_PERSONNEL = P.ID_PERSONNEL WHERE B.ID_ANIMAL = :id_animal ORDER BY B.DATE_NOURRIT DESC";
        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ":id_animal", $id_animal);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        $result = [];
        oci_fetch_all($stid, $result);
        return $result;
    }

    public static function recupSoinsParAnimal($id_animal): mixed
    {
        $db = Database::getConnection();
        $sql = "SELECT PS.*, P.NOM,P.PRENOM FROM PRATIQUE_SOINS PS JOIN PERSONNEL P ON PS.ID_PERSONNEL = P.ID_PERSONNEL WHERE PS.ID_ANIMAL = :id_animal ORDER BY PS.DATE_SOIN DESC";
        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ":id_animal", $id_animal);

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
