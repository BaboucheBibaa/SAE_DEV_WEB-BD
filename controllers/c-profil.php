<?php

class ProfilController extends BaseController
{

    private $serviceEmployee;
    private $Utils;

    public function __construct()
    {
        $this->serviceEmployee = new ServiceEmployee();
        $this->Utils = new Utils();
    }

    /**
     * Affiche le profil d'un utilisateur
     * Inclut l'historique des contrats de travail
     * @param int $id ID de l'utilisateur (peut être ignoré si passé en GET)
     * @return void Affiche le profil ou redirige si utilisateur introuvable
     */
    public function profil(int $id): void
    {
        $id_user = $_GET['id'];

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

    /**
     * Met à jour le mot de passe de l'utilisateur connecté
     * Valide l'ancien mot de passe et la confirmation du nouveau
     * @return void Redirige avec message de succès ou erreur
     */
    public function updatePassword(): void
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
        if (!$this->Utils->verifyPassword($oldPassword, $user['MDP'])) {
            $this->redirectWithMessage('profil', 'Le mot de passe actuel est incorrect.', "error",['id' => $userId]);
        }

        // correspondance entre les mdp
        if ($newPassword != $confirmPassword) {
            $this->redirectWithMessage('profil', 'Les nouveaux mots de passe ne correspondent pas.', "error",['id' => $userId]);
        }

        // longueur du mdp
        if (strlen($newPassword) < 6) {
            $this->redirectWithMessage('profil', 'Le nouveau mot de passe doit contenir au moins 6 caractères.', "error",['id' => $userId]);
        }

        $MDP = $this->Utils->hashPassword($newPassword);

        if ($this->serviceEmployee->majPassword($userId, $MDP)) {
            $this->logEvent(
                'UPDATE_BD',
                "Mot de passe mis à jour pour l'utilisateur id={$userId}"
            );
            $this->redirectWithMessage('profil', 'Votre mot de passe a été modifié avec succès.', 'success',['id' => $userId]);
        } else {
            $this->logEvent(
                'ERREUR',
                "Erreur lors de la mise à jour du mot de passe pour l'utilisateur id={$userId}"
            );
            $this->redirectWithMessage('profil', 'Une erreur a eu lieu lors de la mise à jour du profil.', 'error', ['id' => $userId]);
        }
    }
}
