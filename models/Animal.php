<?php
require_once 'config/database.php';

class Animal
{
    public static function recupParID($id)
    {
        $db = Database::getConnection();

        $query = "SELECT * FROM Animal WHERE ID_ANIMAL = :id_animal";
        $stid = oci_parse($db, $query);
        oci_bind_by_name($stid, ':id_animal', $id);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        return oci_fetch_assoc($stid);
    }

    public static function toutRecup()
    {
        $db = Database::getConnection();
        $sql = "SELECT * FROM Animal";
        $stid = oci_parse($db, $sql);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $result = [];
        //OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC sont des constantes qui définissent le comportement du tableau retourné dans $result
        //la première constante fait en sorte qu'elle soit sous la forme d'un seul tableau et la 2eme fait en sorte que les index soient associatifs (clé => valeur)
        oci_fetch_all($stid, $result, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        return $result;
    }

    public static function recupParZone($id_zone)
     {
         $db = Database::getConnection();

         $query = "SELECT * FROM Animal WHERE (LATITUDE_ENCLOS,LONGITUDE_ENCLOS) IN (SELECT LATITUDE,LONGITUDE FROM Enclos WHERE ID_ZONE = :id_zone)";
         $stid = oci_parse($db, $query);
         oci_bind_by_name($stid, ':id_zone', $id_zone);

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
