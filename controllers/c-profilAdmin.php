<?php
class AdminController extends BaseController
{
    private $serviceEmployee;
    private $serviceZone;
    private $serviceBoutique;
    private $serviceAnimal;
    private $serviceReparation;
    private $serviceParrainage;
    private $serviceCA;
    private $serviceEnclos;
    private $serviceSoin;

    private $serviceEspece;
    private $serviceCompatibilite;

    //constructeur de la classe
    public function __construct()
    {
        $this->serviceEmployee = new ServiceEmployee();
        $this->serviceZone = new ServiceZone();
        $this->serviceBoutique = new ServiceBoutique();
        $this->serviceAnimal = new ServiceAnimal();
        $this->serviceReparation = new ServiceReparation();
        $this->serviceParrainage = new ServiceParrainage();
        $this->serviceCA = new ServiceCA();
        $this->serviceEnclos = new ServiceEnclos();
        $this->serviceSoin = new ServiceSoin();
        $this->serviceEspece = new ServiceEspece();
        $this->serviceCompatibilite = new ServiceCompatibilite();
    }

    //  Dashboard admin

    /**
     * Affiche le tableau de bord administrateur avec les filtres d'archivage
     *
     * @return void
     */
    public function profilAdmin(): void
    {
        $this->requireRole(ADMINID);
        $title = "Profil Administrateur";
        $filtreArchive = $_GET['filtreArchive'] ?? 'tous';
        if (!in_array($filtreArchive, ['tous', 'actifs', 'archives'], true)) {
            $filtreArchive = 'tous';
        }

        $employees = $this->serviceEmployee->getTousEmployees($filtreArchive);
        $zones = $this->serviceZone->getAll();
        $boutiques = $this->serviceBoutique->getToutesLesBoutiques();
        $animals = $this->serviceAnimal->getTousAnimaux();
        $especes = $this->serviceEspece->getAll();
        $prestataires = $this->serviceReparation->getAllPrestataires();
        $contrats = $this->serviceEmployee->getAllContrats();
        $enclos = $this->serviceEnclos->getAll();
        $compatibilites = $this->serviceCompatibilite->getAll();
        if ($employees === null || $zones === null || $boutiques === null || $animals === null) {
            $this->redirectWithMessage('home', 'Erreur lors de la récupération des données pour le dashboard admin.', 'error');
        }
        $this->render('administrateur/v-dashboard', [
            'title' => $title,
            'employees' => $employees,
            'filtreArchive' => $filtreArchive,
            'zones' => $zones,
            'boutiques' => $boutiques,
            'animals' => $animals,
            'especes' => $especes,
            'prestataires' => $prestataires,
            'contrats' => $contrats,
            'enclos' => $enclos,
            'compatibilites' => $compatibilites
        ]);
    }

    //  Employés

    /**
     * Affiche le formulaire de création d'un employé
     *
     * @return void
     */
    public function formCreationEmployee(): void
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

    /**
     * Traite l'ajout d'un nouvel employé et gère les erreurs de validation
     *
     * @return void
     */
    public function ajoutEmployee(): void
    {
        $this->requireRole(ADMINID);

        switch ($this->serviceEmployee->ajoutEmployee()) {
            case 0:
                $this->logEvent(
                    'ERREUR',
                    "Erreur lors de l'ajout d'un employé"
                );
                $this->redirectWithMessage('creationEmployee', 'Erreur lors de l\'ajout de l\'employé.', 'error');
                break;
            case 1:
                $newEmployeeId = $this->serviceEmployee->getLastInsertId();
                $this->logEvent(
                    'INSERTION_BD',
                    "Nouvel employé ajouté: id={$newEmployeeId}"
                );
                $this->redirectWithMessage('adminDashboard', 'Employé ajouté avec succès.', 'success');
                break;
            case 2:
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Erreur : Nom invalide.'];
                $this->redirect('creationEmployee');
                break;
            case 3:
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Erreur : Prénom invalide.'];
                $this->redirect('creationEmployee');
                break;
            case 4:
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Erreur : Email invalide.'];
                $this->redirect('creationEmployee');
                break;
            case 5:
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Erreur : Salaire invalide.'];
                $this->redirect('creationEmployee');
                break;
            case 6:
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Erreur : Login invalide.'];
                $this->redirect('creationEmployee');
                break;
            default:
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Erreur inconnue lors de l\'ajout de l\'employé.'];
                $this->redirect('creationEmployee');
                break;
        }
    }

    /**
     * Affiche le formulaire d'édition d'un employé
     *
     * @param int $id Identifiant de l'employé à éditer
     * @return void
     */
    public function formEditionEmployee(int $id): void
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

    /**
     * Met à jour les informations d'un employé
     *
     * @param int $id Identifiant de l'employé à mettre à jour
     * @return void
     */
    public function majEmployee(int $id): void
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

    /**
     * Supprime un employé de la base de données
     *
     * @param int $id Identifiant de l'employé à supprimer
     * @return void
     */
    public function supprEmployee(int $id): void
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

    /**
     * Archive ou désarchive un employé
     *
     * @param int $id Identifiant de l'employé à archiver/désarchiver
     * @return void
     */
    public function archiverEmployee(int $id): void
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
            $this->redirectWithMessage('adminDashboard','Employé non trouvé','error');
        }

        //empêcher un admin d'archiver son propre compte
        if (!empty($_SESSION['user']['ID_PERSONNEL']) && $_SESSION['user']['ID_PERSONNEL'] == $id) {
            $this->redirectWithMessage('adminDashboard','Vous ne pouvez pas archiver votre propre compte','error');
        }
        //valeur : 0 pour archiver, 1 pour désarchiver, si elle existe on la met en int et on l'affecte, sinon null
        $valeur = isset($_GET['valeur']) ? intval($_GET['valeur']) : null;
        //si valeur est à 0 ou à 1 alors l'état de l'archivage est valide (archiver ou désarchiver) sinon on regarde l'état de l'archivage de l'employé
        $nouvelEtat = ($valeur === 0 || $valeur === 1)
            ? $valeur
            : ((int) ($employee['ESTARCHIVE'] ?? 1) === 1 ? 0 : 1);
        if ($this->serviceEmployee->majArchiveEmployee($id, $nouvelEtat)) {
            $message = $nouvelEtat === 0
                ? 'Employé archivé avec succès.'
                : 'Employé désarchivé avec succès.';
            $this->redirectWithMessage('adminDashboard', $message, 'success', ['filtreArchive' => $filtreArchive]);
        } else {
            $this->redirectWithMessage('adminDashboard', 'Erreur lors de la mise à jour du statut d\'archivage', 'error', ['filtreArchive' => $filtreArchive]);
        }
    }

    //  Boutiques

    /**
     * Affiche le formulaire de création d'une boutique
     *
     * @return void
     */
    public function formCreationBoutique(): void
    {
        $this->requireRole(ADMINID);
        $data = $this->serviceBoutique->dataCreationBoutique();
        if ($data === null) {
            $this->redirectWithMessage('adminDashboard', 'Erreur lors de la préparation de la création de la boutique.', 'error');
        } else {
            $this->render('administrateur/v-createBoutique', $data);
        }
    }

    /**
     * Traite l'ajout d'une nouvelle boutique
     *
     * @return void
     */
    public function ajoutBoutique(): void
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

    /**
     * Affiche le formulaire d'édition d'une boutique
     *
     * @param int $id Identifiant de la boutique à éditer
     * @return void
     */
    public function formEditionBoutique(int $id): void
    {
        $this->requireRole(ADMINID);
        $data = $this->serviceBoutique->dataEditionBoutique($id);
        if ($data === null) {
            $this->redirectWithMessage('adminDashboard', 'Boutique non trouvée.', 'error');
        } else {
            $this->render('administrateur/v-editionBoutique', $data);
        }
    }

    /**
     * Met à jour les informations d'une boutique
     *
     * @param int $id Identifiant de la boutique à mettre à jour
     * @return void
     */
    public function majBoutique(int $id): void
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

    /**
     * Supprime une boutique de la base de données
     *
     * @param int $id Identifiant de la boutique à supprimer
     * @return void
     */
    public function supprBoutique(int $id): void
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

    /**
     * Affiche le formulaire de création d'une zone
     *
     * @return void
     */
    public function formCreationZone(): void
    {
        $this->requireRole(ADMINID);
        $data = $this->serviceZone->dataCreationZone();
        if ($data === null) {
            $this->redirectWithMessage('adminDashboard', 'Erreur lors de la préparation de la création de la zone.', 'error');
        } else {
            $this->render('administrateur/v-createZone', $data);
        }
    }

    /**
     * Traite l'ajout d'une nouvelle zone
     *
     * @return void
     */
    public function ajoutZone(): void
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

    /**
     * Affiche le formulaire d'édition d'une zone
     *
     * @param int $id Identifiant de la zone à éditer
     * @return void
     */
    public function formEditionZone(int $id): void
    {
        $this->requireRole(ADMINID);
        $data = $this->serviceZone->dataEditionZone($id);
        if ($data === null) {
            $this->redirectWithMessage('adminDashboard', 'Zone non trouvée.', 'error');
        } else {
            $this->render('administrateur/v-editionZone', $data);
        }
    }

    /**
     * Met à jour les informations d'une zone
     *
     * @param int $id Identifiant de la zone à mettre à jour
     * @return void
     */
    public function majZone(int $id): void
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

    /**
     * Supprime une zone de la base de données
     *
     * @param int $id Identifiant de la zone à supprimer
     * @return void
     */
    public function supprZone(int $id): void
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


    /**
     * Affiche le formulaire de création d'un animal
     *
     * @return void
     */
    public function formCreationAnimal(): void
    {
        $this->requireRole(ADMINID);
        $data = $this->serviceAnimal->dataCreationAnimal();
        if ($data == null) {
            $this->redirectWithMessage('adminDashboard', 'Erreur lors de la préparation de la création de l\'animal.', 'error');
        } else {
            $this->render('administrateur/v-createAnimal', $data);
        }
    }


    /**
     * Traite l'ajout d'un nouvel animal
     *
     * @return void
     */
    public function ajoutAnimal(): void
    {

        $this->requireRole(ADMINID);
        $result = $this->serviceAnimal->ajoutAnimal();
        if ($result === 2) {
            $this->redirectWithMessage('creationAnimal', 'Erreur : Nom invalide.', 'error');
        } elseif ($result === 3) {
            $this->redirectWithMessage('creationAnimal', 'Erreur : Poids invalide.', 'error');
        } elseif ($result == 1) {
            $this->logEvent(
                'INSERTION_BD',
                "Nouvel animal ajouté"
            );
            $this->redirectWithMessage('adminDashboard', 'Animal ajouté avec succès.', 'success');
        } else {
            echo $result;
            $this->logEvent(
                'ERREUR',
                "Erreur lors de l'ajout d'un animal"
            );
            $this->redirectWithMessage('creationAnimal', 'Erreur lors de l\'ajout de l\'animal.', 'error');
        }
    }

    /**
     * Affiche le formulaire d'édition d'un animal
     *
     * @param int $id Identifiant de l'animal à éditer
     * @return void
     */
    public function formEditionAnimal(int $id): void
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

    /**
     * Met à jour les informations d'un animal
     *
     * @param int $id Identifiant de l'animal à mettre à jour
     * @return void
     */
    public function majAnimal(int $id): void
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

    /**
     * Supprime un animal de la base de données
     *
     * @param int $id Identifiant de l'animal à supprimer
     * @return void
     */
    public function supprAnimal(int $id): void
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

    /**
     * Supprime un chiffre d'affaires d'une boutique
     *
     * @param int $id_boutique Identifiant de la boutique
     * @param string $date_ca Date du chiffre d'affaires au format YYYY-MM-DD
     * @return void
     */
    public function supprCA(int $id_boutique, string $date_ca): void
    {
        $this->requireRole(ADMINID);
        if ($this->serviceCA->supprCA($id_boutique, $date_ca)) {
            $this->logEvent(
                'SUPPRESSION_BD',
                "Chiffre affaires supprimé: id={$id_boutique} date={$date_ca}"
            );
            $this->redirectWithMessage("profilBoutique&id={$id_boutique}", "Chiffre d'affaires supprimé avec succès.", 'success');
        } else {
            $this->logEvent(
                'ERREUR',
                "Erreur lors de la suppression du chiffre d'\'affaires id={$id_boutique} date={$date_ca}"
            );
            $this->redirectWithMessage("profilBoutique&id={$id_boutique}", 'Erreur lors de la suppression du chiffre d\'affaires.', 'error');
        }
    }

    /**
     * Supprime un soin d'un animal
     *
     * @param int $id_animal Identifiant de l'animal
     * @param string $date_soin Date du soin au format YYYY-MM-DD
     * @return void
     */
    public function supprSoin(int $id_animal, string $date_soin): void
    {
        $this->requireRole(ADMINID);
        if ($this->serviceSoin->supprimerSoin($id_animal, $date_soin)) {
            $this->logEvent(
                'SUPPRESSION_BD',
                "Soin supprimé: id={$id_animal} date={$date_soin}"
            );
            $this->redirectWithMessage("profilAnimal&id={$id_animal}", "Soin supprimé avec succès.", 'success');
        } else {
            $this->logEvent(
                'ERREUR',
                "Erreur lors de la suppression du soin id={$id_animal} date={$date_soin}"
            );
            $this->redirectWithMessage("profilAnimal&id={$id_animal}", 'Erreur lors de la suppression du soin.', 'error');
        }
    }

    /**
     * Supprime une nourriture donnée à un animal
     *
     * @param int $id_animal Identifiant de l'animal
     * @param int $id_soigneur Identifiant du soigneur
     * @param string $date_nourrit Date de la nourriture au format YYYY-MM-DD
     * @return void
     */
    public function supprNourriture(int $id_animal, int $id_soigneur, string $date_nourrit): void
    {
        $this->requireRole(ADMINID);
        if ($this->serviceSoin->supprimerNourriture($id_animal, $id_soigneur, $date_nourrit)) {
            $this->logEvent(
                'SUPPRESSION_BD',
                "Nourriture donnée supprimée: id={$id_animal} soigneur={$id_soigneur} date={$date_nourrit}"
            );
            $this->redirectWithMessage("profilAnimal&id={$id_animal}", "Nourriture donnée supprimée avec succès.", 'success');
        } else {
            $this->logEvent(
                'ERREUR',
                "Erreur lors de la suppression de la nourriture donnée id={$id_animal} soigneur={$id_soigneur} date={$date_nourrit}"
            );
            $this->redirectWithMessage("profilAnimal&id={$id_animal}", 'Erreur lors de la suppression de la nourriture donnée.', 'error');
        }
    }

    /**
     * Supprime une espèce de la base de données
     *
     * @param int $id_espece Identifiant de l'espèce à supprimer
     * @return void
     */
    public function supprEspece(int $id_espece): void
    {
        $this->requireRole(ADMINID);
        if ($this->serviceEspece->supprimerEspece($id_espece)) {
            $this->logEvent(
                'SUPPRESSION_BD',
                "Espèce supprimée: id={$id_espece}"
            );
            $this->redirectWithMessage("adminDashboard", "Espèce supprimée avec succès.", 'success');
        } else {
            $this->logEvent(
                'ERREUR',
                "Erreur lors de la suppression de l\'espèce id={$id_espece} "
            );
            $this->redirectWithMessage("adminDashboard", 'Erreur lors de la suppression de l\'espèce.', 'error');
        }
    }

    /**
     * Affiche le formulaire de création d'une espèce
     *
     * @return void
     */
    public function formCreationEspece(): void
    {
        $this->requireRole(ADMINID);
        $this->render('administrateur/v-createEspece', [
            'title' => 'Créer une espèce'
        ]);
    }

    /**
     * Traite l'ajout d'une nouvelle espèce
     *
     * @return void
     */
    public function ajoutEspece(): void
    {
        $this->requireRole(ADMINID);
        $data = [
            'nom_espece' => $_POST['nom_espece'] ?? '',
            'nom_latin_espece' => $_POST['nom_latin'] ?? '',
            'est_menacee' => $_POST['est_menacee'] ?? ''
        ];

        if (empty($data['nom_espece']) || empty($data['nom_latin_espece']) || $data['est_menacee'] === '') {
            $this->redirectWithMessage('formCreationEspece', 'Tous les champs sont obligatoires.', 'error');
            return;
        }

        if ($this->serviceEspece->ajoutEspece($data)) {
            $this->logEvent(
                'INSERTION_BD',
                "Nouvelle espèce ajoutée: {$data['nom_espece']}"
            );
            $this->redirectWithMessage('adminDashboard', 'Espèce ajoutée avec succès.', 'success');
        } else {
            $this->logEvent(
                'ERREUR',
                "Erreur lors de l'ajout d'une espèce"
            );
            $this->redirectWithMessage('formCreationEspece', 'Erreur lors de l\'ajout de l\'espèce.', 'error');
        }
    }

    /**
     * Affiche le formulaire d'édition d'une espèce
     *
     * @param int $id Identifiant de l'espèce à éditer
     * @return void
     */
    public function formEditionEspece(int $id): void
    {
        $this->requireRole(ADMINID);
        $espece = $this->serviceEspece->getEspeceParID($id);

        if (!$espece) {
            $this->redirectWithMessage('adminDashboard', 'Espèce non trouvée.', 'error');
            return;
        }

        $this->render('administrateur/v-editionEspece', [
            'espece' => $espece,
            'title' => 'Modifier une espèce'
        ]);
    }

    /**
     * Met à jour les informations d'une espèce
     *
     * @param int $id Identifiant de l'espèce à mettre à jour
     * @return void
     */
    public function updateEspece(int $id): void
    {
        $this->requireRole(ADMINID);
        $data = [
            'nom_espece' => $_POST['nom_espece_modif'] ?? '',
            'nom_latin_espece' => $_POST['nom_latin_modif'] ?? '',
            'est_menacee' => $_POST['est_menacee_modif'] ?? ''
        ];

        if (empty($data['nom_espece']) || empty($data['nom_latin_espece']) || $data['est_menacee'] === '') {
            $this->redirectWithMessage('formEditionEspece', 'Tous les champs sont obligatoires.', 'error');
            return;
        }

        // Vérifier que l'espèce existe
        $espece = $this->serviceEspece->getEspeceParID($id);
        if (!$espece) {
            $this->redirectWithMessage('adminDashboard', 'Espèce non trouvée.', 'error');
            return;
        }

        if ($this->serviceEspece->updateEspece($id, $data)) {
            $this->logEvent(
                'UPDATE_BD',
                "Espèce mise à jour: id={$id}"
            );
            $this->redirectWithMessage('adminDashboard', 'Espèce mise à jour avec succès.', 'success');
        } else {
            $this->logEvent(
                'ERREUR',
                "Erreur lors de la mise à jour de l'espèce id={$id}"
            );
            $this->redirectWithMessage('formEditionEspece', 'Erreur lors de la mise à jour de l\'espèce.', 'error');
        }
    }

    // ========================
    //  Prestataires
    // ========================

    /**
     * Affiche le formulaire de création d'un prestataire
     *
     * @return void
     */
    public function formCreationPrestataire(): void
    {
        $this->requireRole(ADMINID);
        $this->render('administrateur/v-createPrestataire', [
            'title' => 'Créer un prestataire'
        ]);
    }

    /**
     * Traite l'ajout d'un nouveau prestataire
     *
     * @return void
     */
    public function ajoutPrestataire(): void
    {
        $this->requireRole(ADMINID);
        if ($this->serviceReparation->ajoutPrestataire()) {
            $this->logEvent(
                'INSERTION_BD',
                "Nouveau prestataire ajouté"
            );
            $this->redirectWithMessage('adminDashboard', 'Prestataire ajouté avec succès.', 'success');
        } else {
            $this->logEvent(
                'ERREUR',
                "Erreur lors de l'ajout d'un prestataire"
            );
            $this->redirectWithMessage('creationPrestataire', 'Erreur lors de l\'ajout du prestataire.', 'error');
        }
    }

    /**
     * Affiche le formulaire d'édition d'un prestataire
     *
     * @param int $id Identifiant du prestataire à éditer
     * @return void
     */
    public function formEditionPrestataire(int $id): void
    {
        $this->requireRole(ADMINID);
        $prestataire = $this->serviceReparation->getAllPrestataires();

        // Chercher le prestataire avec l'ID spécifié
        $prestataire_trouve = null;
        if ($prestataire) {
            foreach ($prestataire as $p) {
                if ($p['ID_PRESTATAIRE'] == $id) {
                    $prestataire_trouve = $p;
                    break;
                }
            }
        }

        if ($prestataire_trouve === null) {
            $this->redirectWithMessage('adminDashboard', 'Prestataire non trouvé.', 'error');
        } else {
            $this->render('administrateur/v-editionPrestataire', [
                'prestataire' => $prestataire_trouve,
                'title' => 'Modifier un prestataire'
            ]);
        }
    }

    /**
     * Met à jour les informations d'un prestataire
     *
     * @param int $id Identifiant du prestataire à mettre à jour
     * @return void
     */
    public function majPrestataire(int $id): void
    {
        $this->requireRole(ADMINID);
        $data = [
            'NOM_PRESTATAIRE' => $_POST['nom_modif'] ?? '',
            'PRENOM_PRESTATAIRE' => $_POST['prenom_modif'] ?? ''
        ];

        if (empty($data['NOM_PRESTATAIRE']) || empty($data['PRENOM_PRESTATAIRE'])) {
            $this->redirectWithMessage('editionPrestataire', 'Tous les champs sont obligatoires.', 'error');
            return;
        }

        // Récupérer le modèle Prestataire via la service
        $prestataire = $this->serviceReparation->getPrestataireByID($id);
        if (!$prestataire) {
            $this->redirectWithMessage('adminDashboard', 'Prestataire non trouvé.', 'error');
            return;
        }

        // Appel direct au modèle via la service
        if ($this->serviceReparation->updatePrestataire($id, $data)) {
            $this->logEvent(
                'UPDATE_BD',
                "Prestataire mis à jour: id={$id}"
            );
            $this->redirectWithMessage('adminDashboard', 'Prestataire mis à jour avec succès.', 'success');
        } else {
            $this->logEvent(
                'ERREUR',
                "Erreur lors de la mise à jour du prestataire id={$id}"
            );
            $this->redirectWithMessage('editionPrestataire', 'Erreur lors de la mise à jour du prestataire.', 'error');
        }
    }

    /**
     * Supprime un prestataire de la base de données
     *
     * @param int $id Identifiant du prestataire à supprimer
     * @return void
     */
    public function supprPrestataire(int $id): void
    {
        $this->requireRole(ADMINID);
        // Vérifier que le prestataire existe
        $prestataire = $this->serviceReparation->getPrestataireByID($id);

        if (!$prestataire) {
            $this->redirectWithMessage('adminDashboard', 'Prestataire non trouvé.', 'error');
            return;
        }

        if ($this->serviceReparation->supprPrestataire($id)) {
            $this->logEvent(
                'SUPPRESSION_BD',
                "Prestataire supprimé: id={$id}"
            );
            $this->redirectWithMessage('adminDashboard', 'Prestataire supprimé avec succès.', 'success');
        } else {
            $this->logEvent(
                'ERREUR',
                "Erreur lors de la suppression du prestataire id={$id}"
            );
            $this->redirectWithMessage('adminDashboard', 'Erreur lors de la suppression du prestataire.', 'error');
        }
    }

    // ========================
    //  Contrats de travail
    // ========================

    /**
     * Supprime un contrat de travail
     *
     * @param int $id_contrat Identifiant du contrat à supprimer
     * @return void
     */
    public function supprContrat(int $id_contrat): void
    {
        $this->requireRole(ADMINID);

        if ($this->serviceEmployee->supprContrat($id_contrat)) {
            $this->logEvent(
                'SUPPRESSION_BD',
                "Contrat de travail supprimé: id={$id_contrat}"
            );
            $this->redirectWithMessage('adminDashboard', 'Contrat de travail supprimé avec succès.', 'success');
        } else {
            $this->logEvent(
                'ERREUR',
                "Erreur lors de la suppression du contrat id={$id_contrat}"
            );
            $this->redirectWithMessage('adminDashboard', 'Erreur lors de la suppression du contrat.', 'error');
        }
    }

    // ========================
    //  Enclos
    // ========================

    /**
     * Affiche le formulaire de création d'un enclos
     *
     * @return void
     */
    public function formCreationEnclos(): void
    {
        $this->requireRole(ADMINID);
        $zones = $this->serviceZone->getAll();
        $this->render('administrateur/v-createEnclos', [
            'zones' => $zones,
            'title' => 'Créer un enclos'
        ]);
    }

    /**
     * Traite l'ajout d'un nouvel enclos
     *
     * @return void
     */
    public function ajoutEnclos(): void
    {
        $this->requireRole(ADMINID);
        $data = [
            'LATITUDE' => $_POST['latitude'] ?? '',
            'LONGITUDE' => $_POST['longitude'] ?? '',
            'ID_ZONE' => $_POST['id_zone'] ?? '',
            'TYPE_ENCLOS' => $_POST['type_enclos'] ?? ''
        ];

        if (empty($data['LATITUDE']) || empty($data['LONGITUDE']) || empty($data['ID_ZONE']) || empty($data['TYPE_ENCLOS'])) {
            $this->redirectWithMessage('formCreationEnclos', 'Tous les champs sont obligatoires.', 'error');
            return;
        }

        if ($this->serviceEnclos->ajoutEnclos($data)) {
            $this->logEvent(
                'INSERTION_BD',
                "Nouvel enclos ajouté - Lat: {$data['LATITUDE']}, Long: {$data['LONGITUDE']}"
            );
            $this->redirectWithMessage('adminDashboard', 'Enclos ajouté avec succès.', 'success');
        } else {
            $this->logEvent(
                'ERREUR',
                "Erreur lors de l'ajout d'un enclos"
            );
            $this->redirectWithMessage('formCreationEnclos', 'Erreur lors de l\'ajout de l\'enclos.', 'error');
        }
    }

    /**
     * Affiche le formulaire d'édition d'un enclos
     *
     * @return void
     */
    public function formEditionEnclos(): void
    {
        $this->requireRole(ADMINID);
        $latitude = $_GET['latitude'] ?? null;
        $longitude = $_GET['longitude'] ?? null;

        if (!$latitude || !$longitude) {
            $this->redirectWithMessage('adminDashboard', 'Enclos non trouvé.', 'error');
            return;
        }

        $enclos = $this->serviceEnclos->getEnclosParCoordonnees($latitude, $longitude);
        if (!$enclos) {
            $this->redirectWithMessage('adminDashboard', 'Enclos non trouvé.', 'error');
            return;
        }

        $zones = $this->serviceZone->getAll();
        $this->render('administrateur/v-editionEnclos', [
            'enclos' => $enclos,
            'zones' => $zones,
            'title' => 'Modifier un enclos'
        ]);
    }

    /**
     * Met à jour les informations d'un enclos
     *
     * @return void
     */
    public function majEnclos(): void
    {
        $this->requireRole(ADMINID);
        $latitude = $_GET['latitude'] ?? null;
        $longitude = $_GET['longitude'] ?? null;

        if (!$latitude || !$longitude) {
            $this->redirectWithMessage('adminDashboard', 'Enclos non trouvé.', 'error');
            return;
        }

        $data = [
            'ID_ZONE' => $_POST['id_zone'] ?? '',
            'TYPE_ENCLOS' => $_POST['type_enclos'] ?? ''
        ];

        if (empty($data['ID_ZONE']) || empty($data['TYPE_ENCLOS'])) {
            $this->redirectWithMessage('formEditionEnclos', 'Tous les champs sont obligatoires.', 'error');
            return;
        }

        if ($this->serviceEnclos->majEnclos($latitude, $longitude, $data)) {
            $this->logEvent(
                'UPDATE_BD',
                "Enclos mis à jour - Lat: {$latitude}, Long: {$longitude}"
            );
            $this->redirectWithMessage('adminDashboard', 'Enclos mis à jour avec succès.', 'success');
        } else {
            $this->logEvent(
                'ERREUR',
                "Erreur lors de la mise à jour de l'enclos Lat: {$latitude}, Long: {$longitude}"
            );
            $this->redirectWithMessage('formEditionEnclos', 'Erreur lors de la mise à jour de l\'enclos.', 'error');
        }
    }

    /**
     * Supprime un enclos de la base de données
     *
     * @return void
     */
    public function supprEnclos(): void
    {
        $this->requireRole(ADMINID);
        $latitude = $_GET['latitude'] ?? null;
        $longitude = $_GET['longitude'] ?? null;

        if (!$latitude || !$longitude) {
            $this->redirectWithMessage('adminDashboard', 'Enclos non trouvé.', 'error');
            return;
        }

        $enclos = $this->serviceEnclos->getEnclosParCoordonnees($latitude, $longitude);
        if (!$enclos) {
            $this->redirectWithMessage('adminDashboard', 'Enclos non trouvé.', 'error');
            return;
        }

        if ($this->serviceEnclos->supprEnclos($latitude, $longitude)) {
            $this->logEvent(
                'SUPPRESSION_BD',
                "Enclos supprimé - Lat: {$latitude}, Long: {$longitude}"
            );
            $this->redirectWithMessage('adminDashboard', 'Enclos supprimé avec succès.', 'success');
        } else {
            $this->logEvent(
                'ERREUR',
                "Erreur lors de la suppression de l'enclos Lat: {$latitude}, Long: {$longitude}"
            );
            $this->redirectWithMessage('adminDashboard', 'Erreur lors de la suppression de l\'enclos.', 'error');
        }
    }

    // ========================
    //  Réparations/Entretiens
    // ========================

    /**
     * Supprime une réparation/entretien
     *
     * @return void
     */
    public function supprReparation($dateDebut, $longitude, $latitude): void
    {
        $this->requireRole(ADMINID);
        if (!$dateDebut || !$latitude || !$longitude) {
            $this->redirectWithMessage("profilEnclos&latitude={$latitude}&longitude={$longitude}", 'Réparation non trouvée.', 'error');
            return;
        }

        // Vérifier que la réparation existe
        $reparation = $this->serviceReparation->getReparation($dateDebut, $longitude, $latitude);

        if (!$reparation) {
            $this->redirectWithMessage("profilEnclos&latitude={$latitude}&longitude={$longitude}", 'Réparation non trouvée.', 'error');
            return;
        }

        if ($this->serviceReparation->supprReparation($dateDebut, $latitude, $longitude)) {
            $this->logEvent(
                'SUPPRESSION_BD',
                "Réparation supprimée - Date: {$dateDebut}, Lat: {$latitude}, Long: {$longitude}"
            );
            $this->redirectWithMessage("profilEnclos&latitude={$latitude}&longitude={$longitude}", 'Réparation supprimée avec succès.', 'success');
        } else {
            $this->logEvent(
                'ERREUR',
                "Erreur lors de la suppression de la réparation Date: {$dateDebut}"
            );
            $this->redirectWithMessage("profilEnclos&latitude={$latitude}&longitude={$longitude}", 'Erreur lors de la suppression de la réparation.', 'error');
        }
    }

    /**
     * Affiche le formulaire d'édition d'une réparation/entretien
     *
     * @param string $date_debut Date de début de la réparation
     * @param float $latitude Latitude de l'enclos
     * @param float $longitude Longitude de l'enclos
     * @return void
     */
    public function formEditionReparation(string $date_debut, float $latitude, float $longitude): void
    {
        $this->requireRole(ADMINID);

        if (!$date_debut || !is_numeric($latitude) || !is_numeric($longitude)) {
            $this->redirectWithMessage("profilEnclos&latitude={$latitude}&longitude={$longitude}", 'Réparation non trouvée.', 'error');
            return;
        }

        $reparation = $this->serviceReparation->getReparation($date_debut, $longitude, $latitude);
        $prestataires = $this->serviceReparation->getAllPrestataires();

        if (!$reparation) {
            $this->redirectWithMessage("profilEnclos&latitude={$latitude}&longitude={$longitude}", 'Réparation non trouvée.', 'error');
            return;
        }

        $this->render('personnelEntretien/v-editionReparation', [
            'reparation' => $reparation,
            'prestataires' => $prestataires,
            'title' => 'Éditer une réparation'
        ]);
    }

    /**
     * Met à jour une réparation/entretien existante
     *
     * @return void
     */
    public function updateReparation(): void
    {
        $this->requireRole(ADMINID);

        $dateDebut = $_GET['date_debut'] ?? null;
        $latitude = $_GET['latitude'] ?? null;
        $longitude = $_GET['longitude'] ?? null;

        if (!$dateDebut || $latitude === null || $longitude === null) {
            $this->redirectWithMessage("profilEnclos&latitude={$latitude}&longitude={$longitude}", 'Réparation non trouvée.', 'error');
            return;
        }

        // Vérifier que la réparation existe
        $reparation = $this->serviceReparation->getReparation($dateDebut, $longitude, $latitude);
        if (!$reparation) {
            $this->redirectWithMessage("profilEnclos&latitude={$latitude}&longitude={$longitude}", 'Réparation non trouvée.', 'error');
            return;
        }

        $data = [
            'DATE_DEBUT_REPARATION' => $_POST['DATE_DEBUT_REPARATION'],
            'LONGITUDE_ENCLOS' => $longitude,
            'LATITUDE_ENCLOS' => $latitude,
            'ID_PRESTATAIRE' => $_POST['ID_PRESTATAIRE'] ?? null,
            'DATE_FIN' => $_POST['DATE_FIN'] ?? null,
            'NATURE_REPARATION' => $_POST['NATURE_REPARATION'] ?? null,
            'COUT_REPARATION' => $_POST['COUT_REPARATION'] ?? null
        ];

        echo $data['COUT_REPARATION'] . "<br>";
        echo $data['DATE_DEBUT_REPARATION'] . "<br>";
        echo $data['DATE_FIN'] . "<br>";

        if ($this->serviceReparation->updateReparation($data)) {
            $this->logEvent(
                'MODIFICATION_BD',
                "Réparation modifiée - Date: {$dateDebut}, Lat: {$latitude}, Long: {$longitude}"
            );
            $this->redirectWithMessage("profilEnclos&latitude={$latitude}&longitude={$longitude}", 'Réparation modifiée avec succès.', 'success');
        } else {
            $this->logEvent(
                'ERREUR',
                "Erreur lors de la modification de la réparation Date: {$dateDebut}"
            );
            $this->redirectWithMessage("profilEnclos&latitude={$latitude}&longitude={$longitude}", 'Erreur lors de la modification de la réparation.', 'error');
        }
    }

    // ========================
    //  Compatibilités d'Espèces
    // ========================

    /**
     * Affiche le formulaire de création d'une compatibilité entre espèces
     *
     * @return void
     */
    public function formCreationCompatibilite(): void
    {
        $this->requireRole(ADMINID);
        $especes = $this->serviceEspece->getAll();
        $this->render('administrateur/v-createCompatibilite', [
            'especes' => $especes,
            'title' => 'Ajouter une compatibilité'
        ]);
    }

    /**
     * Traite l'ajout d'une compatibilité entre deux espèces
     *
     * @return void
     */
    public function ajoutCompatibilite(): void
    {
        $this->requireRole(ADMINID);
        $id_espece1 = $_POST['id_espece1'] ?? null;
        $id_espece2 = $_POST['id_espece2'] ?? null;

        if (!$id_espece1 || !$id_espece2) {
            $this->redirectWithMessage('formCreationCompatibilite', 'Tous les champs sont obligatoires.', 'error');
            return;
        }

        if ($id_espece1 == $id_espece2) {
            $this->redirectWithMessage('formCreationCompatibilite', 'Vous ne pouvez pas créer une compatibilité entre la même espèce.', 'error');
            return;
        }

        // Vérifier que les espèces existent
        $e1 = $this->serviceEspece->getEspeceParID($id_espece1);
        $e2 = $this->serviceEspece->getEspeceParID($id_espece2);

        if (!$e1 || !$e2) {
            $this->redirectWithMessage('formCreationCompatibilite', 'Une ou plusieurs espèces non trouvées.', 'error');
            return;
        }

        if ($this->serviceCompatibilite->ajoutCompatibilite()) {
            $this->logEvent(
                'INSERTION_BD',
                "Compatibilité ajoutée entre espèce {$id_espece1} et {$id_espece2}"
            );
            $this->redirectWithMessage('adminDashboard', 'Compatibilité ajoutée avec succès.', 'success');
        } else {
            $this->logEvent(
                'ERREUR',
                "Erreur lors de l'ajout d'une compatibilité"
            );
            $this->redirectWithMessage('formCreationCompatibilite', 'Erreur lors de l\'ajout de la compatibilité (peut-être qu\'elle existe déjà).', 'error');
        }
    }

    /**
     * Supprime une compatibilité entre deux espèces
     *
     * @return void
     */
    public function supprCompatibilite(): void
    {
        $this->requireRole(ADMINID);
        $id_espece1 = $_GET['espece1'] ?? null;
        $id_espece2 = $_GET['espece2'] ?? null;

        if (!$id_espece1 || !$id_espece2) {
            $this->redirectWithMessage('adminDashboard', 'Compatibilité non trouvée.', 'error');
            return;
        }

        // Vérifier que la compatibilité existe
        if (!$this->serviceCompatibilite->verifierCompatibilite($id_espece1, $id_espece2)) {
            $this->redirectWithMessage('adminDashboard', 'Compatibilité non trouvée.', 'error');
            return;
        }

        if ($this->serviceCompatibilite->supprCompatibilite($id_espece1, $id_espece2)) {
            $this->logEvent(
                'SUPPRESSION_BD',
                "Compatibilité supprimée entre espèce {$id_espece1} et {$id_espece2}"
            );
            $this->redirectWithMessage('adminDashboard', 'Compatibilité supprimée avec succès.', 'success');
        } else {
            $this->logEvent(
                'ERREUR',
                "Erreur lors de la suppression de la compatibilité"
            );
            $this->redirectWithMessage('adminDashboard', 'Erreur lors de la suppression de la compatibilité.', 'error');
        }
    }
}
