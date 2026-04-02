<?php

class ServiceComptable
{
    private $Comptable;

    public function __construct()
    {
        $this->Comptable = new Comptable();
    }

    /**
     * Récupère les statistiques de CA pour toutes les boutiques
     * @return array|null Données des boutiques avec CA moyen mensuel et annuel
     */
    public function getBoutiques()
    {
        $boutiques = $this->Comptable->getBoutiques();
        if (!$boutiques) {
            return null;
        }
        return $boutiques;
    }

    /**
     * Récupère les statistiques de coûts de réparation par zone
     * @return array|null Données des zones avec coût moyen des réparations
     */
    public function getZones()
    {
        $zones = $this->Comptable->getZones();
        if (!$zones) {
            return null;
        }
        return $zones;
    }

    /**
     * Récupère la masse salariale totale
     * @return array|null Données avec salaire total, nombre d'employés et salaire moyen
     */
    public function getEmployes()
    {
        $employes = $this->Comptable->getEmployes();
        if (!$employes) {
            return null;
        }
        return $employes;
    }

    /**
     * Récupère toutes les données comptables
     * @return array Données complètes (boutiques, zones, employés)
     */
    public function getAll()
    {
        return [
            'boutiques' => $this->getBoutiques(),
            'zones' => $this->getZones(),
            'employes' => $this->getEmployes()
        ];
    }
}
