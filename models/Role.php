<?php
require_once 'config/database.php';

class Role
{

    /**
     * Récupère tous les rôles (pour les listes déroulantes)
     */
    public static function recupTousLesRoles()
    {
        $db = Database::getConnection();

        $stid = oci_parse($db, 'SELECT ID_ROLE, NOM_ROLE FROM ROLE');

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        
        // oci_fetch_all avec OCI_FETCHSTATEMENT_BY_ROW retourne un tableau de lignes
        $result = [];
        oci_fetch_all($stid, $result, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        return $result;
    }
    /**
     * Récupère l'ID d'un rôle par son nom
     */
    public static function recupIDRoleParNom($nom_role)
    {
        $db = Database::getConnection();

        $sql = "SELECT ID_ROLE FROM role WHERE NOM_ROLE = :nom_role";
        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ':nom_role', $nom_role);
        
        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        
        return oci_fetch_assoc($stid);
    }

    /**
     * Récupère le nom d'un rôle par son ID
     */
    public static function recupNomRoleParID($id_role)
    {
        $db = Database::getConnection();

        $sql = "SELECT NOM_ROLE FROM ROLE WHERE ID_ROLE = :id_role";
        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ':id_role', $id_role);
        
        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
                $result = oci_fetch_assoc($stid);
        
        // Si aucun résultat, retourner un tableau vide pour éviter les erreurs
        return $result ? $result : ['NOM_ROLE' => ''];
    }
}
