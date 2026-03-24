<?php

class PersonnelEntretienController extends BaseController
{
    private $serviceReparation;

    public function __construct()
    {
        $this->serviceReparation = new ServiceReparation();
    }

    public function dashboard()
    {
        $this->requireRole(ENTRETIEN);
        $title = "Espace Personnel d'Entretien - Zoo'land";
        $this->render('personnelEntretien/v-dashboard', ['title' => $title]);
    }

    public function formAjoutEntretien() {
        $this->requireRole(ENTRETIEN);
        $title = "Ajouter une Tâche d'Entretien - Zoo'land";
        $this->render('personnelEntretien/v-formAjoutEntretien', ['title' => $title]);
    }

    public function ajoutEntretien()
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

    public function supprimerEntretien()
    {
        // Logique pour supprimer une tâche d'entretien
        $this->logEvent(
            'DELETE_BD',
            "Tâche d'entretien supprimée"
        );
    }

    public function listerEntretiens()
    {
        $this->requireRole(ENTRETIEN);
        $title = "Liste des Entretiens - Zoo'land";
        $reparations = $this->serviceReparation->getReparationsParPersonnel($_SESSION['user']['ID_PERSONNEL']);
        $this->render('personnelEntretien/v-listeEntretiens', ['title' => $title, 'reparations' => $reparations]);
    }
}
