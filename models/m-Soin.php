<?php
class Soin extends BaseModel
{
    public function getAll()
    {
        $sql = "SELECT S.*, A.NOM_ANIMAL, P.NOM,P.PRENOM FROM SOIN S LEFT JOIN PERSONNEL P ON P.ID_PERSONNEL = S.ID_SOIGNEUR LEFT JOIN ANIMAL A ON A.ID_ANIMAL = S.ID_ANIMAL";
        return $this->executeQueryAll($sql);
    }

    public function getParAnimal($id_animal): mixed
    {
        $sql = "SELECT S.*, P.NOM,P.PRENOM FROM SOIN S JOIN PERSONNEL P ON S.ID_Soigneur = P.ID_PERSONNEL WHERE S.ID_ANIMAL = :id_animal ORDER BY S.DATE_SOIN DESC";
        return $this->executeQueryAll($sql, [':id_animal' => $id_animal]);
    }

    public function getParPersonne($id_personnel): mixed
    {
        $sql = "SELECT S.*, A.NOM_ANIMAL FROM SOIN S JOIN ANIMAL A ON S.ID_ANIMAL = A.ID_ANIMAL WHERE S.ID_Soigneur = :id_personnel ORDER BY S.DATE_SOIN DESC";
        return $this->executeQueryAll($sql, [':id_personnel' => $id_personnel]);
    }

    /**
     * Summary of creer
     * retourne 2 ou 1 en fonction de la réussite de l'insertion
     *
     */
    public function creer($data)
    {
        $sql = "INSERT INTO SOIN (ID_SOIGNEUR, ID_VETERINAIRE,ID_ANIMAL, DATE_SOIN, DESCRIPTION_SOIN) VALUES (:id_personnel, :id_veterinaire, :id_animal, TO_DATE(:date_soin, 'YYYY-MM-DD'), :description_soin)";
        $result = $this->executeModify($sql, [
            ':id_personnel' => $data['ID_PERSONNEL'],
            ':id_veterinaire' => $data['ID_VETERINAIRE'],
            ':id_animal' => $data['ID_ANIMAL'],
            ':date_soin' => $data['DATE_SOIN'],
            ':description_soin' => $data['DESCRIPTION_SOIN']
        ]);
        return $result ? 1 : 2;
    }

    public function suppr($id_animal, $date_soin)
    {
        $sql = "DELETE FROM SOIN WHERE ID_ANIMAL = :id_animal AND DATE_SOIN = :date_soin";
        $result = $this->executeModify($sql, [
            ':id_animal' => $id_animal,
            ':date_soin' => $date_soin
        ]);
        return $result ? 1 : 2;
    }

    public function recupStatsSoigneurs()
    {
        //en cours de conception    
        return 0;
    }
}
