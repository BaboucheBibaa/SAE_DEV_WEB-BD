<?php

class Contrat {
    
    public static function recupContratsParPersonnel($idPersonnel)
    {
        $db = Database::getConnection();
        $sql = "SELECT C.*, P.NOM, P.PRENOM, PR.NOM_PRESTATAIRE 
                FROM CONTRAT C 
                JOIN PERSONNEL P ON C.ID_PERSONNEL = P.ID_PERSONNEL 
                JOIN PRESTATAIRE PR ON C.ID_PRESTATAIRE = PR.ID_PRESTATAIRE 
                WHERE C.ID_PERSONNEL = :idPersonnel 
                ORDER BY C.DATE_DEBUT_CONTRAT DESC";

        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ":idPersonnel", $idPersonnel);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        $result = [];
        oci_fetch_all($stid, $result,0,-1,OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        return $result;
    }

    public static function creer($data)
    {
        $db = Database::getConnection();
        $sql = "INSERT INTO CONTRAT (
                    DATE_DEBUT_CONTRAT,
                    DATE_FIN_CONTRAT,
                    ID_PERSONNEL,
                    ID_PRESTATAIRE,
                    NATURE_CONTRAT,
                    COUT_CONTRAT
                ) VALUES (
                    TO_DATE(:dateDebut, 'YYYY-MM-DD'),
                    TO_DATE(:dateFin, 'YYYY-MM-DD'),
                    :idPersonnel,
                    :idPrestataire,
                    :natureContrat,
                    :coutContrat
                )";

        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ":dateDebut", $data['DATE_DEBUT_CONTRAT']);
        oci_bind_by_name($stid, ":dateFin", $data['DATE_FIN_CONTRAT']);
        oci_bind_by_name($stid, ":idPersonnel", $data['ID_PERSONNEL']);
        oci_bind_by_name($stid, ":idPrestataire", $data['ID_PRESTATAIRE']);
        oci_bind_by_name($stid, ":natureContrat", $data['NATURE_CONTRAT']);
        oci_bind_by_name($stid, ":coutContrat", $data['COUT_CONTRAT']);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            return false;
        }
        return true;
    }

    public function majContrat($idContrat, $data)
    {
        $db = Database::getConnection();
        $sql = "UPDATE CONTRAT SET 
                    DATE_DEBUT_CONTRAT = TO_DATE(:dateDebut, 'YYYY-MM-DD'),
                    DATE_FIN_CONTRAT = TO_DATE(:dateFin, 'YYYY-MM-DD'),
                    ID_PERSONNEL = :idPersonnel,
                    ID_PRESTATAIRE = :idPrestataire,
                    NATURE_CONTRAT = :natureContrat,
                    COUT_CONTRAT = :coutContrat
                WHERE ID_CONTRAT = :idContrat";

        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ":dateDebut", $data['DATE_DEBUT_CONTRAT']);
        oci_bind_by_name($stid, ":dateFin", $data['DATE_FIN_CONTRAT']);
        oci_bind_by_name($stid, ":idPersonnel", $data['ID_PERSONNEL']);
        oci_bind_by_name($stid, ":idPrestataire", $data['ID_PRESTATAIRE']);
        oci_bind_by_name($stid, ":natureContrat", $data['NATURE_CONTRAT']);
        oci_bind_by_name($stid, ":coutContrat", $data['COUT_CONTRAT']);
        oci_bind_by_name($stid, ":idContrat", $idContrat);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            return false;
        }
        return true;
    }
}