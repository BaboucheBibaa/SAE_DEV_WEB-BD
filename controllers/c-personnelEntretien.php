<?php

class PersonnelEntretienController extends BaseController
{
    private $serviceReparation;

    public function __construct()
    {
        $this->serviceReparation = new ServiceReparation();
    }

    /**
     * Affiche le tableau de bord du personnel d'entretien
     *
     * @return void
     */
    public function dashboard(): void
    {
        $this->requireRole(ENTRETIEN);
        $title = "Espace Personnel d'Entretien - Zoo'land";
        $this->render('personnelEntretien/v-dashboard', ['title' => $title]);
    }

    /**
     * Affiche le formulaire d'ajout d'une tâche d'entretien
     *
     * @return void
     */
    public function formAjoutEntretien(): void {
        $this->requireRole(ENTRETIEN);
        $title = "Ajouter une Tâche d'Entretien - Zoo'land";
        $this->render('personnelEntretien/v-formAjoutEntretien', ['title' => $title]);
    }

    /**
     * Traite l'ajout d'une nouvelle tâche d'entretien
     *
     * @return void
     */
    public function ajoutEntretien(): void
    {
        $this->requireRole(ENTRETIEN);
        if ($this->serviceReparation->ajoutEntretien()) {
            $this->logEvent(
                'INSERTION_BD',
                "Nouvelle tâche d'entretien ajoutée"
            );
            $this->redirectWithMessage('formAjoutEntretien', 'Entretien enregistre avec succes.', 'success');
        } else {
            $this->logEvent(
                'ERREUR',
                "Erreur lors de l'enregistrement de l'entretien"
            );
            $this->redirectWithMessage('formAjoutEntretien', 'Erreur lors de l\'enregistrement de l\'entretien.', 'error');
        }
    }

    /**
     * Supprime une tâche d'entretien
     *
     * @return void
     */
    public function supprimerEntretien(): void
    {
        // Logique pour supprimer une tâche d'entretien
        $this->logEvent(
            'DELETE_BD',
            "Tâche d'entretien supprimée"
        );
    }

    /**
     * Affiche la liste des tâches d'entretien du personnel connecté
     *
     * @return void
     */
    public function listerEntretiens(): void
    {
        $this->requireRole(ENTRETIEN);
        $title = "Liste des Entretiens - Zoo'land";
        $reparations = $this->serviceReparation->getReparationsParPersonnel($_SESSION['user']['ID_PERSONNEL']);
        $this->render('personnelEntretien/v-listeEntretiens', ['title' => $title, 'reparations' => $reparations]);
    }
}
