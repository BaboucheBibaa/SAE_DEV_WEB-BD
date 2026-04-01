<?php

/**
 * Classe de base pour tous les modèles
 * Centralise la logique OCI pour éviter la duplication de code
 */
abstract class BaseModel
{
    /**
     * Exécute une requête OCI et retourne un seul résultat
     * 
     * @param string $query SQL query with named parameters
     * @param array $params Associative array of parameters [':param_name' => $value]
     * @return array|false Single row or false if no result
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
     * @param string $query SQL query with named parameters
     * @param array $params Associative array of parameters [':param_name' => $value]
     * @return array Array of rows
     */
    protected function executeQueryAll($query, $params = [])
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
     * @param string $query SQL query with named parameters
     * @param array $params Associative array of parameters [':param_name' => $value]
     * @return bool Success status
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

    /**
     * Variante de bind pour les références (requises par OCI)
     * À utiliser dans les cas complexes si nécessaire
     * 
     * @param resource $stid Statement ID from oci_parse
     * @param string $bindName Parameter name (ex: ':id')
     * @param mixed $value Value to bind
     */
    protected function bindParam(&$stid, $bindName, &$value)
    {
        oci_bind_by_name($stid, $bindName, $value);
    }
}
