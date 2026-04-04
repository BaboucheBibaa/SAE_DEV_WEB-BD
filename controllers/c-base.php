<?php
class BaseController
{
    protected function logEvent(string $type, string $message, string $filename = 'logs.txt'): void
    {
        try {
            $logger = new LogWriter();
            $logger->writeLog($type, $message, $filename);
        } catch (Exception $e) {
            // Si log échoue, pas d'erreur visuelle affichée pour l'utilisateur
        }
    }

    protected function render(string $viewPath, array $data = [], string $title = "Zoo'land"): void
    {
        // Extrait les données afin de les rendre visible dans la vue, voir les controlleurs pour en savoir plus
        extract($data);
        $title = $data['title'] ?? $title;
        $view = "views/{$viewPath}.php";
        //variable $view utilisée dans v-includes
        require_once 'views/v-includes.php';
    }

    protected function redirect(string $action, ?int $id = null, array $params = []): void
    {
        $url = "index.php?action={$action}";
        //concaténation de l'id afin d'avoir un url index.php?action=action&id=id
        if ($id !== null) {
            $url .= "&id={$id}";
        }
        
        // tableau associatif contenant les paramètres supplémentaires (longitude latitude par exemple)
        foreach ($params as $key => $value) {
            $url .= "&" . urlencode($key) . "=" . urlencode($value);
        }
        
        header("Location: {$url}");
        exit;
    }

    protected function redirectWithMessage(string $action, string $message, string $type = 'success', array $params = []): void
    {
        //redirection avec un message de succès/warning/danger
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
        $this->redirect($action, null, $params);
    }

    protected function requireRole(int $role): void
    {
        //fonction vérifiant le rôle de la personne connectée.
        if (empty($_SESSION['user'])) {
            $this->redirectWithMessage('afficheConnexion', 'Vous devez être connecté.', 'error');
        }
        if ($_SESSION['user']['ID_FONCTION'] != $role && $_SESSION['user']['ID_FONCTION'] != ADMINID) {
            $this->redirectWithMessage('home', 'Accès refusé.', 'error');
        }
    }
}