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

    /**
     * Affiche le tableau de bord du responsable de boutique
     *
     * @return void
     */
    public function afficherPage(): void
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

    /**
     * Affiche les statistiques de la boutique (CA journalier, mensuel, annuel)
     *
     * @return void
     */
    public function afficherStatsBoutique(): void
    {
        $this->requireRole(RESPBOUTIQUE);

        $user = $this->serviceEmployee->getEmployeeParID($_SESSION['user']['ID_PERSONNEL']);
        $boutique = $this->serviceBoutique->getBoutiqueParManager($_SESSION['user']['ID_PERSONNEL']);
        $caJournalier = $this->serviceCA->getCAJournalier($boutique['ID_BOUTIQUE']);
        $caMensuel = $this->serviceCA->getCAMensuel($boutique['ID_BOUTIQUE']);
        $caAnnuel = $this->serviceCA->getSommeCA($boutique['ID_BOUTIQUE'], date('Y'));
        $caMoyenAnnuel = $this->serviceCA->getMoyenneCA($boutique['ID_BOUTIQUE'],date('Y'));
        $title = "Statistiques de la boutique";
        $this->render('respBoutique/v-statsBoutique', [
            'user' => $user,
            'title' => $title,
            'boutique' => $boutique,
            'caJournalier' => $caJournalier,
            'caMensuel' => $caMensuel,
            'caAnnuel' => $caAnnuel,
            'caMoyenAnnuel' => $caMoyenAnnuel
        ]);
    }

    /**
     * Affiche le formulaire d'ajout du chiffre d'affaires journalier
     *
     * @return void
     */
    public function afficherFormCA(): void{
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

    /**
     * Traite l'ajout du chiffre d'affaires journalier avec validation des données
     *
     * @return void
     */
    public function ajoutCA(): void
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
            $this->logEvent(
                'INSERTION_BD',
                "Chiffre d'affaires journalier ajouté pour la boutique id={$boutique['ID_BOUTIQUE']} à la date {$date}"
            );

            $this->redirectWithMessage('respBoutiqueDashboard', 'Chiffre d\'affaires journalier ajouté avec succès.', 'success');
        } else {
            $this->logEvent(
                'ERREUR',
                "Erreur lors de l'ajout du chiffre d'affaires pour la boutique id={$boutique['ID_BOUTIQUE']} à la date {$date}"
            );
            $this->redirectWithMessage('creationCA', 'Erreur lors de l\'ajout du chiffre d\'affaires.', 'error');
        }
    }
}
