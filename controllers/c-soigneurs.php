<?php

class Soigneurs extends BaseController {


    public function checkSoigneur() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['ID_FONCTION'] != SOIGNEUR) {
            $this->redirectWithMessage('home', 'Accès refusé. Vous devez être connecté en tant que soigneur pour accéder à cette page.', 'error');
            exit;
        }
    }

    public function index() {
        $this->checkSoigneur();
        $title = "Espace Soigneurs - Zoo'land";
        $this->render('soigneurs/v-index', ['title' => $title]);
    }

    public function formCreationSoin() {
        $this->checkSoigneur();
        $title = "Ajouter un Soin - Zoo'land";
        $animaux = Animal::recupTousParSoigneurs($_SESSION['user']['ID_PERSONNEL']);
        $this->render('soigneurs/v-addSoin', ['title' => $title, 'animaux' => $animaux]);
    }

    public function ajoutSoin() {
        $this->checkSoigneur();
        $idAnimal = isset($_POST['ID_ANIMAL']) && $_POST['ID_ANIMAL'] !== '' ? intval($_POST['ID_ANIMAL']) : null;
        $dateSoin = $_POST['DATE_SOIN'] ?? null;
        $descriptionSoin = $_POST['DESCRIPTION_SOIN'] ?? null;
        $idPersonnel = $_SESSION['user']['ID_PERSONNEL'];

        if (!$idAnimal || !$dateSoin || !$descriptionSoin || !$idPersonnel) {
            $this->redirectWithMessage('formAjoutSoin', 'Veuillez remplir tous les champs obligatoires.', 'error');
            return null;
        }

        $data = [
            'ID_ANIMAL' => $idAnimal,
            'DATE_SOIN' => $dateSoin,
            'DESCRIPTION_SOIN' => $descriptionSoin,
            'ID_PERSONNEL' => $idPersonnel
        ];
        if (HistoriqueSoins::creer($data)) {
            $this->redirectWithMessage('form_aformAjoutSoinjout_soin', 'Soin ajouté avec succès.', 'success');
        } else {
            $this->redirectWithMessage('formAjoutSoin', 'Erreur lors de l\'ajout du soin.', 'error');
        }
    }

    public function formCreationAjoutNourriture(){
        $this->checkSoigneur();
        $title = "Ajouter la nourriture pour un animal - Zoo'land";
        $animaux = Animal::recupTousParSoigneurs($_SESSION['user']['ID_PERSONNEL']);
        $this->render('soigneurs/v-addNourriture', ['title' => $title, 'animaux' => $animaux]);
    }

    public function ajoutNourriture() {
        $this->checkSoigneur();
        $idAnimal = isset($_POST['ID_ANIMAL']) && $_POST['ID_ANIMAL'] !== '' ? intval($_POST['ID_ANIMAL']) : null;
        $dateNourrit = $_POST['DATE_NOURRIT'] ?? null;
        $doseNourriture = $_POST['DOSE_NOURRITURE'] ?? null;
        $idPersonnel = $_SESSION['user']['ID_PERSONNEL'] ?? null;

        echo "ID_ANIMAL: $idAnimal, DATE_NOURRIT: $dateNourrit, DOSE_NOURRITURE: $doseNourriture, ID_PERSONNEL: $idPersonnel"; // Debug
        if (!$idAnimal || !$dateNourrit || !$doseNourriture || !$idPersonnel) {
            $this->redirectWithMessage('formAjoutNourriture', 'Veuillez remplir tous les champs obligatoires.', 'error');
            return;
        }

        $data = [
            'ID_ANIMAL' => $idAnimal,
            'DATE_NOURRIT' => $dateNourrit,
            'DOSE_NOURRITURE' => $doseNourriture,
            'ID_PERSONNEL' => $idPersonnel
        ];
        if (HistoriqueSoins::creerNourriture($data)) {
            $this->redirectWithMessage('formAjoutNourriture', 'Dose de nourriture enregistrée avec succès.', 'success');
        } else {
            $this->redirectWithMessage('formAjoutNourriture', 'Erreur lors de l\'enregistrement.', 'error');
        }
    }

    public function listerSoins() {
        $this->checkSoigneur();
        $title = "Historique des soins - Zoo'land";
        $soins = HistoriqueSoins::recupSoinsParPersonne($_SESSION['user']['ID_PERSONNEL']);
        $this->render('soigneurs/v-listeSoins', ['title' => $title, 'soins' => $soins]);
    }

}