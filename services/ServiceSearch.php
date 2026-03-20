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
     * Recherche globale dans tous les modèles
     */
    public function recherchGlobale($searchTerm, $tables = null)
    {
        if (empty($searchTerm)) {
            return null;
        }

        $searchTerm = trim($searchTerm);

        $results = [];

        // Recherche via les modèles (retournent déjà des tableaux)
        $results['animals'] = $this->Animal->moteurRechercheRecup($searchTerm);
        $results['especes'] = $this->Espece->moteurRechercheRecup($searchTerm);
        $results['zones'] = $this->Zone->moteurRechercheRecup($searchTerm);
        $results['employes'] = $this->User->moteurRechercheRecup($searchTerm);
        $results['boutiques'] = $this->Boutique->moteurRechercheRecup($searchTerm);
        $results['enclos'] = $this->Enclos->moteurRechercheRecup($searchTerm);

        return $results;
    }
}
