<?php

class CA
{
    public function existeCA($idBoutique, $date)
    {
        //Vérifie si un CA existe déjà pour une boutique à une date donnée afin d'éviter les doublons et les erreurs de saisie
        $db = Database::getConnection();

        $sql = "SELECT COUNT(*) AS NB FROM CHIFFRE_AFFAIRES WHERE ID_BOUTIQUE = :id_boutique AND DATE_CA_JOURNALIER = TO_DATE(:date_jour, 'YYYY-MM-DD')";

        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ':id_boutique', $idBoutique);
        oci_bind_by_name($stid, ':date_jour', $date);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $row = oci_fetch_assoc($stid);
        return isset($row['NB']) && (int) $row['NB'] > 0;
    }

    public function getCAJournee($idBoutique)
    {
        //Quel est le CA du jour pour une boutique donnée ? (CA journalier)
        $db = Database::getConnection();

        $sql = "SELECT MONTANT AS total_ca FROM CHIFFRE_AFFAIRES WHERE ID_BOUTIQUE = :id_boutique AND DATE_CA_JOURNALIER = TRUNC(SYSDATE)";

        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ':id_boutique', $idBoutique);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        return oci_fetch_assoc($stid);
    }

    public function getCAMensuel($idBoutique)
    {
        //Quel est le CA du mois en cours pour une boutique donnée ? (CA mensuel)
        $db = Database::getConnection();

        $sql = "SELECT SUM(MONTANT) AS total_ca FROM CHIFFRE_AFFAIRES WHERE ID_BOUTIQUE = :id_boutique AND EXTRACT(MONTH FROM DATE_CA_JOURNALIER) = EXTRACT(MONTH FROM SYSDATE) AND EXTRACT(YEAR FROM DATE_CA_JOURNALIER) = EXTRACT(YEAR FROM SYSDATE)";

        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ':id_boutique', $idBoutique);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        return oci_fetch_assoc($stid);
    }
    public function getCASeriesByBoutique($idBoutique, $annee = null)
    {
        //On liste, par année ou non, tous les CA d'une boutique (utile dans un potentiel affichage graphique non implémenté pour l'instant)
        $db = Database::getConnection();

        $sql = "SELECT DATE_CA_JOURNALIER AS DATE_CA, MONTANT AS TOTAL_CA FROM CHIFFRE_AFFAIRES WHERE ID_BOUTIQUE = :id_boutique";
        if ($annee) {
            $sql .= " AND EXTRACT(YEAR FROM DATE_CA_JOURNALIER) = :annee";
        }
        $sql .= " ORDER BY DATE_CA_JOURNALIER ASC";

        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ':id_boutique', $idBoutique);
        if ($annee) {
            oci_bind_by_name($stid, ':annee', $annee);
        }

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $result = [];
        oci_fetch_all($stid, $result, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        return $result;
    }

    public function getCAByBoutique($idBoutique, $annee = null)
    {
        //Par année ou non, on liste tous les CA d'une boutique. (utile pour de l'affichage de graphiques)
        $db = Database::getConnection();

        $sql = "SELECT MONTANT AS total_ca, DATE_CA_JOURNALIER as DATE_CA FROM CHIFFRE_AFFAIRES WHERE ID_BOUTIQUE = :id_boutique";
        if ($annee) {
            $sql .= " AND EXTRACT(YEAR FROM DATE_CA_JOURNALIER) = :annee";
        }
        $sql .= " ORDER BY DATE_CA_JOURNALIER DESC";

        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ':id_boutique', $idBoutique);
        if ($annee) {
            oci_bind_by_name($stid, ':annee', $annee);
        }

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        return oci_fetch_assoc($stid);
    }
    public function sommeCA($idBoutique, $annee = null)
    {
        //Par année ou non, quel est le CA total d'une boutique ?
        $db = Database::getConnection();

        $sql = "SELECT SUM(MONTANT) AS total_ca FROM CHIFFRE_AFFAIRES WHERE ID_BOUTIQUE = :id_boutique";
        if ($annee) {
            $sql .= " AND EXTRACT(YEAR FROM DATE_CA_JOURNALIER) = :annee";
        }

        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ':id_boutique', $idBoutique);
        if ($annee) {
            oci_bind_by_name($stid, ':annee', $annee);
        }

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        return oci_fetch_assoc($stid);
    }
    public function moyenneCA($idBoutique, $annee = null)
    {
        //Par année ou non, quel est le CA moyen d'une boutique ?
        $db = Database::getConnection();

        $sql = "SELECT ROUND(AVG(MONTANT), 2) AS moyenne_ca FROM CHIFFRE_AFFAIRES";
        if ($annee) {
            $sql .= " WHERE EXTRACT(YEAR FROM DATE_CA_JOURNALIER) = :annee";
        }
        $sql.= " GROUP BY ID_BOUTIQUE HAVING ID_BOUTIQUE = :id_boutique";

        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ':id_boutique', $idBoutique);
        if ($annee) {
            oci_bind_by_name($stid, ':annee', $annee);
        }

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        return oci_fetch_assoc($stid);
    }
    public function minMaxCA($idBoutique, $annee = null)
    {
        //Par année ou non, quel est le CA minimum et maximum d'une boutique ?
        $db = Database::getConnection();

        $sql = "SELECT MIN(MONTANT) AS min_ca, MAX(MONTANT) AS max_ca FROM CHIFFRE_AFFAIRES WHERE ID_BOUTIQUE = :id_boutique";
        if ($annee) {
            $sql .= " AND EXTRACT(YEAR FROM DATE_CA_JOURNALIER) = :annee";
        }

        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ':id_boutique', $idBoutique);
        if ($annee) {
            oci_bind_by_name($stid, ':annee', $annee);
        }

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        return oci_fetch_assoc($stid);
    }

    public function creerCA($data)
    {
        //Créer un CA pour une boutique à une date donnée
        $db = Database::getConnection();

        $sql = "INSERT INTO CHIFFRE_AFFAIRES (ID_BOUTIQUE, MONTANT, DATE_CA_JOURNALIER) VALUES (:id_boutique, :montant, TO_DATE(:date_jour, 'YYYY-MM-DD'))";

        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ':id_boutique', $data['id_boutique']);
        oci_bind_by_name($stid, ':montant', $data['montant']);
        oci_bind_by_name($stid, ':date_jour', $data['date']);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        return true;
    }
    public function caTotalParBoutique()
    {
        //Quel est le CA de chaque boutique ?
        $db = Database::getConnection();

        $sql = "SELECT ID_BOUTIQUE, SUM(MONTANT) AS total_ca FROM CHIFFRE_AFFAIRES GROUP BY ID_BOUTIQUE";
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
    public function caMoyenParBoutique()
    {
        //Quel est le CA moyen de chaque boutique ?
        $db = Database::getConnection();

        $sql = "SELECT ID_BOUTIQUE, AVG(MONTANT) AS moyenne_ca FROM CHIFFRE_AFFAIRES GROUP BY ID_BOUTIQUE";
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
    public function classementCA()
    {
        //Quelles sont les boutiques qui rapportent le plus d'argent et celles qui rapportent le moins d'argent
        $db = Database::getConnection();

        $sql = "SELECT ID_BOUTIQUE, SUM(MONTANT) AS total_ca FROM CHIFFRE_AFFAIRES GROUP BY ID_BOUTIQUE ORDER BY SUM(MONTANT) DESC";
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
}
