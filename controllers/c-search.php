<?php

class SearchController extends BaseController
{
    private $serviceSearch;
    private $serviceZone;
    public function __construct()
    {
        $this->serviceSearch = new ServiceSearch();
        $this->serviceZone = new ServiceZone();
    }
    /**
     * Route la requête de recherche vers l'action appropriée
     * Détermine si c'est une recherche ou un affichage de la page
     * @return void Affiche la page ou les résultats
     */
    public function gererRequete(): void
    {
        $action = $_GET['search_action'] ?? 'affiche';

        if ($action === 'recherche_globale') {
            $this->rechercheGlobale();
        } else {
            $this->affichePage();
        }
    }

    /**
     * Affiche la page de recherche
     */
    private function affichePage()
    {
        $this->render('test-moteur-recherche', [
            'title' => 'Moteur de Recherche - Zoo\'land'
        ]);
    }

    /**
     * Effectue une recherche globale
     */
    private function rechercheGlobale()
    {
        $searchTerm = $_GET['q'] ?? '';

        // Filtres avancés
        $filter_espece = $_GET['filter_espece'] ?? '';
        $filter_zone = $_GET['filter_zone'] ?? '';
        $filter_regime = $_GET['filter_regime'] ?? '';
        $filter_type_enclos = $_GET['filter_type_enclos'] ?? '';

        $results = [];
        $message = '';

        // Si aucun terme ni filtre -> message
        if (
            empty($searchTerm) &&
            empty($filter_espece) &&
            empty($filter_zone) &&
            empty($filter_regime) &&
            empty($filter_type_enclos)
        ) {
            $message = 'Veuillez entrer un terme ou appliquer un filtre.';
        } else {
            $filters = [
                'espece' => $_GET['filter_espece'] ?? '',
                'zone' => $_GET['filter_zone'] ?? '',
                'regime' => $_GET['filter_regime'] ?? '',
                'type_enclos' => $_GET['filter_type_enclos'] ?? ''
            ];

            $results = $this->serviceSearch->recherchGlobale($_GET['q'] ?? '', $filters);


            // Compter les résultats
            $totalResults = 0;
            foreach ($results as $category) {
                if (is_array($category)) {
                    $totalResults += count($category);
                }
            }

            if ($totalResults === 0) {
                $message = 'Aucun résultat trouvé.';
            }
        }

        $zones = $this->serviceZone->getAll();

        $this->render('test-moteur-recherche', [
            'title' => 'Résultats de Recherche - Zoo\'land',
            'searchTerm' => $searchTerm,
            'results' => $results,
            'message' => $message,
            'filter_espece' => $filter_espece,
            'filter_zone' => $filter_zone,
            'filter_regime' => $filter_regime,
            'filter_type_enclos' => $filter_type_enclos,
            'zones' => $zones
        ]);
    }
}
