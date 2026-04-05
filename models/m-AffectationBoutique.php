<?php

class AffectationBoutique extends BaseModel
{
    /**
     * Récupère tous les employés assignés aux boutiques
     */
    public function getAll()
    {
        $sql = "SELECT T.ID_BOUTIQUE, T.ID_PERSONNEL, P.NOM, P.PRENOM, B.NOM_BOUTIQUE 
                FROM TRAVAILLE_DANS_LA_BOUTIQUE T
                JOIN PERSONNEL P ON T.ID_PERSONNEL = P.ID_PERSONNEL
                JOIN BOUTIQUE B ON T.ID_BOUTIQUE = B.ID_BOUTIQUE
                ORDER BY B.NOM_BOUTIQUE, P.NOM";
        return $this->executeQueryAll($sql);
    }

    /**
     * Récupère les employés assignés à une boutique spécifique
     */
    public function getParBoutique($id_boutique)
    {
        $sql = "SELECT T.ID_BOUTIQUE, T.ID_PERSONNEL, P.NOM, P.PRENOM 
                FROM TRAVAILLE_DANS_LA_BOUTIQUE T
                JOIN PERSONNEL P ON T.ID_PERSONNEL = P.ID_PERSONNEL
                WHERE T.ID_BOUTIQUE = :id_boutique
                ORDER BY P.NOM";
        return $this->executeQueryAll($sql, [':id_boutique' => $id_boutique]);
    }

    /**
     * Récupère les boutiques auxquelles un employé est assigné
     */
    public function getParEmploye($id_personnel)
    {
        $sql = "SELECT T.ID_BOUTIQUE, T.ID_PERSONNEL, B.NOM_BOUTIQUE 
                FROM TRAVAILLE_DANS_LA_BOUTIQUE T
                JOIN BOUTIQUE B ON T.ID_BOUTIQUE = B.ID_BOUTIQUE
                WHERE T.ID_PERSONNEL = :id_personnel
                ORDER BY B.NOM_BOUTIQUE";
        return $this->executeQueryAll($sql, [':id_personnel' => $id_personnel]);
    }

    /**
     * Vérifie si un employé est déjà assigné à une boutique
     */
    public function exists($id_boutique, $id_personnel)
    {
        $sql = "SELECT COUNT(*) as COUNT 
                FROM TRAVAILLE_DANS_LA_BOUTIQUE 
                WHERE ID_BOUTIQUE = :id_boutique AND ID_PERSONNEL = :id_personnel";
        $result = $this->executeQuery($sql, [':id_boutique' => $id_boutique, ':id_personnel' => $id_personnel]);
        return $result['COUNT'] > 0;
    }

    /**
     * Ajoute un employé à une boutique
     */
    public function ajouter($id_boutique, $id_personnel)
    {
        $sql = "INSERT INTO TRAVAILLE_DANS_LA_BOUTIQUE (ID_BOUTIQUE, ID_PERSONNEL) 
                VALUES (:id_boutique, :id_personnel)";
        return $this->executeModify($sql, [':id_boutique' => $id_boutique, ':id_personnel' => $id_personnel]);
    }

    /**
     * Supprime l'assignation d'un employé à une boutique
     */
    public function supprimer($id_boutique, $id_personnel)
    {
        $sql = "DELETE FROM TRAVAILLE_DANS_LA_BOUTIQUE 
                WHERE ID_BOUTIQUE = :id_boutique AND ID_PERSONNEL = :id_personnel";
        return $this->executeModify($sql, [':id_boutique' => $id_boutique, ':id_personnel' => $id_personnel]);
    }
}
