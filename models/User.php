<?php
require_once 'config/database.php';

class User {

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

    public static function recupParID($id) {

        $db = Database::getConnection();

        $stmt = $db->prepare(
            "SELECT ID_Personnel, mail, Nom, Prenom, Date_Entree
            FROM Personnel
            WHERE ID_Personnel = :id"
        );

        $stmt->execute([
            'id' => $id
        ]);

        return $stmt->fetch();
    }

}
