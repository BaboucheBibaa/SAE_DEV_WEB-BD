<?php

/**
 * Classe de base pour tous les modèles
 * Centralise la logique OCI pour éviter la duplication de code
 */
class BaseModel
{
    /**
     * Exécute une requête OCI et retourne un seul résultat
     * 
     * @param string $query Requête SQL
     * @param array $params Tableau associatif des paramètres [':param_name' => $value]
     * @return array|false Un seule ligne ou false si aucun résultat
     */
    protected function executeQuery($query, $params = [])
    {
        $db = Database::getConnection();
        $stid = oci_parse($db, $query);

        // Bind all parameters
        foreach ($params as $key => $value) {
            oci_bind_by_name($stid, $key, $params[$key]);
        }

        // Execute
        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        return oci_fetch_assoc($stid);
    }

    /**
     * Exécute une requête OCI et retourne tous les résultats sous forme de tableau
     * 
     * @param string $query Requête SQL
     * @param array $params Tableau associatif des paramètres [':param_name' => $value]
     * @return array Tableau indexé contenant des tableaux associatifs
     */
    public function executeQueryAll($query, $params = [])
    {
        $db = Database::getConnection();
        $stid = oci_parse($db, $query);

        // Bind all parameters
        foreach ($params as $key => $value) {
            oci_bind_by_name($stid, $key, $params[$key]);
        }

        // Execute
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
     * Exécute une requête d'insertion, mise à jour ou suppression
     * Retourne true si succès, false sinon
     * 
     * @param string $query Requête SQL
     * @param array $params Tableau associatif des paramètres [':param_name' => $value]
     * @return bool Succès ou non
     */
    protected function executeModify($query, $params = [])
    {
        $db = Database::getConnection();
        $stid = oci_parse($db, $query);

        // Bind all parameters
        foreach ($params as $key => $value) {
            oci_bind_by_name($stid, $key, $params[$key]);
        }

        // Execute
        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        return $r;
    }
}
