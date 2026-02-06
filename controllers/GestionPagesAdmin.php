<?php 

class GestionPagesAdmin {

    public function admin_profile() {
        if (empty($_SESSION['user'])) {
            if ($_SESSION['user']['est_admin'] == true) {
                header('Location: index.php?action=profil');
                exit;
            }
        }
        $title = "Profil Administrateur";
        $employees = $this->select_all_employees();

        $view = 'views/administrateur/dashboard.php';

        require_once 'views/includes.php';
    }

    public function select_all_employees(){
        $db = Database::getConnection();

        $stmt = $db->prepare(
            "SELECT * FROM Personnel"
        );
        $stmt->execute([]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

}