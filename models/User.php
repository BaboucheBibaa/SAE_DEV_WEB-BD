<?php
require_once 'config/database.php';

class User {

    /**
     * Récupère un utilisateur par son login (pour l'authentification)
     */
    public static function recupParLogs($login) {
        $db = Database::getConnection();

        // Oracle : les noms de colonnes sont insensibles à la casse dans les requêtes
        // mais retournés en MAJUSCULES dans le résultat
        $query = "SELECT Personnel.*, role.est_admin FROM Personnel LEFT JOIN role ON Personnel.ID_Role = role.ID_Role WHERE LOGIN = :login";
        $stid = oci_parse($db, $query);
        oci_bind_by_name($stid, ':login', $login);
        
        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        return oci_fetch_assoc($stid);
    }

    /**
     * Récupère un utilisateur par son ID
     */
    public static function recupParID($id) {
        $db = Database::getConnection();

        $sql = "SELECT Personnel.*, role.est_admin 
            FROM Personnel 
            LEFT JOIN role ON Personnel.ID_Role = role.ID_Role 
            WHERE ID_Personnel = :id";
        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ':id', $id);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        return oci_fetch_assoc($stid);
    }

    /**
     * Récupère tous les employés
     */
    public static function toutRecup() {
        $db = Database::getConnection();
        $sql = "SELECT * FROM Personnel";
        $stid = oci_parse($db, $sql);
        
        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        
        $result = [];
        oci_fetch_all($stid, $result, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        return $result;
    }

    /**
     * Crée un nouvel employé
     */
    public static function creer($data) {
        $db = Database::getConnection();
        $sql = "INSERT INTO Personnel (Nom, Prenom, mail, MDP, Date_Entree, Salaire, ID_Role, login) 
            VALUES (:nom, :prenom, :mail, :MDP, :date_entree, :salaire, :id_role, :login)";
        $stid = oci_parse($db, $sql);
        
        $nom = $data['nom'] ?? null;
        $prenom = $data['prenom'] ?? null;
        $mail = $data['mail'] ?? null;
        $mdp = $data['MDP'];
        $date_entree = $data['date_entree'] ?? null;
        $salaire = $data['salaire'] ?? null;
        $id_role = $data['id_role'] ?? null;
        $login = $data['login'] ?? null;
        
        oci_bind_by_name($stid, ':nom', $nom);
        oci_bind_by_name($stid, ':prenom', $prenom);
        oci_bind_by_name($stid, ':mail', $mail);
        oci_bind_by_name($stid, ':MDP', $mdp);
        oci_bind_by_name($stid, ':date_entree', $date_entree);
        oci_bind_by_name($stid, ':salaire', $salaire);
        oci_bind_by_name($stid, ':id_role', $id_role);
        oci_bind_by_name($stid, ':login', $login);
        
        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        
        return $r;
    }

    /**
     * Met à jour un employé
     */
    public static function maj($id, $data) {
        $db = Database::getConnection();
        $sql = 'UPDATE Personnel 
            SET Nom = :nom, Prenom = :prenom, mail = :mail, MDP = :MDP, 
                Date_Entree = :date_entree, Salaire = :salaire, ID_Role = :id_role, login = :login 
            WHERE ID_Personnel = :id';
        $stid = oci_parse($db, $sql);
        
        $nom = $data['nom'] ?? null;
        $prenom = $data['prenom'] ?? null;
        $mail = $data['mail'] ?? null;
        $mdp = $data['MDP'];
        $date_entree = $data['date_entree'] ?? null;
        $salaire = $data['salaire'] ?? null;
        $id_role = $data['id_role'] ?? null;
        $login = $data['login'] ?? null;
        
        oci_bind_by_name($stid, ':id', $id);
        oci_bind_by_name($stid, ':nom', $nom);
        oci_bind_by_name($stid, ':prenom', $prenom);
        oci_bind_by_name($stid, ':mail', $mail);
        oci_bind_by_name($stid, ':MDP', $mdp);
        oci_bind_by_name($stid, ':date_entree', $date_entree);
        oci_bind_by_name($stid, ':salaire', $salaire);
        oci_bind_by_name($stid, ':id_role', $id_role);
        oci_bind_by_name($stid, ':login', $login);
        
        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        
        return $r;
    }

    /**
     * Supprime un employé
     */
    public static function suppr($id) {
        $db = Database::getConnection();
        $sql = "DELETE FROM Personnel WHERE ID_Personnel = :id";
        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ':id', $id);
        
        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        
        return $r;
    }

}
