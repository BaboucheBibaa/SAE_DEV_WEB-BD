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

    //  Dashboard admin


    public function popUpsAdmins()
    {
        $this->requireRole(ADMINID);
        $finsDeContrats = $this->serviceEmployee->getFinsDeContrats();
        $nbFins = count($finsDeContrats);
        if ($nbFins == 1) {
            $message = "Il y a $nbFins contrat de travail qui se termine dans les 30 prochains jours.";
            $_SESSION['flash'] = ['type' => 'warning', 'message' => $message];
        } elseif ($nbFins > 1) {
            $message = "Il y a $nbFins contrats de travail qui se terminent dans les 30 prochains jours.";
            $_SESSION['flash'] = ['type' => 'warning', 'message' => $message];
        }
    }
    public function profilAdmin()
    {
        $this->requireRole(ADMINID);
        $this->popUpsAdmins();
        $title = "Profil Administrateur";
        $filtreArchive = $_GET['filtreArchive'] ?? 'tous';
        if (!in_array($filtreArchive, ['tous', 'actifs', 'archives'], true)) {
            $filtreArchive = 'tous';
        }

        $employees = $this->serviceEmployee->getTousEmployees($filtreArchive);
        $zones = $this->serviceZone->getToutesLesZones();
        $boutiques = $this->serviceBoutique->getToutesLesBoutiques();
        $animals = $this->serviceAnimal->getTousAnimaux();
        if ($employees === null || $zones === null || $boutiques === null || $animals === null) {
            $this->redirectWithMessage('home', 'Erreur lors de la récupération des données pour le dashboard admin.', 'error');
        }
        $this->render('administrateur/v-dashboard', [
            'title' => $title,
            'employees' => $employees,
            'filtreArchive' => $filtreArchive,
            'zones' => $zones,
            'boutiques' => $boutiques,
            'animals' => $animals
        ]);
    }

    //  Employés

    public function formCreationEmployee()
    {
        $this->requireRole(ADMINID);
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
        $this->requireRole(ADMINID);
        switch ($this->serviceEmployee->ajoutEmployee()) {
            //valeurs de retour de la fonction ajoutEmployee: 0 ou 1 car retourne un boolean
            case 1:
                $this->logEvent(
                    'INSERTION_BD',
                    "Nouvel employé ajouté: id={$this->serviceEmployee->getLastInsertId()}"
                );
                $this->redirectWithMessage('adminDashboard', 'Employé ajouté avec succès.', 'success');
                break;
            case 0:
                $this->logEvent(
                    'ERREUR',
                    "Erreur lors de l'ajout d'un employé"
                );
                $this->redirectWithMessage('creationEmployee', 'Erreur lors de l\'ajout de l\'employé.', 'error');
                break;
            //autres cas ici : valeurs de retour de la validation de formulaire
            //pas de message dans les logs pour ces erreurs car c'est côté utilisateur et non côt serveur
            case 2:
                $this->redirectWithMessage('creationEmployee', 'Erreur : Nom invalide.', 'error');
                break;
            case 3:
                $this->redirectWithMessage('creationEmployee', 'Erreur : Prénom invalide.', 'error');
                break;
            case 4:
                $this->redirectWithMessage('creationEmployee', 'Erreur: Email invalide.', 'error');
                break;
            case 5:
                $this->redirectWithMessage('creationEmployee', 'Erreur: Salaire invalide.', 'error');
                break;
            case 6:
                $this->redirectWithMessage('creationEmployee', 'Erreur: Login invalide.', 'error');
                break;
            default:
                $this->redirectWithMessage('creationEmployee', 'Erreur inconnue lors de l\'ajout de l\'employé.', 'error');
                break;
        }
    }

    public function formEditionEmployee($id)
    {
        $this->requireRole(ADMINID);
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
        $this->requireRole(ADMINID);
        switch ($this->serviceEmployee->majEmployee($id)) {
            //valeurs de retour de la fonction majEmployee: 0 ou 1 car retourne un boolean
            case 1:
                $this->logEvent(
                    'UPDATE_BD',
                    "Employé mis à jour: id={$id}"
                );
                $this->redirectWithMessage('adminDashboard', 'Employé mis à jour avec succès.', 'success');
                break;
            case 0:
                $this->logEvent(
                    'ERREUR',
                    "Erreur lors de la mise à jour de l'employé id={$id}"
                );

                $this->redirectWithMessage('editionEmployee', 'Erreur lors de la mise à jour de l\'employé.', 'error');
                break;
            //autres cas ici : valeurs de retour de la validation de formulaire

            case 2:
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Erreur : Nom invalide.'];
                $this->redirect('editionEmployee', $id);
                break;
            case 3:
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Erreur : Prénom invalide.'];
                $this->redirect('editionEmployee', $id);
                break;
            case 4:
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Erreur: Email invalide.'];
                $this->redirect('editionEmployee', $id);
                break;
            case 5:
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Erreur: Salaire invalide.'];
                $this->redirect('editionEmployee', $id);
                break;
            case 6:
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Erreur: Login invalide.'];
                $this->redirect('editionEmployee', $id);
                break;
            default:
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Erreur inconnue lors de la mise à jour de l\'employé.'];
                $this->redirect('editionEmployee', $id);
                break;
        }
    }

    public function supprEmployee($id)
    {
        $this->requireRole(ADMINID);
        if ($this->serviceEmployee->supprEmployee($id)) {
            $this->logEvent(
                'SUPPRESSION_BD',
                "Employé supprimé: id={$id}"
            );
            $this->redirectWithMessage('adminDashboard', 'Employé supprimé avec succès.', 'success');
        } else {
            $this->logEvent(
                'ERREUR',
                "Erreur lors de la suppression de l'employé id={$id}"
            );
            $this->redirectWithMessage('adminDashboard', 'Erreur lors de la suppression de l\'employé.', 'error');
        }
    }

    public function archiverEmployee($id)
    {
        $this->requireRole(ADMINID);

        $employee = $this->serviceEmployee->getEmployeeParID($id);

        // récupérer le filtre d'archivage et mettre par défaut si quelqu'un saisit une valeur non valide dans l'url
        $filtreArchive = $_GET['filtreArchive'] ?? 'actifs';
        if (!in_array($filtreArchive, ['tous', 'actifs', 'archives'], true)) {
            $filtreArchive = 'actifs';
        }

        //si l'employé n'existe pas on met un msg d'erreur
        if (!$employee) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Employé non trouvé.'];
            header('Location: index.php?action=adminDashboard&filtreArchive=' . $filtreArchive);
            exit;
        }

        //empêcher un admin d'archiver son propre compte
        if (!empty($_SESSION['user']['ID_PERSONNEL']) && $_SESSION['user']['ID_PERSONNEL'] == $id) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Vous ne pouvez pas archiver votre propre compte.'];
            header('Location: index.php?action=adminDashboard&filtreArchive=' . $filtreArchive);
            exit;
        }

        $valeurDemandee = isset($_GET['valeur']) ? (int) $_GET['valeur'] : null;
        $nouvelEtat = ($valeurDemandee === 0 || $valeurDemandee === 1)
            ? $valeurDemandee
            : ((int) ($employee['ESTARCHIVE'] ?? 1) === 1 ? 0 : 1);

        if ($this->serviceEmployee->majArchiveEmployee($id, $nouvelEtat)) {
            $message = $nouvelEtat === 0
                ? 'Employé archivé avec succès.'
                : 'Employé désarchivé avec succès.';
            $_SESSION['flash'] = ['type' => 'success', 'message' => $message];
        } else {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Erreur lors de la mise à jour du statut d\'archivage.'];
        }

        header('Location: index.php?action=adminDashboard&filtreArchive=' . $filtreArchive);
        exit;
    }

    //  Boutiques

    public function formCreationBoutique()
    {
        $this->requireRole(ADMINID);
        $data = $this->serviceBoutique->dataCreationBoutique();
        if ($data === null) {
            $this->redirectWithMessage('adminDashboard', 'Erreur lors de la préparation de la création de la boutique.', 'error');
        } else {
            $this->render('administrateur/v-createBoutique', $data);
        }
    }

    public function ajoutBoutique()
    {
        $this->requireRole(ADMINID);
        if ($this->serviceBoutique->ajoutBoutique()) {
            $this->logEvent(
                'INSERTION_BD',
                "Nouvelle boutique ajoutée"
            );
            $this->redirectWithMessage('adminDashboard', 'Boutique ajoutée avec succès.', 'success');
        } else {
            $this->logEvent(
                'ERREUR',
                "Erreur lors de l'ajout d'une boutique"
            );
            $this->redirectWithMessage('adminDashboard', 'Erreur lors de l\'ajout de la boutique.', 'error');
        }
    }

    public function formEditionBoutique($id)
    {
        $this->requireRole(ADMINID);
        $data = $this->serviceBoutique->dataEditionBoutique($id);
        if ($data === null) {
            $this->redirectWithMessage('adminDashboard', 'Boutique non trouvée.', 'error');
        } else {
            $this->render('administrateur/v-editionBoutique', $data);
        }
    }

    public function majBoutique($id)
    {
        $this->requireRole(ADMINID);
        if ($this->serviceBoutique->majBoutique($id)) {
            $this->logEvent(
                'UPDATE_BD',
                "Boutique mise à jour: id={$id}"
            );
            $this->redirectWithMessage('adminDashboard', 'Boutique mise à jour avec succès.', 'success');
        } else {
            $this->logEvent(
                'ERREUR',
                "Erreur lors de la mise à jour de la boutique id={$id}"
            );
            $this->redirectWithMessage('adminDashboard', 'Erreur lors de la mise à jour de la boutique.', 'error');
        }
    }

    public function supprBoutique($id)
    {
        $this->requireRole(ADMINID);
        if ($this->serviceBoutique->supprBoutique($id)) {
            $this->logEvent(
                'SUPPRESSION_BD',
                "Boutique supprimée: id={$id}"
            );

            $this->redirectWithMessage('adminDashboard', 'Boutique supprimée avec succès.', 'success');
        } else {
            $this->logEvent(
                'ERREUR',
                "Erreur lors de la suppression de la boutique id={$id}"
            );

            $this->redirectWithMessage('adminDashboard', 'Erreur lors de la suppression de la boutique.', 'error');
        }
    }

    //  Zones

    public function formCreationZone()
    {
        $this->requireRole(ADMINID);
        $data = $this->serviceZone->dataCreationZone();
        if ($data === null) {
            $this->redirectWithMessage('adminDashboard', 'Erreur lors de la préparation de la création de la zone.', 'error');
        } else {
            $this->render('administrateur/v-createZone', $data);
        }
    }

    public function ajoutZone()
    {
        $this->requireRole(ADMINID);
        if ($this->serviceZone->ajoutZone()) {
            $this->logEvent(
                'INSERTION_BD',
                "Nouvelle zone ajoutée"
            );

            $this->redirectWithMessage('adminDashboard', 'Zone ajoutée avec succès.', 'success');
        } else {
            $this->logEvent(
                'ERREUR',
                "Erreur lors de l'ajout d'une zone"
            );
            $this->redirectWithMessage('adminDashboard', 'Erreur lors de l\'ajout d\'une zone.', 'error');
        }
    }

    public function formEditionZone($id)
    {
        $this->requireRole(ADMINID);
        $data = $this->serviceZone->dataEditionZone($id);
        if ($data === null) {
            $this->redirectWithMessage('adminDashboard', 'Zone non trouvée.', 'error');
        } else {
            $this->render('administrateur/v-editionZone', $data);
        }
    }

    public function majZone($id)
    {
        $this->requireRole(ADMINID);
        if ($this->serviceZone->majZone($id)) {
            $this->logEvent(
                'UPDATE_BD',
                "Zone mise à jour: id={$id}"
            );
            $this->redirectWithMessage('adminDashboard', 'Zone mise à jour avec succès.', 'success');
        } else {
            $this->logEvent(
                'ERREUR',
                "Erreur lors de la mise à jour de la zone id={$id}"
            );
            $this->redirectWithMessage('adminDashboard', 'Erreur lors de la mise à jour de la zone.', 'error');
        }
    }

    public function supprZone($id)
    {
        $this->requireRole(ADMINID);
        if ($this->serviceZone->supprZone($id)) {
            $this->logEvent(
                'SUPPRESSION_BD',
                "Zone supprimée: id={$id}"
            );
            $this->redirectWithMessage('adminDashboard', 'Zone supprimée avec succès.', 'success');
        } else {
            $this->logEvent(
                'ERREUR',
                "Erreur lors de la suppression de la zone id={$id}"
            );
            $this->redirectWithMessage('adminDashboard', 'Erreur lors de la suppression de la zone.', 'error');
        }
    }

    // ========================
    //  Animaux
    // ========================

    public function formCreationAnimal()
    {
        $this->requireRole(ADMINID);
        $data = $this->serviceAnimal->dataCreationAnimal();
        if ($data === null) {
            $this->redirectWithMessage('adminDashboard', 'Erreur lors de la préparation de la création de l\'animal.', 'error');
        } else {
            $this->render('administrateur/v-createAnimal', $data);
        }
    }

    public function ajoutAnimal()
    {
        $this->requireRole(ADMINID);
        $result = $this->serviceAnimal->ajoutAnimal();

        if ($result === 2) {
            $this->redirectWithMessage('creationAnimal', 'Erreur : Nom invalide.', 'error');
        } elseif ($result === 3) {
            $this->redirectWithMessage('creationAnimal', 'Erreur : Poids invalide.', 'error');
        } elseif ($result === true) {
            $this->logEvent(
                'INSERTION_BD',
                "Nouvel animal ajouté"
            );
            $this->redirectWithMessage('adminDashboard', 'Animal ajouté avec succès.', 'success');
        } else {
            $this->logEvent(
                'ERREUR',
                "Erreur lors de l'ajout d'un animal"
            );
            $this->redirectWithMessage('creationAnimal', 'Erreur lors de l\'ajout de l\'animal.', 'error');
        }
    }

    public function formEditionAnimal($id)
    {
        $this->requireRole(ADMINID);
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
        $this->requireRole(ADMINID);
        $result = $this->serviceAnimal->majAnimal($id);

        //si la maj a pas fonctionnée on retourne sur le formulaire avec msg d'erreur sinon dashboard avec msg de succès
        if ($result === 2) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Erreur : Nom invalide.'];
            $this->redirect('editionAnimal', $id);
        } elseif ($result === 3) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Erreur : Poids invalide.'];
            $this->redirect('editionAnimal', $id);
        } elseif ($result === true) {
            $this->logEvent(
                'UPDATE_BD',
                "Animal mis à jour: id={$id}"
            );
            $this->redirectWithMessage('adminDashboard', 'Animal mis à jour avec succès.', 'success');
        } else {
            $this->logEvent(
                'ERREUR',
                "Erreur lors de la mise à jour de l\'animal id={$id}"
            );
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Erreur lors de la mise à jour de l\'animal.'];
            $this->redirect('editionAnimal', $id);
        }
    }

    public function supprAnimal($id)
    {
        $this->requireRole(ADMINID);
        if ($this->serviceAnimal->supprAnimal($id)) {
            $this->logEvent(
                'DELETE_BD',
                "Animal supprimé: id={$id}"
            );
            $this->redirectWithMessage('adminDashboard', 'Animal supprimé avec succès.', 'success');
        } else {
            $this->logEvent(
                'ERREUR',
                "Erreur lors de la suppression de l'animal id={$id}"
            );
            $this->redirectWithMessage('adminDashboard', 'Erreur lors de la suppression de l\'animal.', 'error');
        }
    }
}
