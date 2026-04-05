<?php

class ServiceAffectationZone
{
    private $affectationZone;
    private $employee;
    private $zone;

    public function __construct()
    {
        $this->affectationZone = new AffectationZone();
        $this->employee = new User();
        $this->zone = new Zone();
    }

    /**
     * Prépare les données pour le formulaire d'ajout
     */
    public function dataCreationAffectationZone()
    {
        $zones = $this->zone->getAll();
        $personnels = $this->employee->getParFonction(ENTRETIEN);

        return [
            'zones' => $zones,
            'personnels' => $personnels,
            'title' => 'Affecter du personnel d\'entretien à des zones'
        ];
    }

    /**
     * Ajoute un personnel à une zone
     * Retourne: 'zone' | 'personnel' | 'existe' | 'erreur' | 1 (succès)
     */
    public function ajoutAffectationZone()
    {
        // Validation des entrées
        $id_zone = $_POST['id_zone'] ?? null;
        $id_personnel = $_POST['id_personnel'] ?? null;

        if (!$id_zone || !is_numeric($id_zone)) {
            return 'zone';
        }

        if (!$id_personnel || !is_numeric($id_personnel)) {
            return 'personnel';
        }

        // Vérifier que l'affectation n'existe pas déjà
        if ($this->affectationZone->exists($id_zone, $id_personnel)) {
            return 'existe';
        }

        // Ajouter l'affectation
        $result = $this->affectationZone->ajouter($id_zone, $id_personnel);

        return $result ? 1 : 'erreur';
    }

    /**
     * Supprime l'affectation d'un personnel à une zone
     */
    public function supprimer($id_zone, $id_personnel)
    {
        return $this->affectationZone->supprimer($id_zone, $id_personnel);
    }
}
