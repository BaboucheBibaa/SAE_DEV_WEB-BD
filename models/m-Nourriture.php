<?php

class Nourriture extends BaseModel
{
    public function getNourritureParAnimal($id_animal): mixed
    {
        $sql = "SELECT EN.*, P.NOM,P.PRENOM FROM EST_NOURRI EN JOIN PERSONNEL P ON EN.ID_PERSONNEL = P.ID_PERSONNEL WHERE EN.ID_ANIMAL = :id_animal ORDER BY EN.DATE_NOURRIT DESC";
        return $this->executeQueryAll($sql, [':id_animal' => $id_animal]);
    }

    public function creer($data)
    {
        $sql = "INSERT INTO EST_NOURRI (ID_ANIMAL, ID_PERSONNEL, DATE_NOURRIT, DOSE_NOURRITURE) VALUES (:id_animal, :id_personnel, TO_DATE(:date_nourrit, 'YYYY-MM-DD'), TO_NUMBER(:dose_nourriture, '9999.99'))";
        return $this->executeModify($sql, [
            ':id_animal' => $data['ID_ANIMAL'],
            ':id_personnel' => $data['ID_PERSONNEL'],
            ':date_nourrit' => $data['DATE_NOURRIT'],
            ':dose_nourriture' => $data['DOSE_NOURRITURE']
        ]);
    }

    public function suppr($id_animal, $id_personnel, $date_nourrit)
    {
        $sql = "DELETE FROM EST_NOURRI WHERE ID_ANIMAL = :id_animal AND ID_PERSONNEL = :id_personnel AND DATE_NOURRIT = :date_nourrit";
        return $this->executeModify($sql, [
            ':id_animal' => $id_animal,
            ':id_personnel' => $id_personnel,
            ':date_nourrit' => $date_nourrit
        ]);
    }
}