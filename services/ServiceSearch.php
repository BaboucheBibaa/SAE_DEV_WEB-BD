<?php

class ServiceSearch
{
    private $Animal;
    private $Espece;
    private $Zone;
    private $User;
    private $Boutique;
    private $Enclos;
    private $Fonction;
    public function __construct()
    {
        $this->Animal = new Animal();
        $this->Espece = new Espece();
        $this->Zone = new Zone();
        $this->User = new User();
        $this->Boutique = new Boutique();
        $this->Enclos = new Enclos();
        $this->Fonction = new Fonction();
    }


    public function dataMoteurRecherche($query, $filters = []){
        $liste_fonctions = $this->Fonction->getAll();
        $liste_especes = $this->Espece->getAll();
        $liste_zones = $this->Zone->getAll();
        $results = $this->recherchGlobale($query,$filters);

        return [
            'fonctions' => $liste_fonctions,
            'especes' => $liste_especes,
            'zones' => $liste_zones,
            'results' => $results
        ];
    }

    /**
     * Effectue une recherche globale intelligent selon les filtres appliqués
     * @param string $searchTerm Terme de recherche
     * @param array $filters Filtres optionnels
     * @return array|null Résultats de recherche par type ou null si pas de résultats
     */
    public function recherchGlobale($searchTerm, $filters = [])
    {
        // Si aucun terme et aucun filtre, on ne cherche rien
        if (
            empty($searchTerm)
            && empty($filters['espece'])
            && empty($filters['zone'])
            && empty($filters['type_enclos'])
            && empty($filters['poids_min'])
            && empty($filters['poids_max'])
            && empty($filters['date_naissance_min'])
            && empty($filters['date_naissance_max'])
            && empty($filters['fonction'])
        ) {
            return null;
        }

        $searchTerm = trim($searchTerm);
        $results = [];

        // Déterminer quel filtre appliquer en regardant si l'un est vide ou non
        $filtresAnimaux = !empty($filters['poids_min']) || !empty($filters['poids_max']) || 
                            !empty($filters['date_naissance_min']) || !empty($filters['date_naissance_max']) ||
                            !empty($filters['espece']);
        $filtresEmployees = !empty($filters['fonction']);
        $autresFiltres = !empty($filters['zone'])  || !empty($filters['type_enclos']);
        
        // Si un terme de recherche est présent, faire une recherche globale
        if (!empty($searchTerm)) {
            $results['animals'] = $this->Animal->moteurRechercheRecup($searchTerm, $filters);
            $results['especes'] = $this->Espece->moteurRechercheRecup($searchTerm, $filters);
            $results['zones'] = $this->Zone->moteurRechercheRecup($searchTerm, $filters);
            $results['employes'] = $this->User->moteurRechercheRecup($searchTerm, $filters);
            $results['boutiques'] = $this->Boutique->moteurRechercheRecup($searchTerm, $filters);
            $results['enclos'] = $this->Enclos->moteurRechercheRecup($searchTerm, $filters);
        } else {
            // Pas de terme de recherche : afficher uniquement les résultats des filtres appliqués
            
            // Chercher animaux si filtres animaux présents
            if ($filtresAnimaux) {
                $results['animals'] = $this->Animal->moteurRechercheRecup($searchTerm, $filters);
                if (!empty($filters['espece'])) {
                    $results['especes'] = $this->Espece->moteurRechercheRecup($searchTerm, $filters);
                }
            }
            
            // Chercher employés si filtre fonction présent
            if ($filtresEmployees) {
                $results['employes'] = $this->User->moteurRechercheRecup($searchTerm, $filters);
            }
            
            // Chercher zones, enclos si filtres présents
            if ($autresFiltres) {
                $results['zones'] = $this->Zone->moteurRechercheRecup($searchTerm, $filters);
                $results['enclos'] = $this->Enclos->moteurRechercheRecup($searchTerm, $filters);
            }
        }

        return $results;
    }
}
