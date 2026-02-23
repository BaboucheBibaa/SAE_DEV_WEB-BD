<?php
require_once 'config/database.php';

class FONCTION
{

    /**
     * Récupère tous les rôles (pour les listes déroulantes)
     */
    public static function recupToutesLesFonctions()
    {
        $db = Database::getConnection();

        $stid = oci_parse($db, 'SELECT ID_FONCTION, NOM_FONCTION FROM FONCTION');

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
     * Récupère l'ID d'un rôle par son nom
     */
    public static function recupIDFonctionParNom($nom_fonction)
    {
        $db = Database::getConnection();

        $sql = "SELECT ID_FONCTION FROM FONCTION WHERE NOM_FONCTION = :nom_fonction";
        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ':nom_fonction', $nom_fonction);

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
    public static function recupNomFonctionParID($id_fonction)
    {
        $db = Database::getConnection();

        $sql = "SELECT NOM_FONCTION FROM FONCTION WHERE ID_FONCTION = :id_fonction";
        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ':id_fonction', $id_fonction);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        $result = oci_fetch_assoc($stid);

        // Si aucun résultat, retourner un tableau vide pour éviter les erreurs
        return $result ? $result : ['NOM_FONCTION' => ''];
    }

}
