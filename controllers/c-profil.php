<?php

class ProfilController extends BaseController
{

    private $serviceEmployee;

    public function __construct()
    {
        $this->serviceEmployee = new ServiceEmployee();
    }

    public function profil($id)
    {
        $id_user = $_GET['id'] ?? null;
        if ($id_user === null) {
            $id_user = $id;
        }
        // Vérifier si l'utilisateur est connecté
        if (empty($_SESSION['user'])) {
            $this->redirectWithMessage('afficheConnexion', 'Vous devez être connecté pour accéder à votre profil.', 'error');
        }

        $user = $this->serviceEmployee->getEmployeeParID($id_user);

        if (!$user) {
            $this->redirectWithMessage('home', 'Utilisateur introuvable.', 'error');
        }

        $historique = $this->serviceEmployee->getContratsParID($id_user);
        $title = "Mon profil";

        $this->render('profil/v-profil', [
            'title' => $title,
            'user' => $user,
            'id_user' => $id_user,
            'historique' => $historique

        ]);
    }

    public function updatePassword()
    {
        // Met à jour le MDP de l'utilisateur connecté
        if (empty($_SESSION['user'])) {
            $this->redirectWithMessage('afficheConnexion', 'Vous devez être connecté pour modifier votre mot de passe.', 'error');
        }

        $userId = $_SESSION['user']['ID_PERSONNEL'];
        $oldPassword = $_POST['old_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        $user = $this->serviceEmployee->getEmployeeParID($userId);

        // mdp = actuel ?
        if (!password_verify($oldPassword, $user['MDP'])) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Le mot de passe actuel est incorrect.'];
            $this->redirectWithMessage('profil', 'Le mot de passe actuel est incorrect.', "error");
        }

        // correspondance entre les mdp
        if ($newPassword !== $confirmPassword) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Les nouveaux mots de passe ne correspondent pas.'];
            $this->redirectWithMessage('profil', 'Les nouveaux mots de passe ne correspondent pas.', "error");
        }

        // longueur du mdp
        if (strlen($newPassword) < 6) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Le nouveau mot de passe doit contenir au moins 6 caractères.'];
            $this->redirectWithMessage('profil', 'Le nouveau mot de passe doit contenir au moins 6 caractères.', "error");
        }

        // maj du mdp
        $MDP = password_hash($newPassword, PASSWORD_DEFAULT);

        if ($this->serviceEmployee->majPassword($userId, $MDP)) {
            $this->logEvent(
                'UPDATE_BD',
                "Mot de passe mis à jour pour l'utilisateur id={$userId}"
            );
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Votre mot de passe a été modifié avec succès.'];
        } else {
            $this->logEvent(
                'ERREUR',
                "Erreur lors de la mise à jour du mot de passe pour l'utilisateur id={$userId}"
            );
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Une erreur a eu lieu lors de la mise à jour du profil.'];
        }

        $this->redirect('profil', $userId);
    }
}
