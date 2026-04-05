<?php
class Compatibilité extends BaseModel
{
    /**
     * Récupère toutes les compatibilités
     * @return array Tableau de toutes les compatibilités
     */
    public function getAll()
    {
        $query = "SELECT E1.ID_ESPECE as ID_ESPECE1, E1.NOM_ESPECE as NOM_ESPECE1, E1.NOM_LATIN_ESPECE as NOM_LATIN_ESPECE1,
                         E2.ID_ESPECE as ID_ESPECE2, E2.NOM_ESPECE as NOM_ESPECE2, E2.NOM_LATIN_ESPECE as NOM_LATIN_ESPECE2
                  FROM EST_COMPATIBLE_AVEC C
                  JOIN ESPECE E1 ON C.ID_ESPECE1 = E1.ID_ESPECE
                  JOIN ESPECE E2 ON C.ID_ESPECE2 = E2.ID_ESPECE
                  ORDER BY E1.NOM_ESPECE, E2.NOM_ESPECE";
        return $this->executeQueryAll($query);
    }

    /**
     * Vérifie si deux espèces sont compatibles
     * @param int $id_espece1 Première espèce
     * @param int $id_espece2 Deuxième espèce
     * @return bool Compatibilité existe
     */
    public function verifierCompatibilite($id_espece1, $id_espece2)
    {
        $query = "SELECT * FROM EST_COMPATIBLE_AVEC 
                  WHERE (ID_ESPECE1 = :id_espece1 AND ID_ESPECE2 = :id_espece2) 
                     OR (ID_ESPECE1 = :id_espece2 AND ID_ESPECE2 = :id_espece1)";
        $result = $this->executeQuery($query, [':id_espece1' => $id_espece1, ':id_espece2' => $id_espece2]);
        return $result !== false;
    }

    /**
     * Ajoute une compatibilité entre deux espèces (bidirectionelle)
     * @param int $id_espece1 Première espèce
     * @param int $id_espece2 Deuxième espèce
     * @return bool Succès de l'opération
     */
    public function creer($id_espece1, $id_espece2)
    {
        // Éviter de créer une compatibilité entre la même espèce
        if ($id_espece1 == $id_espece2) {
            return false;
        }

        // Vérifier qu'elle n'existe pas déjà
        if ($this->verifierCompatibilite($id_espece1, $id_espece2)) {
            return false;
        }

        // Ajouter la relation dans les deux sens (bidirectionelle)
        $query1 = "INSERT INTO EST_COMPATIBLE_AVEC (ID_ESPECE1, ID_ESPECE2) VALUES (:id_espece1, :id_espece2)";
        $r1 = $this->executeModify($query1, [':id_espece1' => $id_espece1, ':id_espece2' => $id_espece2]);
        
        $query2 = "INSERT INTO EST_COMPATIBLE_AVEC (ID_ESPECE1, ID_ESPECE2) VALUES (:id_espece1, :id_espece2)";
        $r2 = $this->executeModify($query2, [':id_espece1' => $id_espece2, ':id_espece2' => $id_espece1]);
        
        return $r1 && $r2;
    }

    /**
     * Supprime une compatibilité entre deux espèces
     * @param int $id_espece1 Première espèce
     * @param int $id_espece2 Deuxième espèce
     * @return bool Succès de l'opération
     */
    public function suppr($id_espece1, $id_espece2)
    {
        // Supprimer dans les deux sens
        $query = "DELETE FROM EST_COMPATIBLE_AVEC 
                  WHERE (ID_ESPECE1 = :id_espece1 AND ID_ESPECE2 = :id_espece2)
                     OR (ID_ESPECE1 = :id_espece2 AND ID_ESPECE2 = :id_espece1)";
        return $this->executeModify($query, [':id_espece1' => $id_espece1, ':id_espece2' => $id_espece2]);
    }
}
