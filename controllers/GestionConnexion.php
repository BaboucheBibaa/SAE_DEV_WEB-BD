<?php
require_once 'models/User.php';

class GestionConnexion {

    public function afficheConnexion() {

        $title = "Connexion";

        $view = 'views/connexion/login.php';

        require 'views/includes.php';
    }


    public function connexion() {
        $login = $_POST['login'] ?? '';
        $password = $_POST['password'] ?? '';
        $user = User::recupParLogs($login);
        if ($user && password_verify($password, $user['MDP'])) {
            $_SESSION['user'] = $user;
            header('Location: index.php?action=profil');
            exit;
        } else {
            $error = "Identifiant ou mot de passe incorrect.";
        }
        $title = "Connexion";

        $view = 'views/connexion/login.php';

        require_once 'views/includes.php';

    }

    public function deconnexion() {
        session_destroy();
        header('Location: index.php?action=afficheConnexion');
        exit;
    }
}
