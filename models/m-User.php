<?php
require_once 'config/database.php';

class User
{

    /**
     * Récupère un utilisateur par son login (pour l'authentification)
     */
    public static function recupParLogs($login)
    {
        $db = Database::getConnection();

        $query = "SELECT Personnel.*, Fonction.ID_Fonction FROM Personnel LEFT JOIN Fonction ON Personnel.ID_Fonction = Fonction.ID_Fonction WHERE LOGIN = :login";
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
    public static function recupParID($id)
    {
        $db = Database::getConnection();

        $sql = "SELECT Personnel.*, Fonction.ID_Fonction, Fonction.Nom_Fonction
            FROM Personnel 
            LEFT JOIN Fonction ON Personnel.ID_Fonction = Fonction.ID_Fonction 
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
    public static function toutRecup()
    {
        $db = Database::getConnection();
        $sql = "SELECT * FROM Personnel";
        $stid = oci_parse($db, $sql);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $result = [];
        //OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC sont des constantes qui définissent le comportement du tableau retourné dans $result
        //la première constante fait en sorte qu'elle soit sous la forme d'un seul tableau et la 2eme fait en sorte que les index soient associatifs (clé => valeur)
        oci_fetch_all($stid, $result, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        return $result;
    }

    /**
     * Crée un nouvel employé
     */
    public static function creer($data)
    {
        $db = Database::getConnection();
        
        // Récupérer le prochain ID de la séquence
        $sql_seq = "SELECT seq_personnel.NEXTVAL AS new_id FROM DUAL";
        $stid_seq = oci_parse($db, $sql_seq);
        oci_execute($stid_seq);
        $row = oci_fetch_assoc($stid_seq);
        $new_id = $row['NEW_ID'];
        
        $sql = "INSERT INTO Personnel (ID_Personnel, Nom, Prenom, Mail, MDP, Date_Entree, Salaire, ID_Fonction, LOGIN, ID_Remplacant, ID_Superieur) 
            VALUES (:id_personnel, :nom, :prenom, :mail, :MDP, TO_DATE(:date_entree, 'YYYY-MM-DD'), :salaire, :ID_Fonction, :login, :ID_Remplacant, :ID_Superieur)";
        $stid = oci_parse($db, $sql);

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

        oci_bind_by_name($stid, ':id_personnel', $new_id);
        oci_bind_by_name($stid, ':nom', $nom);
        oci_bind_by_name($stid, ':prenom', $prenom);
        oci_bind_by_name($stid, ':mail', $mail);
        oci_bind_by_name($stid, ':MDP', $mdp);
        oci_bind_by_name($stid, ':date_entree', $date_entree);
        oci_bind_by_name($stid, ':salaire', $salaire);
        oci_bind_by_name($stid, ':ID_Fonction', $ID_Fonction);
        oci_bind_by_name($stid, ':login', $login);
        oci_bind_by_name($stid, ':ID_Remplacant', $ID_Remplacant);
        oci_bind_by_name($stid, ':ID_Superieur', $ID_Superieur);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        oci_commit($db);
        return $new_id;
    }

    /**
     * Met à jour un employé
     */
    public static function maj($id, $data)
    {
        $db = Database::getConnection();
        $sql = 'UPDATE Personnel 
            SET Nom = :nom, Prenom = :prenom, Mail = :mail, MDP = :MDP, 
                Date_Entree = TO_DATE(:date_entree, \'YYYY-MM-DD\'), Salaire = :salaire, ID_Fonction = :ID_Fonction, LOGIN = :login, 
                ID_Remplacant = :ID_Remplacant, ID_Superieur = :ID_Superieur 
            WHERE ID_Personnel = :id';
        $stid = oci_parse($db, $sql);

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

        oci_bind_by_name($stid, ':id', $id);
        oci_bind_by_name($stid, ':nom', $nom);
        oci_bind_by_name($stid, ':prenom', $prenom);
        oci_bind_by_name($stid, ':mail', $mail);
        oci_bind_by_name($stid, ':MDP', $mdp);
        oci_bind_by_name($stid, ':date_entree', $date_entree);
        oci_bind_by_name($stid, ':salaire', $salaire);
        oci_bind_by_name($stid, ':ID_Fonction', $ID_Fonction);
        oci_bind_by_name($stid, ':login', $login);
        oci_bind_by_name($stid, ':ID_Remplacant', $ID_Remplacant);
        oci_bind_by_name($stid, ':ID_Superieur', $ID_Superieur);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        return $r;
    }

    /**
     * Met à jour uniquement le remplaçant d'un employé
     */
    public static function majRemplacant($id, $id_remplacant)
    {
        $db = Database::getConnection();
        $sql = 'UPDATE Personnel SET ID_Remplacant = :id_remplacant WHERE ID_Personnel = :id';
        $stid = oci_parse($db, $sql);

        oci_bind_by_name($stid, ':id', $id);
        oci_bind_by_name($stid, ':id_remplacant', $id_remplacant);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        oci_commit($db);
        return $r;
    }

    /**
     * Supprime un employé
     */
    public static function suppr($id)
    {
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


    public static function recupTousLesEmployeesMetier($id_fonction)
    {
        /*Récupère tous les employés d'une fonction donnée (ex: tous les responsables de zone)
        */
        $db = Database::getConnection();
        $sql = "SELECT * FROM Personnel WHERE ID_Fonction = :id_fonction";
        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ':id_fonction', $id_fonction);
        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        $result = [];
        oci_fetch_all($stid, $result, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        return $result;
    }

    public static function recupPersonnelDeZone($id_zone)
    {
        /*Récupère tous les employés d'une zone donnée via la table Est_Affectee_A
        */
        $db = Database::getConnection();
        $sql = "SELECT Personnel.* 
                FROM Personnel
                JOIN Est_Affectee_A ON Personnel.ID_Personnel = Est_Affectee_A.ID_Personnel 
                WHERE Est_Affectee_A.ID_Zone = :id_zone";
        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ':id_zone', $id_zone);
        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        $result = [];
        oci_fetch_all($stid, $result, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        return $result;
    }

    
}
