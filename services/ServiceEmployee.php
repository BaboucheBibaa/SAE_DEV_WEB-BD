<?php

class ServiceEmployee
{
    private $User;
    private $ContratTravail;
    private $Fonction;
    private $Utils;
    public function __construct()
    {
        $this->User = new User();
        $this->ContratTravail = new ContratTravail();
        $this->Fonction = new Fonction();
        $this->Utils = new Utils();
    }
    //Getters
    public function getTousEmployees($filtreArchive = 'tous')
    {
        //Récupère les employés selon le filtre d'archivage
        switch ($filtreArchive) {
            case 'archives':
                return $this->User->toutRecupParArchive(0);
            case 'actifs':
                return $this->User->toutRecupParArchive(1);
            default:
                return $this->User->toutRecupParArchive(null);
        }
    }
    public function getLastInsertId()
    
    {
        //Récupère l'id du dernier employé ajouté à la base de données
        return $this->User->getLastInsertId()['LAST_ID'];
    }

    public function getSoigneursParSuperieur($id){
        return $this->User->recupSoigneursParSuperieur($id);

    }

    public function getEmployeeParFonction($id_fonction){
        return $this->User->recupParFonction($id_fonction);
    }
    public function getContratsParID($id)
    {
        if (!$id) {
            return null;
        }
        //Récupère les contrats de travail d'un employé en fonction de son id
        return $this->ContratTravail->recupParPersonnel($id);
    }
    public function getEmployeeParID($id)
    {
        if (!$id) {
            return null;
        }
        //Récupère un employé de la base de données en fonction de l'id passé en paramètre
        return $this->User->recupParID($id);
    }
    public function getEmployeeParLogs($login)
    {
        if (!$login) {
            return null;
        }
        //Récupère un employé de la base de données en fonction du login passé en paramètre
        return $this->User->recupParLogs($login);
    }

    public function getFinsDeContrats()
    {
        // Récupère les contrats de travail qui se terminent dans les 30 prochains jours
        return $this->ContratTravail->finDeContrats();
    }

    //Ajout/MAJ/Suppression d'un employé + vérification dans l'ajout/modification d'un employé avec regex

    public function verificationForm($champ)
    {
        //ne doit pas retourner 1 car on peut confondre avec le retour du boolean de la fonction de création ou de modification d'un employé, c'est pour ça que les codes d'erreur commencent à 2
        if (!preg_match('/^[a-zA-Z-\'éèêëç ]+$/', $_POST['nom_' . $champ] ?? '')) {
            return 2; // valeur de retour 2 = erreur du nom
        }
        if (!preg_match('/^[a-zA-Z-\'éèêëç ]+$/', $_POST['prenom_' . $champ] ?? '')) {
            return 3; // valeur de retour 3 = erreur du prénom
        }
        if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $_POST['mail_' . $champ] ?? '')) {
            return 4; // valeur de retour 4 = erreur du mail
        }
        if (!preg_match('/^\d+(?:[\.,]\d{2})?$/', $_POST['salaire_' . $champ] ?? '')) {
            return 5; // valeur de retour 5 = erreur du salaire
        }
        if (!preg_match('/^[a-zA-Z0-9._-]+$/', $_POST['login_' . $champ] ?? '')) {
            return 6; // valeur de retour 6 = erreur du login
        }
        return 0;
    }
    public function supprEmployee($id)
    {
        if (!$id) {
            return null;
        }
        //Supprime un employé de la base de données en fonction de l'id passé en paramètre
        return $this->User->suppr($id);
    }
    public function ajoutEmployee()
    {
        //Ajoute un nouvel employé à la base de données en récupérant les données du formulaire de création d'employé + création de son contrat de travail

        // Vérifier que la fonction est bien définie, sinon utiliser une fonction par défaut (ne devrait jamais arriver avec required)
        $id_fonction = $_POST['id_fonction_cree'] ?? null;
        if (empty($id_fonction)) {
            $fonctions = $this->Fonction->recupToutesLesFonctions();
            $id_fonction = !empty($fonctions) ? $fonctions[0]['ID_FONCTION'] : null;
        }

        $validationCode = $this->verificationForm('cree');
        if ($validationCode != 0) {
            return $validationCode; // Retourne le code d'erreur correspondant à la première validation qui a échoué
        }

        $data = [
            'nom' => $_POST['nom_cree'] ?? null,
            'prenom' => $_POST['prenom_cree'] ?? null,
            'mail' => $_POST['mail_cree'] ?? null,
            'MDP' => $this->Utils->hashPassword($_POST['MDP_cree']),
            'date_entree' => $_POST['date_entree_cree'] ?? null,
            'salaire' => $_POST['salaire_cree'] ?? null,
            'id_fonction' => $id_fonction,
            'login' => $_POST['login_cree'] ?? null,
            'id_remplacant' => !empty($_POST['id_remplacant_cree']) ? $_POST['id_remplacant_cree'] : null,
            'id_superieur' => !empty($_POST['id_superieur_cree']) ? $_POST['id_superieur_cree'] : null
        ];


        //Création + récupération de son ID pour pouvoir créer son contrat de travail
        $newEmployeeId = $this->User->creerEtRetournerId($data);
        if (!$newEmployeeId) {
            return 0;
        }

        //Date de début de contrat dans le formulaire de création de contrat, sinon date du jour ou date d'entrée de l'employé dans le formulaire
        $dateDebutContrat = $_POST['date_debut_contrat_cree'] ?? null;
        if (empty($dateDebutContrat)) {
            $dateDebutContrat = $_POST['date_entree_cree'] ?? date('Y-m-d');
        }

        //création du contrat de travail de l'employé
        $contratData = [
            'ID_PERSONNEL' => $newEmployeeId,
            'ID_FONCTION' => $id_fonction,
            'DATE_DEBUT' => $dateDebutContrat,
            'DATE_FIN' => $_POST['date_fin_contrat_cree'] ?? null
        ];

        return $this->ContratTravail->creer($contratData);
    }
    public function majEmployee($id)
    {
        //Met à jour les données d'un employé dans la base de données en fonction de l'id passé en paramètre

        // récup les données de l'employé via son ID
        $employee = $this->User->recupParID($id);

        //on modifie le champ id_fonction_modif pour qu'il contienne l'id de la fonction correspondant au nom de la fonction sélectionnée dans le form
        $nom_fonction = $_POST['role_modif'] ?? null;
        $id_fonction_final = $employee['ID_FONCTION']; // Par défaut, garder la fonction actuelle

        // Si un nom de fonction est fourni, récupérer son ID
        if (!empty($nom_fonction)) {
            $id_fonction = $this->Fonction->recupIDFonctionParNom($nom_fonction);
            $id_fonction_final = $id_fonction['ID_FONCTION'];
        }

        // Si le champ mot de passe n'est pas vide on prend le nouveau mot de passe hashé sinon on garde l'ancien mot de passe
        $password = !empty($_POST['MDP_modif']) ? $this->Utils->hashPassword($_POST['MDP_modif']) : $employee['MDP'];

        // Si aucun remplaçant n'est spécifié, l'employé est son propre remplaçant
        $id_remplacant = !empty($_POST['id_remplacant_modif']) ? $_POST['id_remplacant_modif'] : $id;

        $validationCode = $this->verificationForm('modif');
        if ($validationCode != 0) {
            return $validationCode; // Retourne le code d'erreur correspondant à la première validation qui a échoué
        }
        $data = [
            'nom' => $_POST['nom_modif'] ?? null,
            'prenom' => $_POST['prenom_modif'] ?? null,
            'mail' => $_POST['mail_modif'] ?? null,
            'MDP' => $password,
            'date_entree' => $_POST['date_entree_modif'] ?? null,
            'salaire' => $_POST['salaire_modif'] ?? null,
            'id_fonction' => $id_fonction_final,
            'login' => $_POST['login_modif'] ?? null,
            'id_remplacant' => $id_remplacant,
            'id_superieur' => !empty($_POST['id_superieur_modif']) ? $_POST['id_superieur_modif'] : null
        ];

        return $this->User->maj($id, $data);
    }

    public function majPassword($id,$MDP)
    {
        if (!$id || !$MDP) {
            return null;
        }
        //Met à jour le mot de passe d'un employé dans la base de données en fonction de l'id passé en paramètre
        return $this->User->majPassword($id, $MDP);
    }

    public function majArchiveEmployee($id, $estArchive)
    {
        if (!$id || !isset($estArchive)) {
            return null;
        }
        //Met à jour le statut d'archivage d'un employé
        return $this->User->majArchive($id, $estArchive);
    }

    //Fonctions retournant des données nécessaires pour des affichages de formulaires
    public function dataEditionEmployee($id)
    {
        //Retourne les données nécessaires à l'affichage du formulaire d'édition d'un employé en fonction de l'id passé en paramètre
        if (!$id) {
            return null;
        }
        $liste_roles = $this->Fonction->recupToutesLesFonctions();
        $liste_employes = $this->User->toutRecup();
        $employee = $this->User->recupParID($id);

        if (!$employee) {
            return null; // Employé non trouvé
        }
        //Récupération pour affichage par défaut du rôle actuel de l'employé
        $job = $this->Fonction->recupNomFonctionParID($employee['ID_FONCTION']);

        $title = "Modifier un Employé";

        return [
            'title' => $title,
            'employee' => $employee,
            'liste_roles' => $liste_roles,
            'liste_employes' => $liste_employes,
            'job' => $job
        ];
    }
    public function dataCreationEmployee()
    {
        //Retourne les données nécessaires à l'affichage du formulaire de création d'un employé
        $liste_fonctions = $this->Fonction->recupToutesLesFonctions();
        $liste_employes = $this->User->toutRecup();
        $generatedPassword = $this->Utils->generatePassword(10);
        if (!$liste_fonctions || !$liste_employes) {
            return null; // Erreur lors de la récupération des données nécessaires à la création d'un employé
        }
        $title = 'Création d\'un employé';

        return [
            'title' => $title,
            'liste_fonctions' => $liste_fonctions,
            'liste_employes' => $liste_employes,
            'generatedPassword' => $generatedPassword
        ];
    }
}
