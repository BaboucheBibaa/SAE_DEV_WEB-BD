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
        oci_fetch_all($stid, $result, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
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
        oci_fetch_all($stid, $result, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
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
        oci_fetch_all($stid, $result, 0,-1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        return $result;
    }

    public static function recupSoinsParPersonne($id_personnel): mixed
    {
        $db = Database::getConnection();
        $sql = "SELECT PS.*, A.NOM_ANIMAL FROM PRATIQUE_SOINS PS JOIN ANIMAL A ON PS.ID_ANIMAL = A.ID_ANIMAL WHERE PS.ID_PERSONNEL = :id_personnel ORDER BY PS.DATE_SOIN DESC";
        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ":id_personnel", $id_personnel);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        $result = [];
        oci_fetch_all($stid, $result, 0,-1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        return $result;
    }
    
    public static function creer($data){
        $db = Database::getConnection();
        $sql = "INSERT INTO PRATIQUE_SOINS (ID_PERSONNEL, ID_ANIMAL, DATE_SOIN, DESCRIPTION_SOIN) VALUES (:id_personnel, :id_animal, TO_DATE(:date_soin, 'YYYY-MM-DD'), :description_soin)";
        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ":id_personnel", $data['ID_PERSONNEL']);
        oci_bind_by_name($stid, ":id_animal", $data['ID_ANIMAL']);
        oci_bind_by_name($stid, ":date_soin", $data['DATE_SOIN']);
        oci_bind_by_name($stid, ":description_soin", $data['DESCRIPTION_SOIN']);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        return $r;
    }

    public static function creerNourriture($data){
        $db = Database::getConnection();
        $sql = "INSERT INTO BIEN_ETRE_QUOTIDIEN (ID_ANIMAL, ID_PERSONNEL, DATE_NOURRIT, DOSE_NOURRITURE) VALUES (:id_animal, :id_personnel, TO_DATE(:date_nourrit, 'YYYY-MM-DD'), TO_NUMBER(:dose_nourriture, '9999.99'))";
        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ":id_animal", $data['ID_ANIMAL']);
        oci_bind_by_name($stid, ":id_personnel", $data['ID_PERSONNEL']);
        oci_bind_by_name($stid, ":date_nourrit", $data['DATE_NOURRIT']);
        oci_bind_by_name($stid, ":dose_nourriture", $data['DOSE_NOURRITURE']);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        return $r;
    }
}
