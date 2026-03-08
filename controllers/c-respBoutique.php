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

    private function checkRespBoutique(): void
    {
        if (empty($_SESSION['user'])) {
            header('Location: index.php?action=afficheConnexion');
            exit;
        }
        if (!isset($_SESSION['user']['ID_FONCTION']) || $_SESSION['user']['ID_FONCTION'] != RESPBOUTIQUE) {
            header('Location: index.php?action=profil');
            exit;
        }
    }

    public function afficherPage()
    {
        $this->checkRespBoutique();

        // Récupérer les informations de l'utilisateur connecté
        $user = User::recupParID($_SESSION['user']['ID_PERSONNEL']);
        // Récupérer la boutique dont l'utilisateur est le manager
        $boutique = Boutique::recupParManager($user['ID_PERSONNEL']);

        // Récupérer les employés de cette boutique
        $employes = [];
        if ($boutique) {
            $employes = Boutique::recupEmployeesBoutique($boutique['ID_BOUTIQUE']);
        }

        $title = "Dashboard Responsable de Boutique";
        $this->render('resp_boutique/v-dashboard', [
            'user' => $user,
            'title' => $title,
            'boutique' => $boutique,
            'employes' => $employes
        ]);
    }
}
?>