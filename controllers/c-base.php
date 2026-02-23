<?php
class BaseController
{
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
}