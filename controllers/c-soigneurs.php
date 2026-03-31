<?php

class Soigneurs extends BaseController
{
    private $serviceSoin;
    private $serviceEmployee;
    public function __construct()
    {
        $this->serviceSoin = new ServiceSoin();
        $this->serviceEmployee = new ServiceEmployee();
    }

    public function index()
    {
        $this->requireRole(SOIGNEUR);
        $title = "Espace Soigneurs - Zoo'land";
        $this->render('soigneurs/v-index', ['title' => $title]);
    }

    public function formCreationSoin()
    {
        $this->requireRole(SOIGNEUR);
        $title = "Ajouter un Soin - Zoo'land";
        $veterinaires = $this->serviceEmployee->getEmployeeParFonction(VETERINAIRE);
        $animaux = $this->serviceSoin->getAnimauxParSoigneur($_SESSION['user']['ID_PERSONNEL']);
        $this->render('soigneurs/v-formAjoutSoin', ['title' => $title, 'animaux' => $animaux, 'veterinaires' => $veterinaires]);
    }

    public function ajoutSoin()
    {
        $this->requireRole(SOIGNEUR);
        $result = $this->serviceSoin->ajoutSoin();

        if ($result) {
            //$this->redirectWithMessage('formAjoutSoin', 'Soin ajouté avec succès.', 'success');
        } else {
            //$this->redirectWithMessage('formAjoutSoin', 'Erreur lors de l\'ajout du soin.', 'error');
        }
    }
    public function formCreationAjoutNourriture()
    {
        $this->requireRole(SOIGNEUR);
        $title = "Ajouter une Dose de Nourriture - Zoo'land";
        $animaux = $this->serviceSoin->getAnimauxParSoigneur($_SESSION['user']['ID_PERSONNEL']);
        $this->render('soigneurs/v-formAjoutNourriture', ['title' => $title, 'animaux' => $animaux]);
    }

    public function ajoutNourriture()
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

    public function listerSoins()
    {
        $this->requireRole(SOIGNEUR);
        $title = "Historique des soins - Zoo'land";
        $soins = $this->serviceSoin->getSoinsParSoigneur($_SESSION['user']['ID_PERSONNEL']);
        $this->render('soigneurs/v-listeSoins', ['title' => $title, 'soins' => $soins]);
    }

    public function statsSoigneurs()
    {
        $this->requireRole(SOIGNEUR);
        $title = "Statistiques des Soigneurs - Zoo'land";
        $stats = $this->serviceSoin->getStatsSoigneurs();
        $this->render('soigneurs/v-statsSoigneurs', ['title' => $title, 'stats' => $stats]);
    }
}
