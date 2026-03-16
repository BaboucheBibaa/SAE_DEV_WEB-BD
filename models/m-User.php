<?php
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

    public static function toutRecupArchive()
    {
        $db = Database::getConnection();
        $sql = "SELECT * FROM Personnel WHERE estArchive = 0"; // 1 = actif, 0 = archivé
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
    public static function toutRecupNonArchive()
    {
        $db = Database::getConnection();
        $sql = "SELECT * FROM Personnel WHERE estArchive = 1"; // 1 = actif, 0 = archivé
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
     * Récupère tous les employés archivés ou non
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
     * Récupère les employés selon le statut d'archivage
        * $estArchive = null => tous, 1 => actifs, 0 => archivés
     */
    public static function toutRecupParArchive($estArchive = null)
    {
        $db = Database::getConnection();

        if ($estArchive === null) {
            $sql = "SELECT * FROM Personnel";
            $stid = oci_parse($db, $sql);
        } else {
            $sql = "SELECT * FROM Personnel WHERE estArchive = :estArchive";
            $stid = oci_parse($db, $sql);
            oci_bind_by_name($stid, ':estArchive', $estArchive);
        }

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
     * Met à jour le statut d'archivage d'un employé
     */
    public static function majArchive($id, $estArchive)
    {
        $db = Database::getConnection();
        $sql = "UPDATE Personnel SET estArchive = :estArchive WHERE ID_Personnel = :id";
        $stid = oci_parse($db, $sql);

        oci_bind_by_name($stid, ':id', $id);
        oci_bind_by_name($stid, ':estArchive', $estArchive);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        return $r;
    }

    /**
     * Crée un nouvel employé
     */
    public static function creer($data)
    {
        $db = Database::getConnection();
        
        // Récupérer le prochain ID
        $sql_seq = "SELECT NVL(MAX(ID_PERSONNEL), 0) + 1 AS new_id FROM Personnel";
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

        return $r;
    }


    public static function majPassword($id, $newPasswordHashed)
    {
        $db = Database::getConnection();
        $sql = "UPDATE Personnel SET MDP = :MDP WHERE ID_Personnel = :id";
        $stid = oci_parse($db, $sql);

        oci_bind_by_name($stid, ':id', $id);
        oci_bind_by_name($stid, ':MDP', $newPasswordHashed);

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

    public static function moteurRechercheRecup($searchTerm)
    {
        /*Récupère tous les employés correspondant à un terme de recherche dans leur nom ou prénom
        */
        $db = Database::getConnection();
        $sql = "SELECT * FROM Personnel WHERE LOWER(Nom) LIKE LOWER(:searchTerm) OR LOWER(Prenom) LIKE LOWER(:searchTerm)";
        $stid = oci_parse($db, $sql);
        $likeTerm = '%' . $searchTerm . '%';
        oci_bind_by_name($stid, ':searchTerm', $likeTerm);
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
