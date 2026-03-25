<?php

class Parrainage
{
    public function toutRecup()
    {
        //Récupère tous les parrainages
        $db = Database::getConnection();
        $sql = "SELECT ep.*, V.NOM_Visiteur, A.NOM_Animal FROM Animal A, Visiteur V, Est_Parraine ep WHERE ep.ID_Visiteur = V.ID_Visiteur AND ep.ID_ANIMAL = A.ID_Animal ORDER BY ep.ID_ANIMAL, ep.ID_Visiteur";
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

    public function recupParAnimal($id_animal){
        $db = Database::getConnection();
        $sql = "SELECT V.ID_Visiteur, V.NOM_Visiteur,ep.LIBELLE LIBELLE FROM Visiteur V, Est_Parraine ep WHERE ep.ID_Visiteur = V.ID_Visiteur AND ep.ID_ANIMAL = :id_animal";
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

    public function recupTousVisiteurs()
    {
        $db = Database::getConnection();
        $sql = "SELECT * FROM Visiteur ORDER BY NOM_Visiteur";
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

    public function recupLibelleParrainages(){
        $db = Database::getConnection();
        $sql = "SELECT DISTINCT LIBELLE FROM Est_Parraine";
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
    public function creerParrainage($data)
    {
        //
        $db = Database::getConnection();

        $sql = "INSERT INTO Est_Parraine (ID_Animal, ID_Visiteur, Libelle) VALUES (:id_animal, :id_visiteur, :libelle)";
        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ":id_animal", $data['id_animal']);
        oci_bind_by_name($stid, ":id_visiteur", $data['id_visiteur']);
        oci_bind_by_name($stid, ":libelle", $data['libelle']);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        return $r;
    }

    public function supprimerParrainage($id_animal, $id_visiteur)
    {
        //Supprime un parrainage entre un animal et un visiteur 
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