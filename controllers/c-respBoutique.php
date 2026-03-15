<?php
class RespBoutiqueController extends BaseController
{
    private $serviceEmployee;
    private $serviceBoutique;

    public function __construct()
    {
        $this->serviceEmployee = new ServiceEmployee();
        $this->serviceBoutique = new ServiceBoutique();
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
}