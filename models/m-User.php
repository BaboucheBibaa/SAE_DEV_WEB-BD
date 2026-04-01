<?php
class User extends BaseModel
{

    private function getNextIdPersonnel()
    {
        $sqlSeq = "SELECT NVL(MAX(ID_PERSONNEL), 0) + 1 AS NEW_ID FROM Personnel";
        $row = $this->executeQuery($sqlSeq);
        return $row['NEW_ID'];
    }

    public function getLastInsertId()
    {
        $sqlSeq = "SELECT NVL(MAX(ID_PERSONNEL), 0) AS LAST_ID FROM Personnel";
        return $this->executeQuery($sqlSeq);
    }

    /**
     * Récupère un utilisateur par son login (pour l'authentification)
     */
    public function getParLogs($login)
    {
        $query = "SELECT Personnel.*, Fonction.ID_Fonction FROM Personnel LEFT JOIN Fonction ON Personnel.ID_Fonction = Fonction.ID_Fonction WHERE LOGIN = :login AND estArchive = 1";
        return $this->executeQuery($query, [':login' => $login]);
    }

    /**
     * Récupère un utilisateur par son ID
     */
    public function getParID($id)
    {
        $sql = "SELECT Personnel.*, Fonction.ID_Fonction, Fonction.Nom_Fonction
            FROM Personnel 
            LEFT JOIN Fonction ON Personnel.ID_Fonction = Fonction.ID_Fonction 
            WHERE ID_Personnel = :id
            AND estArchive = 1";
        return $this->executeQuery($sql, [':id' => $id]);
    }

    public function getParFonction($id_fonction)
    {
        $sql = "SELECT P.NOM, P.PRENOM, P.ID_PERSONNEL FROM Personnel P, Fonction F WHERE P.ID_FONCTION = F.ID_FONCTION AND F.ID_FONCTION = :id_fonction";
        return $this->executeQueryAll($sql, [':id_fonction' => $id_fonction]);
    }

    public function getSoigneursParSuperieur($id)
    {
        $sql = "SELECT P.NOM,P.PRENOM, P.ID_PERSONNEL FROM Personnel P WHERE P.ID_SUPERIEUR = :id";
        return $this->executeQueryAll($sql, [':id' => $id]);
    }

    /**
     * Récupère les employés selon le statut d'archivage
     * $estArchive = null => tous, 1 => actifs, 0 => archivés
     */
    public function getAll($estArchive = null)
    {
        if ($estArchive === null) {
            $sql = "SELECT * FROM Personnel";
            return $this->executeQueryAll($sql);
        } else {
            $sql = "SELECT * FROM Personnel WHERE estArchive = :estArchive";
            return $this->executeQueryAll($sql, [':estArchive' => $estArchive]);
        }
    }

    /**
     * Met à jour le statut d'archivage d'un employé
     */
    public function majArchive($id, $estArchive)
    {
        $sql = "UPDATE Personnel SET estArchive = :estArchive WHERE ID_Personnel = :id";
        return $this->executeModify($sql, [':id' => $id, ':estArchive' => $estArchive]);
    }

    public function creer($data)
    {
        $new_id = $this->getNextIdPersonnel();

        $sql = "INSERT INTO Personnel (ID_Personnel, Nom, Prenom, Mail, MDP, Date_Entree, Salaire, ID_Fonction, LOGIN, ID_Remplacant, ID_Superieur)
            VALUES (:id_personnel, :nom, :prenom, :mail, :MDP, TO_DATE(:date_entree, 'YYYY-MM-DD'), :salaire, :ID_Fonction, :login, :ID_Remplacant, :ID_Superieur)";

        $nom = $data['nom'] ?? null;
        $prenom = $data['prenom'] ?? null;
        $mail = $data['mail'] ?? null;
        $mdp = $data['MDP'];
        $date_entree = $data['date_entree'] ?? null;
        $salaire = $data['salaire'] ?? null;
        $ID_Fonction = $data['id_fonction'] ?? null;
        $login = $data['login'] ?? null;
        $ID_Remplacant = $data['id_remplacant'] ?? $new_id;
        $ID_Superieur = $data['id_superieur'] ?? null;

        $result = $this->executeModify($sql, [
            ':id_personnel' => $new_id,
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':mail' => $mail,
            ':MDP' => $mdp,
            ':date_entree' => $date_entree,
            ':salaire' => $salaire,
            ':ID_Fonction' => $ID_Fonction,
            ':login' => $login,
            ':ID_Remplacant' => $ID_Remplacant,
            ':ID_Superieur' => $ID_Superieur
        ]);

        return $result ? (int) $new_id : null;
    }

    public function majPassword($id, $newPasswordHashed)
    {
        $sql = "UPDATE Personnel SET MDP = :MDP WHERE ID_Personnel = :id";
        return $this->executeModify($sql, [':id' => $id, ':MDP' => $newPasswordHashed]);
    }

    /**
     * Met à jour un employé
     */
    public function maj($id, $data)
    {
        $sql = 'UPDATE Personnel 
            SET Nom = :nom, Prenom = :prenom, Mail = :mail, MDP = :MDP, 
                Date_Entree = TO_DATE(:date_entree, \'YYYY-MM-DD\'), Salaire = :salaire, ID_Fonction = :ID_Fonction, LOGIN = :login, 
                ID_Remplacant = :ID_Remplacant, ID_Superieur = :ID_Superieur 
            WHERE ID_Personnel = :id';

        $nom = $data['nom'] ?? null;
        $prenom = $data['prenom'] ?? null;
        $mail = $data['mail'] ?? null;
        $mdp = $data['MDP'];
        $date_entree = $data['date_entree'] ?? null;
        $salaire = $data['salaire'] ?? null;
        $ID_Fonction = $data['id_fonction'] ?? null;
        $login = $data['login'] ?? null;
        $ID_Remplacant = $data['id_remplacant'] ?? null;
        $ID_Superieur = $data['id_superieur'] ?? null;

        return $this->executeModify($sql, [
            ':id' => $id,
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':mail' => $mail,
            ':MDP' => $mdp,
            ':date_entree' => $date_entree,
            ':salaire' => $salaire,
            ':ID_Fonction' => $ID_Fonction,
            ':login' => $login,
            ':ID_Remplacant' => $ID_Remplacant,
            ':ID_Superieur' => $ID_Superieur
        ]);
    }

    /**
     * Supprime un employé
     */
    public function suppr($id)
    {
        $sql = "DELETE FROM Personnel WHERE ID_Personnel = :id";
        return $this->executeModify($sql, [':id' => $id]);
    }

    public function moteurRechercheRecup($searchTerm)
    {
        /*Récupère tous les employés correspondant à un terme de recherche dans leur nom ou prénom
        */
        $sql = "SELECT * FROM Personnel WHERE LOWER(Nom) LIKE LOWER(:searchTerm) OR LOWER(Prenom) LIKE LOWER(:searchTerm) AND estArchive = 1";
        $likeTerm = '%' . $searchTerm . '%';
        return $this->executeQueryAll($sql, [':searchTerm' => $likeTerm]);
    }
}
