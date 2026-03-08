<?php

class ServiceSearch
{
    /**
     * Recherche globale dans les différentes tables
     * @param string $searchTerm - Terme de recherche
     * @param array $tables - Tables à rechercher (optionnel)
     * @return array - Résultats organisés par table
     */
    public static function recherchGlobale($searchTerm, $tables = null)
    {
        if (empty($searchTerm)) {
            return [];
        }

        $searchTerm = trim($searchTerm);
        
        $results = [];

        // Recherche via les modèles (retournent déjà des tableaux)
        $results['animals'] = Animal::moteurRechercheRecup($searchTerm);
        $results['especes'] = Espece::moteurRechercheRecup($searchTerm);
        $results['zones'] = Zone::moteurRechercheRecup($searchTerm);
        $results['employes'] = User::moteurRechercheRecup($searchTerm);
        $results['boutiques'] = Boutique::moteurRechercheRecup($searchTerm);

        return $results;
    }

    /**
     * Recherche avancée avec filtres
     * @param string $searchTerm - Terme de recherche
     * @param string $category - Catégorie à rechercher
     * @param array $filters - Filtres additionnels
     * @return array - Résultats filtrés
     */
    public static function recherchAvancee($searchTerm, $category, $filters = [])
    {
        $db = Database::getConnection();
        $searchTerm = trim($searchTerm);

        switch ($category) {
            case 'animal':
                return self::rechercherAnimaux($db, $searchTerm, $filters);
            case 'espece':
                return self::rechercherEspeces($db, $searchTerm, $filters);
            case 'zone':
                return self::rechercherZones($db, $searchTerm, $filters);
            case 'employe':
                return self::rechercherEmployes($db, $searchTerm, $filters);
            case 'boutique':
                return self::rechercherBoutiques($db, $searchTerm, $filters);
            default:
                return [];
        }
    }

    /**
     * Recherche spécifique pour les animaux
     */
    private static function rechercherAnimaux($db, $searchTerm, $filters)
    {
        $sql = "SELECT 
                    a.ID_ANIMAL, 
                    a.NOM_ANIMAL, 
                    a.DATE_NAISSANCE,
                    a.POIDS,
                    a.REGIME_ALIMENTAIRE,
                    e.NOM_ESPECE,
                    z.NOM_ZONE
                FROM Animal a
                LEFT JOIN Espece e ON a.ID_ESPECE = e.ID_ESPECE
                LEFT JOIN Enclos enc ON a.LATITUDE_ENCLOS = enc.LATITUDE AND a.LONGITUDE_ENCLOS = enc.LONGITUDE
                LEFT JOIN Zone z ON enc.ID_ZONE = z.ID_ZONE
                WHERE UPPER(a.NOM_ANIMAL) LIKE UPPER(:search_term)";

        if (!empty($filters['espece'])) {
            $sql .= " AND a.ID_ESPECE = :id_espece";
        }
        if (!empty($filters['zone'])) {
            $sql .= " AND z.ID_ZONE = :id_zone";
        }

        $sql .= " ORDER BY a.NOM_ANIMAL";

        $stid = oci_parse($db, $sql);
        $search_term = '%' . $searchTerm . '%';
        oci_bind_by_name($stid, ':search_term', $search_term);

        if (!empty($filters['espece'])) {
            $id_espece = $filters['espece'];
            oci_bind_by_name($stid, ':id_espece', $id_espece);
        }
        if (!empty($filters['zone'])) {
            $id_zone = $filters['zone'];
            oci_bind_by_name($stid, ':id_zone', $id_zone);
        }

        return self::fetchResults($stid);
    }

    /**
     * Recherche spécifique pour les espèces
     */
    private static function rechercherEspeces($db, $searchTerm, $filters)
    {
        $sql = "SELECT 
                    ID_ESPECE,
                    NOM_ESPECE,
                    NOM_LATIN_ESPECE,
                    EST_MENACEE,
                    (SELECT COUNT(*) FROM Animal WHERE ID_ESPECE = Espece.ID_ESPECE) as nb_animaux
                FROM Espece
                WHERE UPPER(NOM_ESPECE) LIKE UPPER(:search_term) 
                OR UPPER(NOM_LATIN_ESPECE) LIKE UPPER(:search_term)
                ORDER BY NOM_ESPECE";

        $stid = oci_parse($db, $sql);
        $search_term = '%' . $searchTerm . '%';
        oci_bind_by_name($stid, ':search_term', $search_term);

        return self::fetchResults($stid);
    }

    /**
     * Recherche spécifique pour les zones
     */
    private static function rechercherZones($db, $searchTerm, $filters)
    {
        $sql = "SELECT 
                    ID_ZONE,
                    NOM_ZONE,
                    (SELECT COUNT(*) FROM Enclos WHERE ID_ZONE = Zone.ID_ZONE) as nb_enclos,
                    (SELECT COUNT(*) FROM Animal a 
                     WHERE (a.LATITUDE_ENCLOS, a.LONGITUDE_ENCLOS) IN 
                     (SELECT LATITUDE, LONGITUDE FROM Enclos WHERE ID_ZONE = Zone.ID_ZONE)) as nb_animaux
                FROM Zone
                WHERE UPPER(NOM_ZONE) LIKE UPPER(:search_term)
                ORDER BY NOM_ZONE";

        $stid = oci_parse($db, $sql);
        $search_term = '%' . $searchTerm . '%';
        oci_bind_by_name($stid, ':search_term', $search_term);

        return self::fetchResults($stid);
    }

    /**
     * Recherche spécifique pour les employés
     */
    private static function rechercherEmployes($db, $searchTerm, $filters)
    {
        $sql = "SELECT 
                    ID_PERSONNEL,
                    NOM,
                    PRENOM,
                    MAIL,
                    f.NOM_FONCTION
                FROM Personnel u
                LEFT JOIN Fonction f ON u.ID_FONCTION = f.ID_FONCTION
                WHERE UPPER(NOM) LIKE UPPER(:search_term) 
                OR UPPER(PRENOM) LIKE UPPER(:search_term)
                OR UPPER(MAIL) LIKE UPPER(:search_term)";

        if (!empty($filters['fonction'])) {
            $sql .= " AND u.ID_FONCTION = :id_fonction";
        }

        $sql .= " ORDER BY NOM, PRENOM";

        $stid = oci_parse($db, $sql);
        $search_term = '%' . $searchTerm . '%';
        oci_bind_by_name($stid, ':search_term', $search_term);

        if (!empty($filters['fonction'])) {
            $id_fonction = $filters['fonction'];
            oci_bind_by_name($stid, ':id_fonction', $id_fonction);
        }

        return self::fetchResults($stid);
    }

    /**
     * Recherche spécifique pour les boutiques
     */
    private static function rechercherBoutiques($db, $searchTerm, $filters)
    {
        $sql = "SELECT 
                    ID_BOUTIQUE,
                    NOM_BOUTIQUE,
                    DESCRIPTION_BOUTIQUE
                FROM Boutique
                WHERE UPPER(NOM_BOUTIQUE) LIKE UPPER(:search_term)
                ORDER BY NOM_BOUTIQUE";

        $stid = oci_parse($db, $sql);
        $search_term = '%' . $searchTerm . '%';
        oci_bind_by_name($stid, ':search_term', $search_term);

        return self::fetchResults($stid);
    }

    /**
     * Récupère les résultats d'une requête exécutée
     */
    private static function fetchResults($stid)
    {
        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $results = [];
        oci_fetch_all($stid, $results, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_statement($stid);

        return $results;
    }

    /**
     * Récupère les options de filtrage (espèces, zones, fonctions)
     */
    public static function obtenirFiltres()
    {
        $db = Database::getConnection();
        $filtres = [];

        // Espèces
        $sql = "SELECT ID_ESPECE, NOM_ESPECE FROM Espece ORDER BY NOM_ESPECE";
        $stid = oci_parse($db, $sql);
        oci_execute($stid);
        oci_fetch_all($stid, $filtres['especes'], 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_statement($stid);

        // Zones
        $sql = "SELECT ID_ZONE, NOM_ZONE FROM Zone ORDER BY NOM_ZONE";
        $stid = oci_parse($db, $sql);
        oci_execute($stid);
        oci_fetch_all($stid, $filtres['zones'], 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_statement($stid);

        // Fonctions
        $sql = "SELECT ID_Fonction, Nom_Fonction FROM Fonction ORDER BY Nom_Fonction";
        $stid = oci_parse($db, $sql);
        oci_execute($stid);
        oci_fetch_all($stid, $filtres['fonctions'], 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_statement($stid);

        return $filtres;
    }
}
