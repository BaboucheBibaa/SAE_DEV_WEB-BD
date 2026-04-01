<?php
class Espece extends BaseModel
{
    public function getAll()
    {
        $sql = "SELECT * FROM Espece ORDER BY NOM_ESPECE";
        return $this->executeQueryAll($sql);
    }

    public function getParID($id)
    {
        $query = "SELECT * FROM Espece WHERE ID_ESPECE = :id_espece";
        return $this->executeQuery($query, [':id_espece' => $id]);
    }

    public function suppr($id_espece)
    {
        $query = "DELETE FROM ESPECE WHERE ID_ESPECE = :id_espece";
        return $this->executeModify($query, [':id_espece' => $id_espece]);
    }

    public function moteurRechercheRecup($searchTerm)
    {
        $sql = "SELECT * FROM ESPECE WHERE LOWER(NOM_ESPECE) LIKE LOWER(:searchTerm)";
        $likeTerm = '%' . $searchTerm . '%';
        return $this->executeQueryAll($sql, [':searchTerm' => $likeTerm]);
    }

    public function getEspecesCompatibles($id_espece)
    {
        $query = "SELECT e.ID_ESPECE, e.NOM_ESPECE, e.NOM_LATIN_ESPECE, e.EST_MENACEE 
                 FROM Espece e
                 INNER JOIN Est_Compatible_Avec ecc ON e.ID_ESPECE = ecc.ID_ESPECE2
                 WHERE ecc.ID_ESPECE1 = :id_espece
                 ORDER BY e.NOM_ESPECE";
        return $this->executeQueryAll($query, [':id_espece' => $id_espece]);
    }

    public function getAnimauxParEspece($id_espece)
    {
        $query = "SELECT ID_ANIMAL, NOM_ANIMAL, POIDS, DATE_NAISSANCE 
                 FROM Animal 
                 WHERE ID_ESPECE = :id_espece
                 ORDER BY NOM_ANIMAL";
        return $this->executeQueryAll($query, [':id_espece' => $id_espece]);
    }
}
