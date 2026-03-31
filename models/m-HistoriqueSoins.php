<?php
class HistoriqueSoins
{
    public function toutRecup()
    {
        $db = Database::getConnection();
        $sql = "SELECT * FROM EST_NOURRI";
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

    public function recupNourritureParPersonne($id_personnel)
    {
        $db = Database::getConnection();
        $sql = "SELECT * FROM EST_NOURRI WHERE ID_PERSONNEL = :id_personnel";
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

    public function recupNourritureParAnimal($id_animal): mixed
    {
        $db = Database::getConnection();
        $sql = "SELECT EN.*, P.NOM,P.PRENOM FROM EST_NOURRI EN JOIN PERSONNEL P ON EN.ID_PERSONNEL = P.ID_PERSONNEL WHERE EN.ID_ANIMAL = :id_animal ORDER BY EN.DATE_NOURRIT DESC";
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

    public function recupSoinsParAnimal($id_animal): mixed
    {
        $db = Database::getConnection();
        $sql = "SELECT S.*, P.NOM,P.PRENOM FROM SOIN S JOIN PERSONNEL P ON S.ID_Soigneur = P.ID_PERSONNEL WHERE S.ID_ANIMAL = :id_animal ORDER BY S.DATE_SOIN DESC";
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

    public function recupSoinsParPersonne($id_personnel): mixed
    {
        $db = Database::getConnection();
        $sql = "SELECT S.*, A.NOM_ANIMAL FROM SOIN S JOIN ANIMAL A ON S.ID_ANIMAL = A.ID_ANIMAL WHERE S.ID_Soigneur = :id_personnel ORDER BY S.DATE_SOIN DESC";
        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ":id_personnel", $id_personnel);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        $result = [];
        oci_fetch_all($stid, $result, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        return $result;
    }


    /**
     * Summary of creer
     * retourne 2 ou 1 en fonction de la réussite de l'insertion
     *
     */
    public function creer($data)
    {
        $db = Database::getConnection();
        $sql = "INSERT INTO SOIN (ID_SOIGNEUR, ID_VETERINAIRE,ID_ANIMAL, DATE_SOIN, DESCRIPTION_SOIN) VALUES (:id_personnel, :id_veterinaire, :id_animal, TO_DATE(:date_soin, 'YYYY-MM-DD'), :description_soin)";
        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ":id_personnel", $data['ID_PERSONNEL']);
        oci_bind_by_name($stid, ":id_veterinaire", $data['ID_VETERINAIRE']);
        oci_bind_by_name($stid, ":id_animal", $data['ID_ANIMAL']);
        oci_bind_by_name($stid, ":date_soin", $data['DATE_SOIN']);
        oci_bind_by_name($stid, ":description_soin", $data['DESCRIPTION_SOIN']);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            return 2;
        }
        return $r;
    }

    public function creerNourriture($data)
    {
        $db = Database::getConnection();
        $sql = "INSERT INTO EST_NOURRI (ID_ANIMAL, ID_PERSONNEL, DATE_NOURRIT, DOSE_NOURRITURE) VALUES (:id_animal, :id_personnel, TO_DATE(:date_nourrit, 'YYYY-MM-DD'), TO_NUMBER(:dose_nourriture, '9999.99'))";
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

    public function recupStatsSoigneurs()
    {
        //en cours de conception    
        return 0;
    }
}
