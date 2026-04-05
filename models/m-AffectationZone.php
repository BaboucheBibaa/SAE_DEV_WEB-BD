<?php

class AffectationZone extends BaseModel
{
    /**
     * Récupère toutes les affectations de personnel à des zones
     */
    public function getAll()
    {
        $sql = "SELECT A.ID_ZONE, A.ID_PERSONNEL, P.NOM, P.PRENOM, Z.NOM_ZONE 
                FROM EST_AFFECTEE_A A
                JOIN PERSONNEL P ON A.ID_PERSONNEL = P.ID_PERSONNEL
                JOIN ZONE Z ON A.ID_ZONE = Z.ID_ZONE
                ORDER BY Z.NOM_ZONE, P.NOM";
        return $this->executeQueryAll($sql);
    }

    /**
     * Récupère le personnel affecté à une zone spécifique
     */
    public function getParZone($id_zone)
    {
        $sql = "SELECT A.ID_ZONE, A.ID_PERSONNEL, P.NOM, P.PRENOM, P.ID_FONCTION 
                FROM EST_AFFECTEE_A A
                JOIN PERSONNEL P ON A.ID_PERSONNEL = P.ID_PERSONNEL
                WHERE A.ID_ZONE = :id_zone
                ORDER BY P.NOM";
        return $this->executeQueryAll($sql, [':id_zone' => $id_zone]);
    }

    /**
     * Récupère les zones auxquelles un personnel est affecté
     */
    public function getParPersonnel($id_personnel)
    {
        $sql = "SELECT A.ID_ZONE, A.ID_PERSONNEL, Z.NOM_ZONE 
                FROM EST_AFFECTEE_A A
                JOIN ZONE Z ON A.ID_ZONE = Z.ID_ZONE
                WHERE A.ID_PERSONNEL = :id_personnel
                ORDER BY Z.NOM_ZONE";
        return $this->executeQueryAll($sql, [':id_personnel' => $id_personnel]);
    }

    /**
     * Vérifie si un personnel est déjà affecté à une zone
     */
    public function exists($id_zone, $id_personnel)
    {
        $sql = "SELECT COUNT(*) as COUNT 
                FROM EST_AFFECTEE_A 
                WHERE ID_ZONE = :id_zone AND ID_PERSONNEL = :id_personnel";
        $result = $this->executeQuery($sql, [':id_zone' => $id_zone, ':id_personnel' => $id_personnel]);
        return $result['COUNT'] > 0;
    }

    /**
     * Ajoute un personnel à une zone
     */
    public function ajouter($id_zone, $id_personnel)
    {
        $sql = "INSERT INTO EST_AFFECTEE_A (ID_ZONE, ID_PERSONNEL) 
                VALUES (:id_zone, :id_personnel)";
        return $this->executeModify($sql, [':id_zone' => $id_zone, ':id_personnel' => $id_personnel]);
    }

    /**
     * Supprime l'affectation d'un personnel à une zone
     */
    public function supprimer($id_zone, $id_personnel)
    {
        $sql = "DELETE FROM EST_AFFECTEE_A 
                WHERE ID_ZONE = :id_zone AND ID_PERSONNEL = :id_personnel";
        return $this->executeModify($sql, [':id_zone' => $id_zone, ':id_personnel' => $id_personnel]);
    }
}
