<?php

class ProfilPrestaireController extends BaseController
{
    private $serviceReparation;

    public function __construct()
    {
        $this->serviceReparation = new ServiceReparation();
    }

    /**
     * Affiche le profil complet d'un prestataire
     * Inclut ses informations et l'historique de ses réparations
     * @param int $id ID du prestataire
     * @return void Affiche le profil ou redirige si prestataire introuvable
     */
    public function profilPrestataire(int $id): void
    {
        if ($id == null) {
            $this->redirectWithMessage('home', 'Prestataire non trouvé.', 'error');
        }

        $prestataire = $this->serviceReparation->getPrestataire($id);
        if (!$prestataire) {
            $this->redirectWithMessage('home', 'Prestataire non trouvé.', 'error');
        }

        $reparations = $this->serviceReparation->getReparationsParPrestataire($id);

        $title = "Profil de {$prestataire['NOM_PRESTATAIRE']} {$prestataire['PRENOM_PRESTATAIRE']} - Zoo'land";
        $this->render('prestataire/profil', [
            'title' => $title,
            'prestataire' => $prestataire,
            'reparations' => $reparations
        ]);
    }
}
