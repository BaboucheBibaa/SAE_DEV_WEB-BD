<?php
class Compatibilité extends BaseModel
{
    public function verifierCompatibilite($id_espece1, $id_espece2)
    {
        // Vérifie si les deux espèces sont compatibles
        $query = "SELECT * FROM Compatibilite_Especes 
                  WHERE (ID_ESPECE1 = :id_espece1 AND ID_ESPECE2 = :id_espece2) 
                     OR (ID_ESPECE1 = :id_espece2 AND ID_ESPECE2 = :id_espece1)";
        $result = $this->executeQuery($query, [':id_espece1' => $id_espece1, ':id_espece2' => $id_espece2]);
        return $result !== false;
    }

    public function getAll($id_espece)
    {
        // Récupère les espèces compatibles avec l'espèce donnée
        $query = "SELECT E.* FROM Espece E
                  JOIN Compatibilite_Especes C ON (E.ID_ESPECE = C.ID_ESPECE1 AND C.ID_ESPECE2 = :id_espece)
                                              OR (E.ID_ESPECE = C.ID_ESPECE2 AND C.ID_ESPECE1 = :id_espece)";
        return $this->executeQueryAll($query, [':id_espece' => $id_espece]);
    }

    public function ajouterCompatibilite($id_espece1, $id_espece2)
    {
        // Ajoute une compatibilité entre deux espèces
        $query = "INSERT INTO Compatibilite_Especes (ID_ESPECE1, ID_ESPECE2) VALUES (:id_espece1, :id_espece2)";
        return $this->executeModify($query, [':id_espece1' => $id_espece1, ':id_espece2' => $id_espece2]);
    }
}
