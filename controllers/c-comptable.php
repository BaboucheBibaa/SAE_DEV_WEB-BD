<?php

class ComptableController extends BaseController
{
    private $serviceComptable;

    public function __construct()
    {
        $this->serviceComptable = new ServiceComptable();
    }

    /**
     * Affiche le dashboard comptable avec toutes les statistiques
     * @return void
     */
    public function dashboard(): void
    {
        $this->requireRole(COMPTABLE);
        
        $data = $this->serviceComptable->getAll();
        
        $this->render('comptable/v-dashboard', [
            'title' => 'Dashboard Comptable - Zoo\'land',
            'boutiques' => $data['boutiques'],
            'zones' => $data['zones'],
            'employes' => $data['employes']
        ]);
    }

    /**
     * Affiche les statistiques des boutiques
     * @return void
     */
    public function statsBoutiques(): void
    {
        $this->requireRole(COMPTABLE);
        
        $boutiques = $this->serviceComptable->getBoutiques();
        
        $this->render('comptable/v-stats-boutiques', [
            'title' => 'Statistiques Boutiques - Zoo\'land',
            'boutiques' => $boutiques
        ]);
    }

    /**
     * Affiche les statistiques des zones (réparations)
     * @return void
     */
    public function statsZones(): void
    {
        $this->requireRole(COMPTABLE);
        
        $zones = $this->serviceComptable->getZones();
        
        $this->render('comptable/v-stats-zones', [
            'title' => 'Statistiques Zones (Réparations) - Zoo\'land',
            'zones' => $zones
        ]);
    }

    /**
     * Affiche les statistiques de masse salariale
     * @return void
     */
    public function statsMasseSalariale(): void
    {
        $this->requireRole(COMPTABLE);
        
        $employes = $this->serviceComptable->getEmployes();
        
        $this->render('comptable/v-stats-masse-salariale', [
            'title' => 'Masse Salariale - Zoo\'land',
            'employes' => $employes
        ]);
    }
}
