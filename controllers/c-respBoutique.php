<?php
class RespBoutiqueController extends BaseController
{
    private $serviceEmployee;
    private $serviceBoutique;
    private $serviceCA;

    public function __construct()
    {
        $this->serviceEmployee = new ServiceEmployee();
        $this->serviceBoutique = new ServiceBoutique();
        $this->serviceCA = new ServiceCA();
    }

    public function afficherPage()
    {
        $this->requireRole(RESPBOUTIQUE);

        // Récupérer les informations de l'utilisateur connecté
        $user = $this->serviceEmployee->getEmployeeParID($_SESSION['user']['ID_PERSONNEL']);
        // Récupérer la boutique dont l'utilisateur est le manager
        $boutique = $this->serviceBoutique->getBoutiqueParManager($_SESSION['user']['ID_PERSONNEL']);

        // Récupérer les employés de cette boutique
        $employes = [];
        if ($boutique) {
            $employes = $this->serviceBoutique->getEmployeesParBoutique($boutique['ID_BOUTIQUE']);
        }

        $title = "Dashboard Responsable de Boutique";
        $this->render('respBoutique/v-dashboard', [
            'user' => $user,
            'title' => $title,
            'boutique' => $boutique,
            'employes' => $employes
        ]);
    }

    public function afficherStatsBoutique()
    {
        $this->requireRole(RESPBOUTIQUE);

        $user = $this->serviceEmployee->getEmployeeParID($_SESSION['user']['ID_PERSONNEL']);
        $boutique = $this->serviceBoutique->getBoutiqueParManager($_SESSION['user']['ID_PERSONNEL']);
        $caJournalier = $this->serviceCA->getCAJournalier($boutique['ID_BOUTIQUE']);
        $caMensuel = $this->serviceCA->getCAMensuel($boutique['ID_BOUTIQUE']);
        $caAnnuel = $this->serviceCA->sommeCA($boutique['ID_BOUTIQUE'], date('Y'));
        $caMoyenAnnuel = $this->serviceCA->moyenneCA($boutique['ID_BOUTIQUE'],date('Y'));
        $caMoyenGlobal = $this->serviceCA->moyenneCA($boutique['ID_BOUTIQUE']);
        $minMaxAnnuel = $this->serviceCA->minMaxCA($boutique['ID_BOUTIQUE']);
        $minMaxGlobal = $this->serviceCA->minMaxCA($boutique['ID_BOUTIQUE']);
        $title = "Statistiques de la boutique";
        $this->render('respBoutique/v-statsBoutique', [
            'user' => $user,
            'title' => $title,
            'boutique' => $boutique,
            'caJournalier' => $caJournalier,
            'caMensuel' => $caMensuel,
            'caAnnuel' => $caAnnuel,
            'caMoyenAnnuel' => $caMoyenAnnuel,
            'minMaxAnnuel' => $minMaxAnnuel,
            'caMoyenGlobal' => $caMoyenGlobal,
            'minMaxGlobal' => $minMaxGlobal

        ]);
    }

    public function afficherFormCA(){
        $this->requireRole(RESPBOUTIQUE);

        $user = $this->serviceEmployee->getEmployeeParID($_SESSION['user']['ID_PERSONNEL']);
        $boutique = $this->serviceBoutique->getBoutiqueParManager($_SESSION['user']['ID_PERSONNEL']);
        $title = "Ajouter le chiffre d'affaires du jour";
        $this->render('respBoutique/v-creationCA', [
            'user' => $user,
            'title' => $title,
            'boutique' => $boutique
        ]);
    }

    public function ajoutCA()
    {
        $this->requireRole(RESPBOUTIQUE);

        $boutique = $this->serviceBoutique->getBoutiqueParManager($_SESSION['user']['ID_PERSONNEL']);
        if (empty($boutique['ID_BOUTIQUE'])) {
            $this->redirectWithMessage('respBoutiqueDashboard', 'Aucune boutique n\'est associée à votre compte.', 'error');
        }

        $date = $_POST['date_ca'] ?? '';
        $montant = $_POST['montant_ca'] ?? '';

        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            $this->redirectWithMessage('creationCA', 'Date invalide.', 'error');
        }

        if (!is_numeric($montant) || (float) $montant < 0) {
            $this->redirectWithMessage('creationCA', 'Le montant doit être un nombre positif ou nul.', 'error');
        }

        if ($this->serviceCA->existeCA($boutique['ID_BOUTIQUE'], $date)) {
            $this->redirectWithMessage('creationCA', 'Un chiffre d\'affaires existe déjà pour cette date.', 'error');
        }

        $data = [
            'id_boutique' => $boutique['ID_BOUTIQUE'],
            'date' => $date,
            'montant' => (float) $montant
        ];

        if ($this->serviceCA->ajoutCA($data)) {
            $this->redirectWithMessage('respBoutiqueDashboard', 'Chiffre d\'affaires journalier ajouté avec succès.', 'success');
        }

        $this->redirectWithMessage('creationCA', 'Erreur lors de l\'ajout du chiffre d\'affaires.', 'error');
    }
}
