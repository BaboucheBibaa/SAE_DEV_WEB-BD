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
        
        // si l'utilisateur existe, vérifier le mot de passe
        $loginValide = false;
        
        if ($user && isset($user['MDP'])) {
            $mdp_base = $user['MDP'];
            
            //bcrypt renvoie 60 caractères et commence par $2y$ ou $2a$ et === signifie que les deux chaînes sont identiques (même hash et même sel)
            if (strlen($mdp_base) == 60 && (substr($mdp_base, 0, 4) === '$2y$' || substr($mdp_base, 0, 4) === '$2a$')) {
                $loginValide = password_verify($password, $mdp_base);
            } else {
                // Mot de passe en clair : comparaison directe
                $loginValide = ($password === $mdp_base);
            }
        }
        
        if ($loginValide) {
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
        header('Location: index.php?action=home');
        exit;
    }
}
