<?php
class ContratTravail
{
    public function recupParPersonnel($id_personnel)
    {
        $db = Database::getConnection();
        $query = "SELECT CT.*, F.NOM_FONCTION
                  FROM Contrat_Travail CT
                  JOIN Fonction F ON CT.ID_FONCTION = F.ID_FONCTION
                  WHERE CT.ID_PERSONNEL = :id_personnel
                  ORDER BY CT.DATE_DEBUT DESC";
        $stid = oci_parse($db, $query);
        oci_bind_by_name($stid, ':id_personnel', $id_personnel);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $result = [];
        oci_fetch_all($stid, $result, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        return $result;
    }

    public function creer($data)
    {
        $db = Database::getConnection();

        $sqlSeq = "SELECT NVL(MAX(ID_CONTRAT), 0) + 1 AS NEW_ID FROM CONTRAT_TRAVAIL";
        $stidSeq = oci_parse($db, $sqlSeq);
        oci_execute($stidSeq);
        $row = oci_fetch_assoc($stidSeq);
        $newId = $row['NEW_ID'];

        $sql = "INSERT INTO CONTRAT_TRAVAIL (ID_CONTRAT, ID_PERSONNEL, ID_FONCTION, DATE_DEBUT, DATE_FIN)
                VALUES (:id_contrat, :id_personnel, :id_fonction, TO_DATE(:date_debut, 'YYYY-MM-DD'), TO_DATE(:date_fin, 'YYYY-MM-DD'))";

        $stid = oci_parse($db, $sql);

        $dateFin = !empty($data['DATE_FIN']) ? $data['DATE_FIN'] : null;

        oci_bind_by_name($stid, ':id_contrat', $newId);
        oci_bind_by_name($stid, ':id_personnel', $data['ID_PERSONNEL']);
        oci_bind_by_name($stid, ':id_fonction', $data['ID_FONCTION']);
        oci_bind_by_name($stid, ':date_debut', $data['DATE_DEBUT']);
        oci_bind_by_name($stid, ':date_fin', $dateFin);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        return $r;
    }
    public function finDeContrats(){
        // Récupère les contrats de travail qui se terminent dans les 30 prochains jours
        $db = Database::getConnection();
        $query = "SELECT CT.*, P.NOM, P.PRENOM, F.NOM_FONCTION
                  FROM Contrat_Travail CT
                  JOIN Personnel P ON CT.ID_PERSONNEL = P.ID_PERSONNEL
                  JOIN Fonction F ON CT.ID_FONCTION = F.ID_FONCTION
                  WHERE CT.DATE_FIN <= SYSDATE + 30
                  ORDER BY CT.DATE_FIN ASC";
        $stid = oci_parse($db, $query);

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