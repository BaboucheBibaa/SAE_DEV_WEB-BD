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
    public function formAjoutEntretien(): void
    {
        $this->requireRole(ENTRETIEN);
        $prestataires = $this->serviceReparation->getAllPrestataires();
        $title = "Ajouter une Tâche d'Entretien - Zoo'land";
        $this->render('personnelEntretien/v-formAjoutEntretien', [
            'title' => $title,
            'prestataires' => $prestataires
        ]);
    }

    /**
     * Traite l'ajout d'une nouvelle tâche d'entretien
     *
     * @return void
     */
    public function ajoutEntretien(): void
    {
        $this->requireRole(ENTRETIEN);
        $result = $this->serviceReparation->ajoutEntretien();

        switch ($result) {
            case 'nature':
                $this->redirectWithMessage('formAjoutEntretien', 'Erreur : Nature de la réparation requise.', 'error');
                break;
            case 'cout':
                $this->redirectWithMessage('formAjoutEntretien', 'Erreur : Coût invalide (doit être numérique positif).', 'error');
                break;
            case 1:
            case true:
                $this->logEvent(
                    'INSERTION_BD',
                    "Nouvelle tâche d'entretien ajoutée"
                );
                $this->redirectWithMessage('formAjoutEntretien', 'Entretien enregistre avec succes.', 'success');
                break;
            case 0:
            case false:
            default:
                $this->logEvent(
                    'ERREUR',
                    "Erreur lors de l'enregistrement de l'entretien"
                );
                $this->redirectWithMessage('formAjoutEntretien', 'Erreur lors de l\'enregistrement de l\'entretien.', 'error');
                break;
        }
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
        $this->render('personnelEntretien/v-listeEntretiens', [
            'title' => $title,
            'reparations' => $reparations
        ]);
    }
}
