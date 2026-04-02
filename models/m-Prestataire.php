<?php

class Prestataire extends BaseModel
{
    /**
     * Récupère tous les prestataires
     * 
     * @return array Liste de tous les prestataires
     */
    public function getAll()
    {
        $sql = "SELECT * FROM PRESTATAIRE ORDER BY NOM_PRESTATAIRE, PRENOM_PRESTATAIRE";
        return $this->executeQueryAll($sql);
    }

    /**
     * Récupère un prestataire par son ID
     * 
     * @param int $id ID du prestataire
     * @return array|false Données du prestataire ou false
     */
    public function getById($id)
    {
        $sql = "SELECT * FROM PRESTATAIRE WHERE ID_PRESTATAIRE = :id";
        return $this->executeQuery($sql, [':id' => $id]);
    }

    /**
     * Crée un nouveau prestataire
     * 
     * @param array $data Données du prestataire (Nom_Prestataire, Prenom_Prestataire)
     * @return bool Succès de l'opération
     */
    public function creer($data)
    {
        $sql = "INSERT INTO PRESTATAIRE (ID_PRESTATAIRE, NOM_PRESTATAIRE, PRENOM_PRESTATAIRE) 
                VALUES ((SELECT NVL(MAX(ID_PRESTATAIRE), 0) + 1 FROM Prestataire), :nom, :prenom)";
        return $this->executeModify($sql, [
            ':nom' => $data['NOM_PRESTATAIRE'],
            ':prenom' => $data['PRENOM_PRESTATAIRE']
        ]);
    }

    /**
     * Met à jour un prestataire existant
     * 
     * @param int $id ID du prestataire
     * @param array $data Données à mettre à jour
     * @return bool Succès de l'opération
     */
    public function update($id, $data)
    {
        $sql = "UPDATE PRESTATAIRE 
                SET NOM_PRESTATAIRE = :nom, 
                    PRENOM_PRESTATAIRE = :prenom 
                WHERE ID_PRESTATAIRE = :id";
        return $this->executeModify($sql, [
            ':id' => $id,
            ':nom' => $data['NOM_PRESTATAIRE'],
            ':prenom' => $data['PRENOM_PRESTATAIRE']
        ]);
    }

    /**
     * Supprime un prestataire
     * 
     * @param int $id ID du prestataire
     * @return bool Succès de l'opération
     */
    public function suppr($id)
    {
        $sql = "DELETE FROM PRESTATAIRE WHERE ID_PRESTATAIRE = :id";
        return $this->executeModify($sql, [':id' => $id]);
    }

    /**
     * Récupère toutes les réparations effectuées par un prestataire
     * 
     * @param int $id_prestataire ID du prestataire
     * @return array Liste des réparations
     */
    public function getReparations($id_prestataire)
    {
        $sql = "SELECT r.DATE_DEBUT_REPARATION, r.LATITUDE_ENCLOS, r.LONGITUDE_ENCLOS, 
                       r.DATE_FIN, r.NATURE_REPARATION, r.COUT_REPARATION,
                       p.NOM_PRESTATAIRE, p.PRENOM_PRESTATAIRE,
                       per.NOM, per.PRENOM
                FROM REPARATION r
                JOIN PRESTATAIRE p ON r.ID_PRESTATAIRE = p.ID_PRESTATAIRE
                JOIN PERSONNEL per ON r.ID_PERSONNEL = per.ID_PERSONNEL
                WHERE r.ID_PRESTATAIRE = :id
                ORDER BY r.DATE_DEBUT_REPARATION DESC";
        return $this->executeQueryAll($sql, [':id' => $id_prestataire]);
    }
}
