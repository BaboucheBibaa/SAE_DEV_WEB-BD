<?php

class Parrainage
{
    public static function toutRecup()
    {
        /*Récupère tous les parrainages
        */
        $db = Database::getConnection();
        $sql = "SELECT *
                FROM Parrainage";
        $stid = oci_parse($db, $sql);
        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        $parrainages = [];
        oci_fetch_all($stid, $parrainages, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        return $parrainages;
    }

    public static function recupParAnimal($id_animal){
        $db = Database::getConnection();
        $sql = "SELECT V.ID_Visiteur, V.NOM_Visiteur, P.Niveau FROM Visiteur V, Parrainage P, Est_Parraine ep WHERE ep.ID_Visiteur = V.ID_Visiteur AND V.ID_Parrainage = P.ID_Parrainage AND ep.ID_ANIMAL = :id_animal";
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

    public static function recupTousVisiteurs()
    {
        $db = Database::getConnection();
        $sql = "SELECT ID_Visiteur, NOM_Visiteur, ID_Parrainage FROM Visiteur ORDER BY NOM_Visiteur";
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

    public static function creerParrainage($id_animal, $id_visiteur, $id_parrainage)
    {
        $db = Database::getConnection();
        
        // 1. Mettre à jour le visiteur avec le niveau de parrainage
        $sql_update = "UPDATE Visiteur SET ID_Parrainage = :id_parrainage WHERE ID_Visiteur = :id_visiteur";
        $stid_update = oci_parse($db, $sql_update);
        oci_bind_by_name($stid_update, ":id_parrainage", $id_parrainage);
        oci_bind_by_name($stid_update, ":id_visiteur", $id_visiteur);
        
        $r_update = oci_execute($stid_update);
        if (!$r_update) {
            return false;
        }
        
        // 2. Créer la relation Est_Parraine
        $sql = "INSERT INTO Est_Parraine (ID_Animal, ID_Visiteur) VALUES (:id_animal, :id_visiteur)";
        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ":id_animal", $id_animal);
        oci_bind_by_name($stid, ":id_visiteur", $id_visiteur);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        return $r;
    }

    public static function supprimerParrainage($id_animal, $id_visiteur)
    {
        $db = Database::getConnection();
        $sql = "DELETE FROM Est_Parraine WHERE ID_Animal = :id_animal AND ID_Visiteur = :id_visiteur";
        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ":id_animal", $id_animal);
        oci_bind_by_name($stid, ":id_visiteur", $id_visiteur);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        return $r;
    }
}