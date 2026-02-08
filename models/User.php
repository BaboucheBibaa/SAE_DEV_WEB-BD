<?php
require_once 'config/database.php';

class User {

    /**
     * Récupère un utilisateur par son login (pour l'authentification)
     */
    public static function recupParLogs($login) {
        $db = Database::getConnection();

        $stmt = $db->prepare(
            "SELECT Personnel.*, role.est_admin FROM Personnel JOIN role ON Personnel.ID_Role = role.ID_Role WHERE login = :login"
        );
        $stmt->execute([
            'login' => $login
        ]);

        return $stmt->fetch();
    }

    /**
     * Récupère un utilisateur par son ID
     */
    public static function recupParID($id) {
        $db = Database::getConnection();

        $stmt = $db->prepare(
            "SELECT Personnel.*, role.est_admin 
            FROM Personnel 
            LEFT JOIN role ON Personnel.ID_Role = role.ID_Role 
            WHERE ID_Personnel = :id"
        );

        $stmt->execute([
            'id' => $id
        ]);

        return $stmt->fetch();
    }

    /**
     * Récupère tous les employés
     */
    public static function toutRecup() {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM Personnel");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Crée un nouvel employé
     */
    public static function creer($data) {
        $db = Database::getConnection();
        $stmt = $db->prepare(
            "INSERT INTO Personnel (Nom, Prenom, mail, MDP, Date_Entree, Salaire, ID_Role, login) 
            VALUES (:nom, :prenom, :mail, :MDP, :date_entree, :salaire, :id_role, :login)"
        );
        
        return $stmt->execute([
            'nom' => $data['nom'] ?? null,
            'prenom' => $data['prenom'] ?? null,
            'mail' => $data['mail'] ?? null,
            'MDP' => $data['MDP'],
            'date_entree' => $data['date_entree'] ?? null,
            'salaire' => $data['salaire'] ?? null,
            'id_role' => $data['id_role'] ?? null,
            'login' => $data['login'] ?? null
        ]);
    }

    /**
     * Met à jour un employé
     */
    public static function maj($id, $data) {
        $db = Database::getConnection();
        $stmt = $db->prepare(
            'UPDATE Personnel 
            SET Nom = :nom, Prenom = :prenom, mail = :mail, MDP = :MDP, 
                Date_Entree = :date_entree, Salaire = :salaire, ID_Role = :id_role, login = :login 
            WHERE ID_Personnel = :id'
        );
        
        return $stmt->execute([
            'id' => $id,
            'nom' => $data['nom'] ?? null,
            'prenom' => $data['prenom'] ?? null,
            'mail' => $data['mail'] ?? null,
            'MDP' => $data['MDP'],
            'date_entree' => $data['date_entree'] ?? null,
            'salaire' => $data['salaire'] ?? null,
            'id_role' => $data['id_role'] ?? null,
            'login' => $data['login'] ?? null
        ]);
    }

    /**
     * Supprime un employé
     */
    public static function suppr($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM Personnel WHERE ID_Personnel = :id");
        return $stmt->execute(['id' => $id]);
    }

}
