<?php
require_once 'models/User.php';

class GestionProfil {

    public function profil() {

        // Vérifier si l'utilisateur est connecté
        if (empty($_SESSION['user'])) {
            header('Location: index.php?action=afficheConnexion');
            exit;
        }

        $userId = $_SESSION['user']['ID_Personnel'];
        
        $user = User::recupParID($userId);

        if (!$user) {
            die("Utilisateur introuvable");
        }

        $title = "Mon profil";

        $view = 'views/profil/profil.php';

        require_once 'views/includes.php';
    }

    public function update_password() {
        // Met à jour le MDP de l'utilisateur connecté
        if (empty($_SESSION['user'])) {
            header('Location: index.php?action=afficheConnexion');
            exit;
        }

        $userId = $_SESSION['user']['ID_Personnel'];
        $oldPassword = $_POST['old_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        $user = User::recupParID($userId);

        // mdp = actuel ?
        if (!password_verify($oldPassword, $user['MDP'])) {
            $_SESSION['message_error'] = "Le mot de passe actuel est incorrect.";
            header('Location: index.php?action=profil');
            exit;
        }

        // correspondance entre les mdp
        if ($newPassword !== $confirmPassword) {
            $_SESSION['message_error'] = "Les nouveaux mots de passe ne correspondent pas.";
            header('Location: index.php?action=profil');
            exit;
        }

        // longueur du mdp
        if (strlen($newPassword) < 6) {
            $_SESSION['message_error'] = "Le nouveau mot de passe doit contenir au moins 6 caractères.";
            header('Location: index.php?action=profil');
            exit;
        }

        // maj du mdp
        $data = [
            'nom' => $user['Nom'],
            'prenom' => $user['Prenom'],
            'mail' => $user['mail'],
            'MDP' => password_hash($newPassword, PASSWORD_DEFAULT),
            'date_entree' => $user['Date_Entree'],
            'salaire' => $user['Salaire'],
            'id_role' => $user['ID_Role'],
            'login' => $user['login']
        ];

        User::maj($userId, $data);

        $_SESSION['message_success'] = "Votre mot de passe a été modifié avec succès.";
        header('Location: index.php?action=profil');
        exit;
    }

}
