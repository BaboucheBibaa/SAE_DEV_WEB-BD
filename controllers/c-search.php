<?php

class SearchController extends BaseController
{
    private $serviceSearch;
    public function __construct()
    {
        $this->serviceSearch = new ServiceSearch();
    }
    public function gererRequete()
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
        $results = [];
        $message = '';

        if (empty($searchTerm)) {
            $message = 'Veuillez entrer un terme de recherche.';
        } else {
            $results = $this->serviceSearch->recherchGlobale($searchTerm);
            
            // Compte le total de résultats
            $totalResults = 0;
            foreach ($results as $category) {
                if (is_array($category)) {
                    $totalResults += count($category);
                }
            }

            if ($totalResults === 0) {
                $message = 'Aucun résultat trouvé pour "' . htmlspecialchars($searchTerm) . '".';
            }
        }

        $this->render('test-moteur-recherche', [
            'title' => 'Résultats de Recherche - Zoo\'land',
            'searchTerm' => $searchTerm,
            'results' => $results,
            'message' => $message
        ]);
    }
}
