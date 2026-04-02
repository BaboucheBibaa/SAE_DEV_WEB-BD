<?php

class SoigneursController extends BaseController
{
    private $serviceSoin;
    private $serviceEmployee;
    public function __construct()
    {
        $this->serviceSoin = new ServiceSoin();
        $this->serviceEmployee = new ServiceEmployee();
    }

    /**
     * Affiche le tableau de bord de l'espace soigneurs
     * Accessible uniquement aux soigneurs
     * @return void Affiche la vue d'index
     */
    public function index(): void
    {
        $this->requireRole(SOIGNEUR);
        $title = "Espace Soigneurs - Zoo'land";
        $this->render('soigneurs/v-index', ['title' => $title]);
    }

    /**
     * Affiche le formulaire d'ajout d'un soin
     * Liste les animaux du soigneur et les vétérinaires disponibles
     * @return void Affiche le formulaire
     */
    public function formCreationSoin(): void
    {
        $this->requireRole(SOIGNEUR);
        $title = "Ajouter un Soin - Zoo'land";
        $veterinaires = $this->serviceEmployee->getEmployeeParFonction(VETERINAIRE);
        $animaux = $this->serviceSoin->getAnimauxParSoigneur($_SESSION['user']['ID_PERSONNEL']);
        $this->render('soigneurs/v-formAjoutSoin', ['title' => $title, 'animaux' => $animaux, 'veterinaires' => $veterinaires]);
    }

    /**
     * Traite l'ajout d'un soin pour un animal
     * @return void Redirige avec message de succès ou erreur
     */
    public function ajoutSoin(): void
    {
        $this->requireRole(SOIGNEUR);
        $result = $this->serviceSoin->ajoutSoin();
        if ($result == 1) {
            $this->redirectWithMessage('formAjoutSoin', 'Soin ajouté avec succès.', 'success');
        } else if ($result == 2) {
            $this->redirectWithMessage('formAjoutSoin', 'Un soin a déjà été fait ce jour-ci pour cet animal.', 'error');
        } else { // null
            $this->redirectWithMessage('formAjoutSoin', "Erreur lors de l'ajout du soin.", 'error');
        }
    }
    /**
     * Affiche le formulaire d'ajout de nourriture
     * Liste les animaux du soigneur
     * @return void Affiche le formulaire
     */
    public function formCreationAjoutNourriture(): void
    {
        $this->requireRole(SOIGNEUR);
        $title = "Ajouter une Dose de Nourriture - Zoo'land";
        $animaux = $this->serviceSoin->getAnimauxParSoigneur($_SESSION['user']['ID_PERSONNEL']);
        $this->render('soigneurs/v-formAjoutNourriture', ['title' => $title, 'animaux' => $animaux]);
    }

    /**
     * Enregistre une dose de nourriture pour un animal
     * @return void Redirige avec message de succès ou erreur
     */
    public function ajoutNourriture(): void
    {
        $this->requireRole(SOIGNEUR);
        if ($this->serviceSoin->ajoutNourriture()) {
            $this->logEvent(
                'INSERTION_BD',
                "Dose de nourriture ajoutée par le soigneur id={$_SESSION['user']['ID_PERSONNEL']}"
            );
            $this->redirectWithMessage('formAjoutNourriture', 'Dose de nourriture enregistrée avec succès.', 'success');
        } else {
            $this->logEvent(
                'ERREUR',
                "Erreur lors de l'enregistrement de la dose de nourriture par le soigneur id={$_SESSION['user']['ID_PERSONNEL']}"
            );
            $this->redirectWithMessage('formAjoutNourriture', 'Erreur lors de l\'enregistrement.', 'error');
        }
    }

    /**
     * Affiche l'historique des soins du soigneur connecté
     * @return void Affiche la liste des soins
     */
    public function listerSoins(): void
    {
        $this->requireRole(SOIGNEUR);
        $title = "Historique des soins - Zoo'land";
        $soins = $this->serviceSoin->getSoinsParSoigneur($_SESSION['user']['ID_PERSONNEL']);
        $this->render('soigneurs/v-listeSoins', ['title' => $title, 'soins' => $soins]);
    }

    /**
     * Affiche les statistiques des soins par soigneur
     * @return void Affiche le graphique statistique
     */
    public function statsSoigneurs(): void
    {
        $this->requireRole(SOIGNEUR);
        $title = "Statistiques des Soigneurs - Zoo'land";
        $stats = $this->serviceSoin->getStatsSoigneurs();
        $this->render('soigneurs/v-statsSoigneurs', ['title' => $title, 'stats' => $stats]);
    }
}
