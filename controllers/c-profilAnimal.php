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
        if ($id === null) {
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

        $title = "Profil de {$animal['NOM_ANIMAL']} - Zoo'land";
        $this->render('animal/v-profil', ['title' => $title, 'animal' => $animal, 'nourritures' => $nourritures, 'soins' => $soins, 'parrains' => $listeParrains, 'visiteurs' => $visiteurs, 'libelles' => $libelles]);
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
            $this->redirectWithMessage('profilAnimal&id=' . $_POST['id_animal'], 'Données manquantes.', 'error');
        }

        $id_animal = $_POST['id_animal'];

        $result = $this->serviceParrainage->creerParrainage();

        if ($result) {
            $this->logEvent(
                'INSERTION_BD',
                "Nouveau parrainage ajouté pour l'animal id={$id_animal}"
            );
            $this->redirectWithMessage('profilAnimal&id=' . $id_animal, 'Parrainage ajouté avec succès.', 'success');
        } else {
            $this->logEvent(
                'ERREUR',
                "Erreur lors de l'ajout du parrainage pour l'animal id={$id_animal}"
            );
            $this->redirectWithMessage('profilAnimal&id=' . $id_animal, 'Erreur lors de l\'ajout du parrainage.', 'error');
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
            $this->redirectWithMessage('profilAnimal&id=' . $_GET['id_animal'], 'Données manquantes.', 'error');
        }

        $id_animal = $_GET['idAnimal'];
        $id_visiteur = $_GET['idVisiteur'];

        $result = $this->serviceParrainage->supprimerParrainage($id_animal, $id_visiteur);

        if ($result) {
            $this->logEvent(
                'DELETE_BD',
                "Parrainage supprimé pour l'animal id={$id_animal} et visiteur id={$id_visiteur}"
            );
            $this->redirectWithMessage('profilAnimal&id=' . $id_animal, 'Parrainage supprimé avec succès.', 'success');
        } else {
            $this->logEvent(
                'ERREUR',
                "Erreur lors de la suppression du parrainage pour l'animal id={$id_animal} et visiteur id={$id_visiteur}"
            );
            $this->redirectWithMessage('profilAnimal&id=' . $id_animal, 'Erreur lors de la suppression du parrainage.', 'error');
        }
    }
}
