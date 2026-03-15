<?php

class ServiceSearch
{
    /**
     * Recherche globale dans tous les modèles
     */
    public static function recherchGlobale($searchTerm, $tables = null)
    {
        if (empty($searchTerm)) {
            return null;
        }

        $searchTerm = trim($searchTerm);

        $results = [];

        // Recherche via les modèles (retournent déjà des tableaux)
        $results['animals'] = Animal::moteurRechercheRecup($searchTerm);
        $results['especes'] = Espece::moteurRechercheRecup($searchTerm);
        $results['zones'] = Zone::moteurRechercheRecup($searchTerm);
        $results['employes'] = User::moteurRechercheRecup($searchTerm);
        $results['boutiques'] = Boutique::moteurRechercheRecup($searchTerm);
        $results['enclos'] = Enclos::moteurRechercheRecup($searchTerm);

        return $results;
    }
}
