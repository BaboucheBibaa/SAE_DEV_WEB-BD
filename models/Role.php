<?php
require_once 'config/database.php';

class Role {

    /**
     * Récupère un utilisateur par son login (pour l'authentification)
     */
    public static function recupTousLesRoles() {
        $db = Database::getConnection();

        $stmt = $db->prepare(
            "SELECT Nom_Role FROM role"
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function recupIDRoleParNom($nom_role) {
        $db = Database::getConnection();

        $stmt = $db->prepare(
            "SELECT ID_Role FROM role WHERE Nom_Role = :nom_role"
        );
        $stmt->execute([
            'nom_role' => $nom_role
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function recupNomRoleParID($id_role) {
        $db = Database::getConnection();

        $stmt = $db->prepare(
            "SELECT Nom_Role FROM role WHERE ID_Role = :id_role"
        );
        $stmt->execute([
            'id_role' => $id_role
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
