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
        if (isset($_SESSION["nom_cree"])) {
            echo "prout";
        }
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

    public function remove_employee($id){
        $db = Database::getConnection();
        $stmt = $db->prepare(
            "DELETE FROM Personnel WHERE ID_Personnel = :id"
        );
        $stmt->execute([
            'id' => $id
        ]);
    }
    public function add_employee(){
        $db = Database::getConnection();
        
        // Option 1: Si ID_Personnel est AUTO_INCREMENT (ne pas l'inclure)
        $stmt = $db->prepare(
            "INSERT INTO Personnel (Nom, Prenom, mail, MDP, Date_Entree, Salaire, ID_Role, login) VALUES (:nom, :prenom, :mail, :MDP, :date_entree, :salaire, :id_role, :login)"
        );
        
        $stmt->execute([
            'nom' => $_POST['nom_cree'] ?? null,
            'prenom' => $_POST['prenom_cree'] ?? null,
            'mail' => $_POST['mail_cree'] ?? null,
            'MDP' => password_hash($_POST['MDP_cree'], PASSWORD_DEFAULT), // Hash du mot de passe
            'date_entree' => $_POST['date_entree_cree'] ?? null,
            'salaire' => $_POST['salaire_cree'] ?? null,
            'id_role' => $_POST['id_role_cree'], // Valeur par défaut si non fourni
            'login' => $_POST['login_cree'] ?? null
        ]);
        
    }
    public function edit_employee($id){
        // Cette fonction n'est pas encore implémentée, mais elle pourrait être utilisée pour afficher un formulaire de modification d'employé
    }
    public function create_employee(){
        $title = "Ajouter un Employé";
        $generatedPassword = $this->generatePassword();
        $view = 'views/administrateur/create_employee.php';
        require_once 'views/includes.php';
    }

    public function generatePassword(){
        $password = '';
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 10; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}