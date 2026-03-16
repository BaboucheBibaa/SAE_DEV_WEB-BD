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
        $title = "Statistiques de la boutique";
        $this->render('respBoutique/v-statsBoutique', [
            'user' => $user,
            'title' => $title,
            'boutique' => $boutique,
            'caJournalier' => $caJournalier,
            'caMensuel' => $caMensuel
        ]);
    }
}
