<?php
class AdminController extends BaseController
{
    private $serviceEmployee;
    private $serviceZone;
    private $serviceBoutique;
    private $serviceAnimal;

    //constructeur de la classe
    public function __construct()
    {
        $this->serviceEmployee = new ServiceEmployee();
        $this->serviceZone = new ServiceZone();
        $this->serviceBoutique = new ServiceBoutique();
        $this->serviceAnimal = new ServiceAnimal();
    }
    
    /**
     * Vérifie que l'utilisateur est connecté et admin.
     * Redirige si ce n'est pas le cas.
     */
    private function checkAdmin()
    {
        if (empty($_SESSION['user'])) {
            $this->redirectWithMessage('home', 'Vous n\'êtes pas connecté.', 'error');
        }
        if (!isset($_SESSION['user']['ID_FONCTION']) || $_SESSION['user']['ID_FONCTION'] != ADMINID) {
            $this->redirectWithMessage('home', 'Vous n\'êtes pas autorisé à accéder à cette page.', 'error');
        }
    }

    //  Dashboard admin

    public function profilAdmin()
    {
        $this->checkAdmin();

        $title = "Profil Administrateur";
        $employees = $this->serviceEmployee->recupTousEmployes();
        $zones = $this->serviceZone->recupToutesLesZones();
        $boutiques = Boutique::toutRecup();
        $animals = Animal::toutRecup();
        if ($employees === null || $zones === null || $boutiques === null || $animals === null) {
            $this->redirectWithMessage('home', 'Erreur lors de la récupération des données pour le dashboard admin.', 'error');
        } else {
            //Ajouter le nom de l'espèce à chaque animal (passage par référence pour modifier directement le tableau)
            foreach ($animals as &$animal) {
                if (!empty($animal['ID_ESPECE'])) {
                    $espece = Espece::recupParID($animal['ID_ESPECE']);
                    $animal['NOM_ESPECE'] = $espece['NOM_ESPECE'] ?? 'N/A';
                } else {
                    $animal['NOM_ESPECE'] = 'N/A';
                }
            }

            // Ajouter le nom du manager à chaque zone
            foreach ($zones as &$zone) {
                if (!empty($zone['ID_MANAGER'])) {
                    $manager = Zone::recupNomManager($zone['ID_ZONE']);
                    $zone['NOM_MANAGER'] = ($manager['PRENOM'] ?? '') . ' ' . ($manager['NOM'] ?? '');
                } else {
                    $zone['NOM_MANAGER'] = null;
                }
            }
            $this->render('administrateur/v-dashboard', [
                'title' => $title,
                'employees' => $employees,
                'zones' => $zones,
                'boutiques' => $boutiques,
                'animals' => $animals
            ]);
        }
    }

    //  Employés

    public function formCreationEmployee()
    {
        $this->checkAdmin();
        $data = $this->serviceEmployee->dataCreationEmployee();
        if ($data === null) {
            $this->redirectWithMessage('adminDashboard', 'Erreur lors de la préparation de la création de l\'employé.', 'error');
        } else {
            $this->render(
                'administrateur/v-createEmployee',
                [
                    'liste_fonctions' => $data['liste_fonctions'],
                    'liste_employes' => $data['liste_employes'],
                    'generatedPassword' => $data['generatedPassword'],
                    'title' => $data['title']
                ]
            );
        }
    }

    public function ajoutEmployee()
    {
        $this->checkAdmin();
        if ($this->serviceEmployee->ajoutEmployee()) {
            $this->redirectWithMessage('adminDashboard', 'Employé ajouté avec succès.', 'success');
        } else {
            $this->redirectWithMessage('adminDashboard', 'Erreur lors de l\'ajout de l\'employé.', 'error');
        }
    }

    public function formEditionEmployee($id)
    {
        $this->checkAdmin();
        $data = $this->serviceEmployee->dataEditionEmployee($id);
        if ($data === null) {
            $this->redirectWithMessage('adminDashboard', 'Employé non trouvé.', 'error');
        } else {
            $this->render(
                'administrateur/v-editionEmployee',
                $data
            );
        }
    }

    public function majEmployee($id)
    {
        $this->checkAdmin();
        if ($this->serviceEmployee->majEmployee($id)) {
            $this->redirectWithMessage('adminDashboard', 'Employé mis à jour avec succès.', 'success');
        } else {
            $this->redirectWithMessage('adminDashboard', 'Erreur lors de la mise à jour de l\'employé.', 'error');
        }
    }

    public function supprEmployee($id)
    {
        $this->checkAdmin();
        if ($this->serviceEmployee->supprEmployee($id)) {
            $this->redirectWithMessage('adminDashboard', 'Employé supprimé avec succès.', 'success');
        } else {
            $this->redirectWithMessage('adminDashboard', 'Erreur lors de la suppression de l\'employé.', 'error');
        }
    }

    //  Boutiques

    public function formCreationBoutique()
    {
        $this->checkAdmin();
        $data = $this->serviceBoutique->dataCreationBoutique();
        if ($data === null) {
            $this->redirectWithMessage('adminDashboard', 'Erreur lors de la préparation de la création de la boutique.', 'error');
        } else {
            $this->render('administrateur/v-createBoutique', $data);
        }
    }

    public function ajoutBoutique()
    {
        $this->checkAdmin();
        if ($this->serviceBoutique->ajoutBoutique()) {
            $this->redirectWithMessage('adminDashboard', 'Boutique ajoutée avec succès.', 'success');
        } else {
            $this->redirectWithMessage('adminDashboard', 'Erreur lors de l\'ajout de la boutique.', 'error');
        }
    }

    public function formEditionBoutique($id)
    {
        $this->checkAdmin();
        $data = $this->serviceBoutique->dataEditionBoutique($id);
        if ($data === null) {
            $this->redirectWithMessage('adminDashboard', 'Boutique non trouvée.', 'error');
        } else {
            $this->render('administrateur/v-editionBoutique', $data);
        }
    }

    public function majBoutique($id)
    {
        $this->checkAdmin();
        if ($this->serviceBoutique->majBoutique($id)) {
            $this->redirectWithMessage('adminDashboard', 'Boutique mise à jour avec succès.', 'success');
        } else {
            $this->redirectWithMessage('adminDashboard', 'Erreur lors de la mise à jour de la boutique.', 'error');
        }
    }

    public function supprBoutique($id)
    {
        $this->checkAdmin();
        if ($this->serviceBoutique->supprBoutique($id)) {
            $this->redirectWithMessage('adminDashboard', 'Boutique supprimée avec succès.', 'success');
        } else {
            $this->redirectWithMessage('adminDashboard', 'Erreur lors de la suppression de la boutique.', 'error');
        }
    }

    //  Zones

    public function formCreationZone()
    {
        $this->checkAdmin();
        $data = $this->serviceZone->dataCreationZone();
        if ($data === null) {
            $this->redirectWithMessage('adminDashboard', 'Erreur lors de la préparation de la création de la zone.', 'error');
        } else {
            $this->render('administrateur/v-createZone', $data);
        }
    }

    public function ajoutZone()
    {
        $this->checkAdmin();
        if ($this->serviceZone->ajoutZone()) {
            $this->redirectWithMessage('adminDashboard', 'Zone ajoutée avec succès.', 'success');
        } else {
            $this->redirectWithMessage('adminDashboard', 'Erreur lors de l\'ajout de la zone.', 'error');
        }
    }

    public function formEditionZone($id)
    {
        $this->checkAdmin();
        $data = $this->serviceZone->dataEditionZone($id);
        if ($data === null) {
            $this->redirectWithMessage('adminDashboard', 'Zone non trouvée.', 'error');
        } else {
            $this->render('administrateur/v-editionZone', $data);
        }
    }

    public function majZone($id)
    {
        $this->checkAdmin();
        if ($this->serviceZone->majZone($id)) {
            $this->redirectWithMessage('adminDashboard', 'Zone mise à jour avec succès.', 'success');
        } else {
            $this->redirectWithMessage('adminDashboard', 'Erreur lors de la mise à jour de la zone.', 'error');
        }
    }

    public function supprZone($id)
    {
        $this->checkAdmin();
        if ($this->serviceZone->supprZone($id)) {
            $this->redirectWithMessage('adminDashboard', 'Zone supprimée avec succès.', 'success');
        } else {
            $this->redirectWithMessage('adminDashboard', 'Erreur lors de la suppression de la zone.', 'error');
        }
    }

    // ========================
    //  Animaux
    // ========================

    public function formCreationAnimal()
    {
        $this->checkAdmin();
        $data = $this->serviceAnimal->dataCreationAnimal();
        if ($data === null) {
            $this->redirectWithMessage('adminDashboard', 'Erreur lors de la préparation de la création de l\'animal.', 'error');
        } else {
            $this->render('administrateur/v-createAnimal', $data);
        }
    }

    public function ajoutAnimal()
    {
        $this->checkAdmin();
        if ($this->serviceAnimal->ajoutAnimal()) {
            $this->redirectWithMessage('adminDashboard', 'Animal ajouté avec succès.', 'success');
        } else {
            $this->redirectWithMessage('adminDashboard', 'Erreur lors de l\'ajout de l\'animal.', 'error');
        }
    }

    public function formEditionAnimal($id)
    {
        $this->checkAdmin();
        $data = $this->serviceAnimal->dataEditionAnimal($id);
        if ($data === null) {
            $this->redirectWithMessage('adminDashboard', 'Animal non trouvé.', 'error');
        } else {
            $this->render(
                'administrateur/v-editionAnimal',
                $data
            );
        }
    }

    public function majAnimal($id)
    {
        $this->checkAdmin();
        if ($this->serviceAnimal->majAnimal($id)) {
            $this->redirectWithMessage('adminDashboard', 'Animal mis à jour avec succès.', 'success');
        } else {
            $this->redirectWithMessage('adminDashboard', 'Erreur lors de la mise à jour de l\'animal.', 'error');
        }
    }

    public function supprAnimal($id)
    {
        $this->checkAdmin();
        if ($this->serviceAnimal->supprAnimal($id)) {
            $this->redirectWithMessage('adminDashboard', 'Animal supprimé avec succès.', 'success');
        } else {
            $this->redirectWithMessage('adminDashboard', 'Erreur lors de la suppression de l\'animal.', 'error');
        }
    }
}
