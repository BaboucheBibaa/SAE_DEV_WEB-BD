<?php

class CA extends BaseModel
{
    public function getAll()
    {
        //Vérifie si un CA existe déjà pour une boutique à une date donnée afin d'éviter les doublons et les erreurs de saisie
        $sql = "SELECT CA.* FROM CHIFFRE_AFFAIRES CA JOIN BOUTIQUE B ON B.ID_BOUTIQUE = CA.ID_BOUTIQUE";
        return $this->executeQueryAll($sql);
    }

    public function existeCA($idBoutique, $date)
    {
        //Vérifie si un CA existe déjà pour une boutique à une date donnée afin d'éviter les doublons et les erreurs de saisie
        $sql = "SELECT COUNT(*) AS NB FROM CHIFFRE_AFFAIRES WHERE ID_BOUTIQUE = :id_boutique AND DATE_CA_JOURNALIER = TO_DATE(:date_jour, 'YYYY-MM-DD')";
        $row = $this->executeQuery($sql, [':id_boutique' => $idBoutique, ':date_jour' => $date]);
        return isset($row['NB']) && (int) $row['NB'] > 0;
    }

    public function getCAJournee($idBoutique)
    {
        //Quel est le CA du jour pour une boutique donnée ? (CA journalier)
        $sql = "SELECT MONTANT AS total_ca FROM CHIFFRE_AFFAIRES WHERE ID_BOUTIQUE = :id_boutique AND DATE_CA_JOURNALIER = TRUNC(SYSDATE)";
        return $this->executeQuery($sql, [':id_boutique' => $idBoutique]);
    }

    public function getCAMensuel($idBoutique)
    {
        //Quel est le CA du mois en cours pour une boutique donnée ? (CA mensuel)
        $sql = "SELECT SUM(MONTANT) AS total_ca FROM CHIFFRE_AFFAIRES WHERE ID_BOUTIQUE = :id_boutique AND EXTRACT(MONTH FROM DATE_CA_JOURNALIER) = EXTRACT(MONTH FROM SYSDATE) AND EXTRACT(YEAR FROM DATE_CA_JOURNALIER) = EXTRACT(YEAR FROM SYSDATE)";
        return $this->executeQuery($sql, [':id_boutique' => $idBoutique]);
    }

    public function getSommeCA($idBoutique, $annee = null)
    {
        //Par année ou non, quel est le CA total d'une boutique ?
        $sql = "SELECT SUM(MONTANT) AS total_ca FROM CHIFFRE_AFFAIRES WHERE ID_BOUTIQUE = :id_boutique";
        $params = [':id_boutique' => $idBoutique];
        
        if ($annee) {
            $sql .= " AND EXTRACT(YEAR FROM DATE_CA_JOURNALIER) = :annee";
            $params[':annee'] = $annee;
        }

        return $this->executeQuery($sql, $params);
    }

    public function getMoyenneCA($idBoutique, $annee = null)
    {
        //Par année ou non, quel est le CA moyen d'une boutique ?
        $sql = "SELECT ROUND(AVG(MONTANT), 2) AS moyenne_ca FROM CHIFFRE_AFFAIRES";
        $params = [':id_boutique' => $idBoutique];
        
        if ($annee) {
            $sql .= " WHERE EXTRACT(YEAR FROM DATE_CA_JOURNALIER) = :annee";
            $params[':annee'] = $annee;
        }
        
        $sql .= " GROUP BY ID_BOUTIQUE HAVING ID_BOUTIQUE = :id_boutique";

        return $this->executeQuery($sql, $params);
    }

    public function creer($data)
    {
        //Créer un CA pour une boutique à une date donnée
        $sql = "INSERT INTO CHIFFRE_AFFAIRES (ID_BOUTIQUE, MONTANT, DATE_CA_JOURNALIER) VALUES (:id_boutique, :montant, TO_DATE(:date_jour, 'YYYY-MM-DD'))";
        return $this->executeModify($sql, [
            ':id_boutique' => $data['id_boutique'],
            ':montant' => $data['montant'],
            ':date_jour' => $data['date']
        ]);
    }

    public function suppr($id_boutique, $date_ca)
    {
        $sql = "DELETE FROM CHIFFRE_AFFAIRES WHERE ID_BOUTIQUE = :id_boutique AND DATE_CA_JOURNALIER = :date_jour";
        return $this->executeModify($sql, [
            ':id_boutique' => $id_boutique,
            ':date_jour' => $date_ca
        ]);
    }
}
