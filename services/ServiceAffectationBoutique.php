<?php

class ServiceAffectationBoutique
{
    private $affectationBoutique;
    private $employee;
    private $boutique;

    public function __construct()
    {
        $this->affectationBoutique = new AffectationBoutique();
        $this->employee = new User();
        $this->boutique = new Boutique();
    }


    /**
     * Prépare les données pour le formulaire d'ajout
     */
    public function dataCreationEmployeeBoutique()
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
    public function ajoutEmployeeBoutique()
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
        if ($this->affectationBoutique->exists($id_boutique, $id_personnel)) {
            return 'existe';
        }

        // Ajouter l'assignation
        $result = $this->affectationBoutique->ajouter($id_boutique, $id_personnel);

        return $result ? 1 : 'erreur';
    }

    /**
     * Supprime l'assignation d'un employé à une boutique
     */
    public function supprimer($id_boutique, $id_personnel)
    {
        return $this->affectationBoutique->supprimer($id_boutique, $id_personnel);
    }
}
