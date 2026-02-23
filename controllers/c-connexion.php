<?php

class ConnexionController extends BaseController{

    public function home() {
        $title = "Accueil - Zoo'land";
        $this->render('v-home', ['title' => $title]);
    }

    public function afficheConnexion() {

        $title = "Connexion";

        $this->render('connexion/v-login', ['title' => $title]);
    }

    public function connexion() {
        $login = $_POST['login'] ?? '';
        $password = $_POST['password'] ?? '';
        
        $user = User::recupParLogs($login);
        
        // si l'utilisateur existe, vérifier le mot de passe
        $loginValide = Utils::verifyPassword($password, $user['MDP'] ?? '');
        
        if ($loginValide) {
            $_SESSION['user'] = $user;
            header('Location: index.php?action=profil');
            exit;
        } else {
            $error = "Identifiant ou mot de passe incorrect.";
        }
        
        $title = "Connexion";
        $this->render('connexion/v-login', [
            'title' => $title,
            'error' => $error ?? null
        ]);
    }

    public function deconnexion() {
        session_destroy();
        $this->redirectWithMessage('home', 'Vous avez été déconnecté avec succès.', 'success');
    }
}
