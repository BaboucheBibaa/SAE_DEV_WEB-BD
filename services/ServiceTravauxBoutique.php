<?php

class ServiceTravauxBoutique
{
    private $travauxBoutique;
    private $employee;
    private $boutique;

    public function __construct()
    {
        $this->travauxBoutique = new TravauxBoutique();
        $this->employee = new User();
        $this->boutique = new Boutique();
    }

    /**
     * Récupère tous les travaux boutique
     */
    public function getAll()
    {
        return $this->travauxBoutique->getAll();
    }

    /**
     * Récupère les employés assignés à une boutique
     */
    public function getParBoutique($id_boutique)
    {
        return $this->travauxBoutique->getParBoutique($id_boutique);
    }

    /**
     * Récupère les boutiques auxquelles un employé est assigné
     */
    public function getParEmploye($id_personnel)
    {
        return $this->travauxBoutique->getParEmploye($id_personnel);
    }

    /**
     * Prépare les données pour le formulaire d'ajout
     */
    public function dataCreationTravauxBoutique()
    {
        $boutiques = $this->boutique->getAll();
        $employees = $this->employee->getParFonction(EMPLOYEE_BOUTIQUE);

        return [
            'boutiques' => $boutiques,
            'employees' => $employees,
            'title' => 'Assigner des employés aux boutiques'
        ];
    }

    /**
     * Ajoute un employé à une boutique
     * Retourne: 'boutique' | 'personnel' | 'existe' | 'erreur' | 1 (succès)
     */
    public function ajoutTravauxBoutique()
    {
        // Validation des entrées
        $id_boutique = $_POST['id_boutique'] ?? null;
        $id_personnel = $_POST['id_personnel'] ?? null;

        if (!$id_boutique || !is_numeric($id_boutique)) {
            return 'boutique';
        }

        if (!$id_personnel || !is_numeric($id_personnel)) {
            return 'personnel';
        }

        // Vérifier que l'assignation n'existe pas déjà
        if ($this->travauxBoutique->exists($id_boutique, $id_personnel)) {
            return 'existe';
        }

        // Ajouter l'assignation
        $result = $this->travauxBoutique->ajouter($id_boutique, $id_personnel);

        return $result ? 1 : 'erreur';
    }

    /**
     * Supprime l'assignation d'un employé à une boutique
     */
    public function supprimer($id_boutique, $id_personnel)
    {
        return $this->travauxBoutique->supprimer($id_boutique, $id_personnel);
    }
}
