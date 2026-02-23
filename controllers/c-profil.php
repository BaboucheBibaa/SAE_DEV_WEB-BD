<?php

class ProfilController extends BaseController
{

    public function profil()
    {

        // Vérifier si l'utilisateur est connecté
        if (empty($_SESSION['user'])) {
            $this->redirectWithMessage('afficheConnexion', 'Vous devez être connecté pour accéder à votre profil.', 'error');
        }

        $userId = $_SESSION['user']['ID_PERSONNEL'] ?? null;

        $user = User::recupParID($userId);

        if (!$user) {
            die("Utilisateur introuvable");
        }

        $title = "Mon profil";

        $this->render('profil/v-profil', [
            'title' => $title,
            'user' => $user
        ]);
    }

    public function update_password()
    {
        // Met à jour le MDP de l'utilisateur connecté
        if (empty($_SESSION['user'])) {
            $this->redirectWithMessage('afficheConnexion', 'Vous devez être connecté pour modifier votre mot de passe.', 'error');
        }

        $userId = $_SESSION['user']['ID_PERSONNEL'];
        $oldPassword = $_POST['old_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        $user = User::recupParID($userId);

        // mdp = actuel ?
        if (!password_verify($oldPassword, $user['MDP'])) {
            $_SESSION['message_error'] = "Le mot de passe actuel est incorrect.";
            $this->redirectWithMessage('profil', 'Le mot de passe actuel est incorrect.', "error");
        }

        // correspondance entre les mdp
        if ($newPassword !== $confirmPassword) {
            $_SESSION['message_error'] = "Les nouveaux mots de passe ne correspondent pas.";
            $this->redirectWithMessage('profil', 'Les nouveaux mots de passe ne correspondent pas.', "error");
        }

        // longueur du mdp
        if (strlen($newPassword) < 6) {
            $_SESSION['message_error'] = "Le nouveau mot de passe doit contenir au moins 6 caractères.";
            $this->redirectWithMessage('profil', 'Le nouveau mot de passe doit contenir au moins 6 caractères.', "error");
        }

        // maj du mdp
        $data = [
            'nom' => $user['NOM'],
            'prenom' => $user['PRENOM'] ?? '',
            'mail' => $user['MAIL'],
            'MDP' => password_hash($newPassword, PASSWORD_DEFAULT),
            'date_entree' => $user['DATE_ENTREE'],
            'salaire' => $user['SALAIRE'],
            'id_role' => $user['ID_ROLE'],
            'login' => $user['LOGIN']
        ];

        if (User::maj($userId, $data)) {
            $_SESSION['message_success'] = "Votre mot de passe a été modifié avec succès.";
        } else {
            $_SESSION['message_error'] = "Une erreur a eu lieu lors de la mise à jour du profil.";
        }

        $this->redirectWithMessage('profil', 'Votre mot de passe a été modifié avec succès.', "success");
    }
}
