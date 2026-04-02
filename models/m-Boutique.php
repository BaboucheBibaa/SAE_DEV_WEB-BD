<?php
class Boutique extends BaseModel
{
    public function getAll()
    {
        /*Récupère toutes les boutiques
        */
        $sql = "SELECT *
                FROM Boutique";
        return $this->executeQueryAll($sql);
    }

    /*Récupère le chiffre d'affaire d'une boutique
        */
    public function getAllCA($id_boutique)
    {
        $sql = "SELECT CA.*
                FROM CHIFFRE_AFFAIRES CA JOIN BOUTIQUE B ON B.ID_BOUTIQUE = CA.ID_BOUTIQUE WHERE B.ID_BOUTIQUE = :id_boutique";
        return $this->executeQueryAll($sql, [':id_boutique' => $id_boutique]);
    }

    public function getEmployees($id_boutique)
    {
        $sql = "SELECT P.NOM, P.PRENOM, P.ID_PERSONNEL
                FROM PERSONNEL P
                JOIN TRAVAILLE_DANS_LA_BOUTIQUE B ON P.ID_PERSONNEL = B.ID_PERSONNEL
                WHERE B.ID_BOUTIQUE = :id_boutique";
        return $this->executeQueryAll($sql, [':id_boutique' => $id_boutique]);
    }

    public function getParID($id)
    {
        $sql = "SELECT * FROM Boutique WHERE ID_BOUTIQUE = :id";
        return $this->executeQuery($sql, [':id' => $id]);
    }

    public function getParManager($id_manager)
    {
        $sql = "SELECT B.*,Z.NOM_ZONE FROM Boutique B JOIN ZONE Z ON B.ID_ZONE = Z.ID_ZONE WHERE B.ID_MANAGER = :id_manager";
        return $this->executeQuery($sql, [':id_manager' => $id_manager]);
    }

    public function getNomManager($id_boutique)
    {
        $sql = "SELECT P.NOM AS NOM, P.PRENOM  AS PRENOM
                FROM PERSONNEL P
                JOIN BOUTIQUE B ON P.ID_PERSONNEL = B.ID_MANAGER
                WHERE B.ID_BOUTIQUE = :id_boutique";
        return $this->executeQuery($sql, [':id_boutique' => $id_boutique]);
    }

    public function creer($data)
    {
        $sql = "INSERT INTO Boutique (ID_BOUTIQUE,ID_MANAGER,ID_ZONE,NOM_BOUTIQUE,DESCRIPTION_BOUTIQUE) 
            VALUES ((SELECT NVL(MAX(ID_BOUTIQUE), 0) + 1 FROM Boutique), :id_manager, :id_zone, :nom_boutique, :description_boutique)";
        return $this->executeModify($sql, [
            ':id_manager' => $data['id_manager'],
            ':id_zone' => $data['id_zone'],
            ':nom_boutique' => $data['nom_boutique'],
            ':description_boutique' => $data['description_boutique']
        ]);
    }

    public function maj($id, $data)
    {
        $sql = 'UPDATE Boutique 
            SET ID_MANAGER = :id_manager, ID_ZONE = :id_zone, NOM_BOUTIQUE = :nom_boutique, DESCRIPTION_BOUTIQUE = :description_boutique
            WHERE ID_BOUTIQUE = :id';

        $id_manager = $data['id_manager'] ?? null;
        $id_zone = $data['id_zone'] ?? null;
        $nom_boutique = $data['nom_boutique'] ?? null;
        $description_boutique = $data['description_boutique'] ?? null;

        return $this->executeModify($sql, [
            ':id_manager' => $id_manager,
            ':id_zone' => $id_zone,
            ':nom_boutique' => $nom_boutique,
            ':description_boutique' => $description_boutique,
            ':id' => $id
        ]);
    }

    public function suppr($id)
    {
        $sql = "DELETE FROM Boutique WHERE ID_BOUTIQUE = :id";
        return $this->executeModify($sql, [':id' => $id]);
    }

    public function moteurRechercheRecup($searchTerm, $filters = [])
    {
        $sql = "SELECT B.*, Z.NOM_ZONE 
                 FROM BOUTIQUE B
                 LEFT JOIN ZONE Z ON B.ID_ZONE = Z.ID_ZONE
                 WHERE LOWER(B.NOM_BOUTIQUE) LIKE LOWER(:searchTerm)
                    OR LOWER(B.DESCRIPTION_BOUTIQUE) LIKE LOWER(:searchTerm)
                 ORDER BY B.NOM_BOUTIQUE";
        
        return $this->executeQueryAll($sql, [':searchTerm' => '%' . $searchTerm . '%']);
    }
}
