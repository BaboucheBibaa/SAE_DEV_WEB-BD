<?php

class ConnexionController extends BaseController
{
    private $serviceEmployee;
    private $Utils;
    public function __construct()
    {
        $this->serviceEmployee = new ServiceEmployee();
        $this->Utils = new Utils();
    }
    /**
     * Affiche la page d'accueil du site
     * @return void Affiche la vue d'accueil
     */
    public function home(): void
    {
        $title = "Accueil - Zoo'land";
        $this->render('v-home', ['title' => $title]);
    }

    /**
     * Affiche le formulaire de connexion
     * @return void Affiche le formulaire de login
     */
    public function afficheConnexion(): void
    {
        $title = "Connexion";

        $this->render('connexion/v-login', ['title' => $title]);
    }

    /**
     * Traite la tentative de connexion utilisateur
     * Valide les identifiants et crée la session utilisateur
     * @return void Redirige vers le profil si succès, réaffiche le formulaire sinon
     */
    public function connexion(): void
    {
        $login = $_POST['login'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = $this->serviceEmployee->getEmployeeParLogs($login);

        // si l'utilisateur existe, vérifier le mot de passe
        $loginValide = $this->Utils->verifyPassword($password, $user['MDP'] ?? '');

        if ($loginValide) {
            session_regenerate_id(true);
            $_SESSION['user'] = $user;
            $this->logEvent(
                'CONNEXION',
                "Connexion réussie: login={$login}, id={$user['ID_PERSONNEL']}"
            );
            header('Location: index.php?action=profil&id=' . $user['ID_PERSONNEL']);
            exit;
        } else {
            $this->logEvent(
                'ERREUR',
                "Échec connexion: login={$login}"
            );
            $error = "Identifiant ou mot de passe incorrect.";
        }

        $title = "Connexion";
        $this->render('connexion/v-login', [
            'title' => $title,
            'error' => $error ?? null
        ]);
    }

    /**
     * Déconnecte l'utilisateur et détruit sa session
     * @return void Redirige vers l'accueil avec message de confirmation
     */
    public function deconnexion(): void
    {
        $userId = $_SESSION['user']['ID_PERSONNEL'] ?? 'inconnu';
        $this->logEvent(
            'DECONNEXION',
            "Déconnexion utilisateur id={$userId}"
        );
        session_destroy();
        $this->redirectWithMessage('home', 'Vous avez été déconnecté avec succès.', 'success');
    }
}
