<?php
require_once 'models/User.php';

class GestionConnexion {

    public function showLogin() {

        $title = "Connexion";

        $view = 'views/connexion/login.php';

        require 'views/includes.php';
    }


    public function login() {
        $login = $_POST['login'] ?? '';
        $password = $_POST['password'] ?? '';
        $user = User::recupParLogs($login);
        if ($user && password_verify($password, $user['MDP'])) {
            $_SESSION['user'] = $user;
            header('Location: index.php?action=profil');
            exit;
        }
        $title = "Connexion";

        $view = 'views/auth/login.php';

        require 'views/layout.php';

    }

    public function logout() {
        session_destroy();
        header('Location: index.php?action=login');
        exit;
    }
}
