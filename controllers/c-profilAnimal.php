<?php 


class ProfilAnimalController extends BaseController {
    private $serviceAnimal;
    private $serviceSoin;
    private $serviceParrainage;
    public function __construct() {
        $this->serviceAnimal = new ServiceAnimal();
        $this->serviceSoin = new ServiceSoin();
        $this->serviceParrainage = new ServiceParrainage();
    }
    public function profilAnimal($id) {
        if ($id === null) {
            $this->redirectWithMessage('home', 'Animal non trouvé.', 'error');
        }

        $animal = $this->serviceAnimal->getAnimalParID($id);
        if (!$animal) {
            $this->redirectWithMessage('home', 'Animal non trouvé.', 'error');
        }
        $nourriture = $this->serviceSoin->getNourritureParAnimal($id);
        $soins = $this->serviceSoin->getSoinsParAnimal($id);
        $listeParrains = $this->serviceParrainage->getParrainsParAnimal($id);
        $visiteurs = $this->serviceParrainage->getTousVisiteurs();
        $niveaux = $this->serviceParrainage->getNiveauxParrainage();
        $canEdit = false;
        if (isset($_SESSION['user']['ID_FONCTION']) && ($_SESSION['user']['ID_FONCTION'] == RESPSOIG || $_SESSION['user']['ID_FONCTION'] == ADMINID)) {
            $canEdit = true;
        };
        
        $title = "Profil de {$animal['NOM_ANIMAL']} - Zoo'land";
        $this->render('animal/v-profil', ['title' => $title, 'animal' => $animal, 'nourriture' => $nourriture, 'soins' => $soins, 'parrains' => $listeParrains, 'visiteurs' => $visiteurs, 'niveaux' => $niveaux, 'canEdit' => $canEdit]);
    }

    public function ajouterParrainage() {
        // Vérifier que l'utilisateur est autorisé (RESPSOIG ou ADMINID)
        if (!isset($_SESSION['user']['ID_FONCTION']) || ($_SESSION['user']['ID_FONCTION'] != RESPSOIG && $_SESSION['user']['ID_FONCTION'] != ADMINID)) {
            $this->redirectWithMessage('home', 'Accès refusé.', 'error');
        }

        if (empty($_POST['id_animal']) || empty($_POST['id_visiteur']) || empty($_POST['id_parrainage'])) {
            $this->redirectWithMessage('profilAnimal&id='.$_POST['id_animal'], 'Données manquantes.', 'error');
        }

        $id_animal = $_POST['id_animal'];
        $id_visiteur = $_POST['id_visiteur'];
        $id_parrainage = $_POST['id_parrainage'];

        $result = $this->serviceParrainage->creerParrainage($id_animal, $id_visiteur, $id_parrainage);
        
        if ($result) {
            $this->redirectWithMessage('profilAnimal&id='.$id_animal, 'Parrainage ajouté avec succès.', 'success');
        } else {
            $this->redirectWithMessage('profilAnimal&id='.$id_animal, 'Erreur lors de l\'ajout du parrainage.', 'error');
        }
    }

    public function supprimerParrainage() {
        // Vérifier que l'utilisateur est autorisé (RESPSOIG ou ADMINID)
        if (!isset($_SESSION['user']['ID_FONCTION']) || ($_SESSION['user']['ID_FONCTION'] != RESPSOIG && $_SESSION['user']['ID_FONCTION'] != ADMINID)) {
            $this->redirectWithMessage('home', 'Accès refusé.', 'error');
        }

        if (empty($_POST['id_animal']) || empty($_POST['id_visiteur'])) {
            $this->redirectWithMessage('profilAnimal&id='.$_POST['id_animal'], 'Données manquantes.', 'error');
        }

        $id_animal = $_POST['id_animal'];
        $id_visiteur = $_POST['id_visiteur'];

        $result = $this->serviceParrainage->supprimerParrainage($id_animal, $id_visiteur);
        
        if ($result) {
            $this->redirectWithMessage('profilAnimal&id='.$id_animal, 'Parrainage supprimé avec succès.', 'success');
        } else {
            $this->redirectWithMessage('profilAnimal&id='.$id_animal, 'Erreur lors de la suppression du parrainage.', 'error');
        }
    }
}