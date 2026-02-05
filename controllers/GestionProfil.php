<?php
require_once 'models/User.php';

class GestionProfil {

    public function profile() {

        // Vérifier si l'utilisateur est connecté
        if (empty($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $userId = $_SESSION['user']['ID_Personnel'];
        
        $user = User::recupParID($userId);

        if (!$user) {
            die("Utilisateur introuvable");
        }

        $title = "Mon profil";

        $view = 'views/profil/profil.php';

        require 'views/includes.php';
    }

}
