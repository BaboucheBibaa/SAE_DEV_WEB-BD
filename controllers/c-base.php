<?php
class BaseController
{
    protected function logEvent(string $type, string $message, string $filename = 'logs.txt'): void
    {
        try {
            $logger = new LogWriter();
            $logger->writeLog($type, $message, $filename);
        } catch (Exception $e) {
            // Ne pas casser le flux applicatif si l'écriture de log échoue.
        }
    }

    protected function render(string $viewPath, array $data = [], string $title = "Zoo'land"): void
    {
        // Extrait les données afin de les rendre visible dans la vue, voir les controlleurs pour en savoir plus
        extract($data);
        $title = $data['title'] ?? $title;
        $view = "views/{$viewPath}.php";
        require_once 'views/v-includes.php';
    }

    protected function redirect(string $action, ?int $id = null): void
    {
        $url = "index.php?action={$action}";
        if ($id !== null) {
            $url .= "&id={$id}";
        }
        header("Location: {$url}");
        exit;
    }

    protected function redirectWithMessage(string $action, string $message, string $type = 'success'): void
    {
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
        $this->redirect($action);
    }

    protected function requireRole(int $role): void
    {
        if (empty($_SESSION['user'])) {
            $this->redirectWithMessage('afficheConnexion', 'Vous devez être connecté.', 'error');
        }
        if ($_SESSION['user']['ID_FONCTION'] != $role && $_SESSION['user']['ID_FONCTION'] != ADMINID) {
            $this->redirectWithMessage('home', 'Accès refusé.', 'error');
        }
    }
}