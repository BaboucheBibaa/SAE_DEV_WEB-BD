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

    public function creer($data)
    {
        $query = "INSERT INTO Espece (ID_ESPECE, NOM_ESPECE, NOM_LATIN_ESPECE, EST_MENACEE) 
                 VALUES ((SELECT NVL(MAX(ID_ESPECE), 0) + 1 FROM Espece), :nom_espece, :nom_latin_espece, :est_menacee)";
        return $this->executeModify($query, [
            ':nom_espece' => $data['nom_espece'],
            ':nom_latin_espece' => $data['nom_latin_espece'],
            ':est_menacee' => $data['est_menacee'],
        ]);
    }

    /**
     * Met à jour une espèce existante
     * 
     * @param int $id ID de l'espèce
     * @param array $data Données à mettre à jour
     * @return bool Succès de l'opération
     */
    public function update($id, $data)
    {
        $query = "UPDATE Espece 
                 SET NOM_ESPECE = :nom_espece, 
                     NOM_LATIN_ESPECE = :nom_latin_espece, 
                     EST_MENACEE = :est_menacee 
                 WHERE ID_ESPECE = :id_espece";
        return $this->executeModify($query, [
            ':id_espece' => $id,
            ':nom_espece' => $data['nom_espece'],
            ':nom_latin_espece' => $data['nom_latin_espece'],
            ':est_menacee' => $data['est_menacee'],
        ]);
    }

    public function suppr($id_espece)
    {
        $query = "DELETE FROM ESPECE WHERE ID_ESPECE = :id_espece";
        return $this->executeModify($query, [':id_espece' => $id_espece]);
    }

    public function moteurRechercheRecup($searchTerm, $filters = [])
    {
        $sql = "SELECT E.*, COUNT(A.ID_ANIMAL) as NB_ANIMAUX 
                 FROM ESPECE E
                 LEFT JOIN ANIMAL A ON E.ID_ESPECE = A.ID_ESPECE
                 WHERE (LOWER(E.NOM_ESPECE) LIKE LOWER(:searchTerm)
                        OR LOWER(E.NOM_LATIN_ESPECE) LIKE LOWER(:searchTerm))";
        
        $params = [':searchTerm' => '%' . $searchTerm . '%'];
        
        $sql .= " GROUP BY E.ID_ESPECE, E.NOM_ESPECE, E.NOM_LATIN_ESPECE, E.EST_MENACEE
                  ORDER BY E.NOM_ESPECE";
        
        return $this->executeQueryAll($sql, $params);
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
