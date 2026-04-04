<?php


class ProfilAnimalController extends BaseController
{
    private $serviceAnimal;
    private $serviceSoin;
    private $serviceParrainage;
    public function __construct()
    {
        $this->serviceAnimal = new ServiceAnimal();
        $this->serviceSoin = new ServiceSoin();
        $this->serviceParrainage = new ServiceParrainage();
    }
    /**
     * Affiche le profil complet d'un animal
     * Inclut l'historique des soins, nourritures et parrainages
     * @param int $id ID de l'animal
     * @return void Affiche le profil ou redirige si animal introuvable
     */
    public function profilAnimal(int $id): void
    {
        if ($id == null) {
            $this->redirectWithMessage('home', 'Animal non trouvé.', 'error');
        }

        $animal = $this->serviceAnimal->getAnimalParID($id);
        if (!$animal) {
            $this->redirectWithMessage('home', 'Animal non trouvé.', 'error');
        }
        $nourritures = $this->serviceSoin->getNourritureParAnimal($id);
        $soins = $this->serviceSoin->getSoinsParAnimal($id);
        $listeParrains = $this->serviceParrainage->getParrainsParAnimal($id);
        $visiteurs = $this->serviceParrainage->getTousVisiteurs();
        $libelles = $this->serviceParrainage->getLibelleParrainages();
        $parents = $this->serviceAnimal->getParents($id);
        $enfants = $this->serviceAnimal->getEnfants($id);
        $tousAnimaux = $this->serviceAnimal->getTousAnimaux(); // Pour le formulaire d'ajout de parenté

        $title = "Profil de {$animal['NOM_ANIMAL']} - Zoo'land";
        $this->render('animal/v-profil', ['title' => $title, 'animal' => $animal, 'nourritures' => $nourritures, 'soins' => $soins, 'parrains' => $listeParrains, 'visiteurs' => $visiteurs, 'libelles' => $libelles, 'parents' => $parents, 'enfants' => $enfants, 'tousAnimaux' => $tousAnimaux]);
    }

    /**
     * Ajoute un nouveau parrainage pour un animal
     * Accessible uniquement aux responsables soigneurs
     * @return void Redirige avec message de succès ou erreur
     */
    public function ajouterParrainage(): void
    {
        // Vérifier que l'utilisateur est autorisé (RESPSOIG ou ADMINID)
        if (!isset($_SESSION['user']['ID_FONCTION']) || ($_SESSION['user']['ID_FONCTION'] != RESPSOIG && $_SESSION['user']['ID_FONCTION'] != ADMINID)) {
            $this->redirectWithMessage('home', 'Accès refusé.', 'error');
        }

        if (empty($_POST['id_animal']) || empty($_POST['id_visiteur']) || empty($_POST['libelle'])) {
            $this->redirectWithMessage('profilAnimal', 'Données manquantes.', 'error', ['id' => $_POST['id_animal']]);
        }

        $id_animal = $_POST['id_animal'];

        $result = $this->serviceParrainage->creerParrainage();

        if ($result) {
            $this->logEvent(
                'INSERTION_BD',
                "Nouveau parrainage ajouté pour l'animal id={$id_animal}"
            );
            $this->redirectWithMessage('profilAnimal', 'Parrainage ajouté avec succès.', 'success', ['id' => $_POST['id_animal']]);
        } else {
            $this->logEvent(
                'ERREUR',
                "Erreur lors de l'ajout du parrainage pour l'animal id={$id_animal}"
            );
            $this->redirectWithMessage('profilAnimal', 'Erreur lors de l\'ajout du parrainage.', 'error', ['id' => $_POST['id_animal']]);
        }
    }

    /**
     * Supprime un parrainage entre un animal et un visiteur
     * Accessible uniquement à l'administrateur
     * @return void Redirige avec message de succès ou erreur
     */
    public function supprimerParrainage(): void
    {
        $this->requireRole(ADMINID);

        if (empty($_GET['idAnimal']) || empty($_GET['idVisiteur'])) {
            $this->redirectWithMessage('profilAnimal', 'Données manquantes.', 'error', ['id' => $_POST['id_animal']]);
        }

        $id_animal = $_GET['idAnimal'];
        $id_visiteur = $_GET['idVisiteur'];

        $result = $this->serviceParrainage->supprimerParrainage($id_animal, $id_visiteur);

        if ($result) {
            $this->logEvent(
                'DELETE_BD',
                "Parrainage supprimé pour l'animal id={$id_animal} et visiteur id={$id_visiteur}"
            );
            $this->redirectWithMessage('profilAnimal', 'Parrainage supprimé avec succès.', 'success', ['id' => $id_animal]);
        } else {
            $this->logEvent(
                'ERREUR',
                "Erreur lors de la suppression du parrainage pour l'animal id={$id_animal} et visiteur id={$id_visiteur}"
            );
            $this->redirectWithMessage('profilAnimal', 'Erreur lors de la suppression du parrainage.', 'error', ['id' => $id_animal]);
        }
    }

    /**
     * Affiche la page de création d'un lien de parenté
     * Accessible uniquement à l'administrateur
     * @return void Affiche la vue de création
     */
    public function creationParente(): void
    {
        $this->requireRole(ADMINID);

        $animals = $this->serviceAnimal->getTousAnimaux();

        $title = "Ajouter un lien de parenté - Zoo'land";
        $this->render('animal/v-creationParente', ['title' => $title, 'animals' => $animals]);
    }

    /**
     * Ajoute un lien de parenté entre deux animaux
     * Accessible uniquement à l'administrateur
     * @return void Redirige avec message de succès ou erreur
     */
    public function ajouterParente(): void
    {
        $this->requireRole(ADMINID);

        if (empty($_POST['id_enfant']) || empty($_POST['id_parent'])) {
            $idAnimal = $_POST['id_enfant'] ?? $_GET['id'] ?? 0;
            $this->redirectWithMessage('profilAnimal', 'Parent et enfant requis.', 'error', ['id' => $idAnimal]);
        }

        $id_parent = $_POST['id_parent'];
        $id_enfant = $_POST['id_enfant'];

        // Vérifier que les deux animaux existent
        $parent = $this->serviceAnimal->getAnimalParID($id_parent);
        $enfant = $this->serviceAnimal->getAnimalParID($id_enfant);

        if (!$parent || !$enfant) {
            $this->redirectWithMessage('profilAnimal', 'L\'un des animaux n\'existe pas.', 'error', ['id' => $id_enfant]);
        }

        // Vérifier que ce n'est pas le même animal
        if ($id_parent == $id_enfant) {
            $this->redirectWithMessage('profilAnimal', 'Un animal ne peut pas être son propre parent.', 'error', ['id' => $id_enfant]);
        }

        $result = $this->serviceAnimal->creerParente($id_parent, $id_enfant);

        if ($result) {
            $this->logEvent(
                'INSERTION_BD',
                "Lien de parenté créé : animal id={$id_parent} est parent de animal id={$id_enfant}"
            );
            $this->redirectWithMessage('profilAnimal', 'Lien de parenté créé avec succès.', 'success', ['id' => $id_enfant]);
        } else {
            $this->logEvent(
                'ERREUR',
                "Erreur lors de la création du lien de parenté : animal id={$id_parent} et animal id={$id_enfant}"
            );
            $this->redirectWithMessage('profilAnimal', 'Ce lien de parenté existe déjà ou une erreur s\'est produite.', 'error', ['id' => $id_enfant]);
        }
    }

    /**
     * Supprime un lien de parenté entre deux animaux
     * Accessible uniquement à l'administrateur
     * @return void Redirige avec message de succès ou erreur
     */
    public function supprimerParente(): void
    {
        $this->requireRole(ADMINID);

        if (empty($_GET['id_parent']) || empty($_GET['id_enfant'])) {
            $this->redirectWithMessage('home', 'Données manquantes.', 'error');
        }

        $id_parent = $_GET['id_parent'];
        $id_enfant = $_GET['id_enfant'];

        $result = $this->serviceAnimal->supprimerParente($id_parent, $id_enfant);

        if ($result) {
            $this->logEvent(
                'DELETE_BD',
                "Lien de parenté supprimé : animal id={$id_parent} n'est plus parent de animal id={$id_enfant}"
            );
            $this->redirectWithMessage('profilAnimal', 'Lien de parenté supprimé avec succès.', 'success', ['id' => $id_enfant]);
        } else {
            $this->logEvent(
                'ERREUR',
                "Erreur lors de la suppression du lien de parenté entre id={$id_parent} et id={$id_enfant}"
            );
            $this->redirectWithMessage('profilAnimal', 'Erreur lors de la suppression du lien de parenté.', 'error', ['id' => $id_enfant]);
        }
    }
}
