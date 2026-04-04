<?php

class BoutiqueProfilController extends BaseController {
    private $serviceBoutique;
    private $serviceZone;
    public function __construct() {
        $this->serviceBoutique = new ServiceBoutique();
        $this->serviceZone = new ServiceZone();
    }
    /**
     * Affiche le profil complet d'une boutique avec ses employés et chiffres d'affaires
     *
     * @param int $id Identifiant de la boutique
     * @return void
     */
    public function profilBoutique(int $id): void {
        if ($id == null) {
            $this->redirectWithMessage('home', 'Boutique non trouvée.', 'error');
        }

        $boutique = $this->serviceBoutique->getBoutiqueParID($id);
        if (!$boutique) {
            $this->redirectWithMessage('home', 'Boutique non trouvée.', 'error');
        }
        
        // Récuprer les employés de la boutique
        $employes = $this->serviceBoutique->getEmployeesParBoutique($id);
        //on stocke les employés de la boutique dans le tableau boutique pour les afficher dans la vue
        $boutique['EMPLOYES'] = $employes ?? [];
        //récupération du nom/prenom du manager et du nom de la zone pour de l'affichage dans la vue
        $manager = $this->serviceBoutique->getManagerParBoutique($id);
        $zone = $this->serviceZone->getZoneParID($boutique['ID_ZONE']);
        $boutique['NOM_MANAGER'] = $manager['NOM'];
        $boutique['PRENOM_MANAGER'] = $manager['PRENOM'];
        $boutique['NOM_ZONE'] = $zone['NOM_ZONE'];
        $CAs = $this->serviceBoutique->getCA($id);
        $title = "Profil de la boutique - Zoo'land";
        
        $this->render('boutique/v-profil', ['title' => $title, 'boutique' => $boutique,'CAs'=>$CAs]);
    }
}