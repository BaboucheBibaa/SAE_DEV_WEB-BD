<?php

class SearchController extends BaseController
{
    private $serviceSearch;
    private $serviceZone;
    private $serviceEmployee;
    private $serviceEspece;

    public function __construct()
    {
        $this->serviceSearch = new ServiceSearch();
        $this->serviceZone = new ServiceZone();
        $this->serviceEmployee = new ServiceEmployee();
        $this->serviceEspece = new ServiceEspece();
    }

    /**
     * Route la requête de recherche vers l'action appropriée
     * @return void
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
        $this->render('moteur', [
            'title' => 'Moteur de Recherche - Zoo\'land'
        ]);
    }

    /**
     * Effectue une recherche globale
     */
    private function rechercheGlobale()
    {
        $searchTerm = $_GET['q'] ?? '';

        // Filtres simples
        $filter_espece = $_GET['filter_espece'] ?? '';
        $filter_regime = $_GET['filter_regime'] ?? '';

        // filtres spécifiques
        $filter_date_naissance_min = $_GET['filter_date_naissance_min'] ?? '';
        $filter_date_naissance_max = $_GET['filter_date_naissance_max'] ?? '';
        $filter_fonction = $_GET['filter_fonction'] ?? '';

        $results = [];
        $message = '';

        // Si aucun terme ni filtre -> message
        if (
            empty($searchTerm) &&
            empty($filter_espece) &&
            empty($filter_zone) &&
            empty($filter_regime) &&
            empty($filter_date_naissance_min) &&
            empty($filter_date_naissance_max) &&
            empty($filter_fonction)
        ) {
            $message = 'Veuillez entrer un terme ou appliquer un filtre.';
        } else {
            $filters = [
                'espece' => $_GET['filter_espece'] ?? '',
                'zone' => $_GET['filter_zone'] ?? '',
                'regime' => $_GET['filter_regime'] ?? '',
                'date_naissance_min' => $_GET['filter_date_naissance_min'] ?? '',
                'date_naissance_max' => $_GET['filter_date_naissance_max'] ?? '',
                'fonction' => $_GET['filter_fonction'] ?? ''
            ];

            $results = $this->serviceSearch->recherchGlobale($_GET['q'] ?? '',$filters);
            // Compter les résultats
            $totalResults = 0;
            foreach ($results as $category) {
                if (is_array($category)) {
                    $totalResults += count($category);
                }
            }

            if ($totalResults == 0) {
                $message = 'Aucun résultat trouvé.';
            }
        }
        $fonctions = $this->serviceEmployee->getFonctions();
        $zones = $this->serviceZone->getAll();
        $especes = $this->serviceEspece->getAll();
        $this->render('moteur', [
            'title' => 'Résultats de Recherche - Zoo\'land',
            'searchTerm' => $searchTerm,
            'results' => $results,
            'message' => $message,
            'filter_espece' => $filter_espece,
            'filter_regime' => $filter_regime,
            'filter_date_naissance_min' => $filter_date_naissance_min,
            'filter_date_naissance_max' => $filter_date_naissance_max,
            'filter_fonction' => $filter_fonction,
            'zones' => $zones,
            'especes' => $especes,
            'fonctions' => $fonctions
        ]);
    }
}
