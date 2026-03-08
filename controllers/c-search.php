<?php

class SearchController extends BaseController
{
    public function gererRequete()
    {
        $action = $_GET['search_action'] ?? 'affiche';

        if ($action === 'recherche_globale') {
            $this->rechercheGlobale();
        } elseif ($action === 'recherche_avancee') {
            $this->rechercheAvancee();
        } else {
            $this->affichePage();
        }
    }

    /**
     * Affiche la page de recherche
     */
    private function affichePage()
    {
        $filtres = ServiceSearch::obtenirFiltres();
        $this->render('test-moteur-recherche', [
            'title' => 'Moteur de Recherche - Zoo\'land',
            'filtres' => $filtres
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
            $results = ServiceSearch::recherchGlobale($searchTerm);
            
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

        $filtres = ServiceSearch::obtenirFiltres();
        $this->render('test-moteur-recherche', [
            'title' => 'Résultats de Recherche - Zoo\'land',
            'searchTerm' => $searchTerm,
            'results' => $results,
            'message' => $message,
            'filtres' => $filtres
        ]);
    }

    /**
     * Effectue une recherche avancée
     */
    private function rechercheAvancee()
    {
        $searchTerm = $_GET['q'] ?? '';
        $category = $_GET['category'] ?? '';
        $filters = [];

        // Récupère les filtres additionnels selon la catégorie
        if ($category === 'animal') {
            $filters['espece'] = $_GET['espece'] ?? '';
            $filters['zone'] = $_GET['zone'] ?? '';
        } elseif ($category === 'employe') {
            $filters['fonction'] = $_GET['fonction'] ?? '';
        }

        $results = [];
        $message = '';

        if (empty($searchTerm) || empty($category)) {
            $message = 'Veuillez entrer un terme de recherche et sélectionner une catégorie.';
        } else {
            $results = ServiceSearch::recherchAvancee($searchTerm, $category, $filters);

            if (count($results) === 0) {
                $message = 'Aucun résultat trouvé pour "' . htmlspecialchars($searchTerm) . '" dans la catégorie "' . htmlspecialchars($category) . '".';
            }
        }

        $filtres = ServiceSearch::obtenirFiltres();
        $this->render('test-moteur-recherche', [
            'title' => 'Recherche Avancée - Zoo\'land',
            'searchTerm' => $searchTerm,
            'selectedCategory' => $category,
            'advancedResults' => $results,
            'message' => $message,
            'filtres' => $filtres
        ]);
    }
}
