<?php
require_once 'config/database.php';

class Animal
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

    public static function recupSoinsParPersonne($id_personnel)
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

    public static function recupSoinsParAnimal($id_animal)
    {
        $db = Database::getConnection();
        $sql = "SELECT * FROM BIEN_ETRE_QUOTIDIEN WHERE ID_ANIMAL = :id_animal";
        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ":id_animal", $id_animal);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        $result = oci_fetch_assoc($stid);
        return $result;
    }
}
