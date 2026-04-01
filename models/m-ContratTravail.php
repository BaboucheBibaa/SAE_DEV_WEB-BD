<?php
class ContratTravail extends BaseModel
{
    private function getNextIdContrat()
    {
        $sqlSeq = "SELECT NVL(MAX(ID_CONTRAT), 0) + 1 AS NEW_ID FROM CONTRAT_TRAVAIL";
        $row = $this->executeQuery($sqlSeq);
        return $row['NEW_ID'];
    }

    public function getParPersonnel($id_personnel)
    {
        $query = "SELECT CT.*, F.NOM_FONCTION
                  FROM Contrat_Travail CT
                  JOIN Fonction F ON CT.ID_FONCTION = F.ID_FONCTION
                  WHERE CT.ID_PERSONNEL = :id_personnel
                  ORDER BY CT.DATE_DEBUT DESC";
        return $this->executeQueryAll($query, [':id_personnel' => $id_personnel]);
    }

    public function creer($data)
    {
        $newId = $this->getNextIdContrat();

        $sql = "INSERT INTO CONTRAT_TRAVAIL (ID_CONTRAT, ID_PERSONNEL, ID_FONCTION, DATE_DEBUT, DATE_FIN)
                VALUES (:id_contrat, :id_personnel, :id_fonction, TO_DATE(:date_debut, 'YYYY-MM-DD'), TO_DATE(:date_fin, 'YYYY-MM-DD'))";

        $dateFin = !empty($data['DATE_FIN']) ? $data['DATE_FIN'] : null;

        return $this->executeModify($sql, [
            ':id_contrat' => $newId,
            ':id_personnel' => $data['ID_PERSONNEL'],
            ':id_fonction' => $data['ID_FONCTION'],
            ':date_debut' => $data['DATE_DEBUT'],
            ':date_fin' => $dateFin
        ]);
    }

    public function getFinDeContrats()
    {
        // Récupère les contrats de travail qui se terminent dans les 30 prochains jours
        $query = "SELECT CT.*, P.NOM, P.PRENOM, F.NOM_FONCTION
                  FROM Contrat_Travail CT
                  JOIN Personnel P ON CT.ID_PERSONNEL = P.ID_PERSONNEL
                  JOIN Fonction F ON CT.ID_FONCTION = F.ID_FONCTION
                  WHERE CT.DATE_FIN <= SYSDATE + 30
                  ORDER BY CT.DATE_FIN ASC";
        return $this->executeQueryAll($query);
    }
}