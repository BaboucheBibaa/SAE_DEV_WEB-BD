<?php

class ServiceSearch
{
    private $Animal;
    private $Espece;
    private $Zone;
    private $User;
    private $Boutique;
    private $Enclos;
    public function __construct()
    {
        $this->Animal = new Animal();
        $this->Espece = new Espece();
        $this->Zone = new Zone();
        $this->User = new User();
        $this->Boutique = new Boutique();
        $this->Enclos = new Enclos();
    }

    /**
     * Effectue une recherche globale dans tous les modèles (animaux, espèces, zones, employés, boutiques, enclos)
     * @param string $searchTerm Terme de recherche
     * @param array $filters Filtres optionnels (espèce, zone, régime, type_enclos)
     * @return array|null Résultats de recherche par type ou null si pas de résultats
     */
    public function recherchGlobale($searchTerm, $filters = [])
    {
        // Si aucun terme et aucun filtre, on ne cherche rien
        if (
            empty($searchTerm)
            && empty($filters['espece'])
            && empty($filters['zone'])
            && empty($filters['regime'])
            && empty($filters['type_enclos'])
        ) {
            return null;
        }

        $searchTerm = trim($searchTerm);

        $results = [];

        // On transmet les filtres aux modèles
        $results['animals'] = $this->Animal->moteurRechercheRecup($searchTerm, $filters);
        $results['especes'] = $this->Espece->moteurRechercheRecup($searchTerm, $filters);
        $results['zones'] = $this->Zone->moteurRechercheRecup($searchTerm, $filters);
        $results['employes'] = $this->User->moteurRechercheRecup($searchTerm, $filters);
        $results['boutiques'] = $this->Boutique->moteurRechercheRecup($searchTerm, $filters);
        $results['enclos'] = $this->Enclos->moteurRechercheRecup($searchTerm, $filters);

        return $results;
    }
}
