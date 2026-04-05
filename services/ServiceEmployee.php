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
    /**
     * Récupère tous les employés avec filtrage optionnel sur le statut d'archivage
     * @param string $filtreArchive 'archives', 'actifs' ou 'tous' par défaut
     * @return array|null Tableau des employés ou null
     */
    public function getTousEmployees($filtreArchive = 'tous')
    {
        //Récupère les employés selon le filtre d'archivage
        switch ($filtreArchive) {
            case 'archives':
                return $this->User->getAll(0);
            case 'actifs':
                return $this->User->getAll(1);
            default:
                return $this->User->getAll(null);
        }
    }


    public function getFonctions(){
        return $this->Fonction->getAll();
    }
    /**
     * Récupère l'ID du dernier employé ajouté à la base de données
     * @return int|null ID du dernier employé ou null
     */
    public function getLastInsertId()
    
    {
        //Récupère l'id du dernier employé ajouté à la base de données
        return $this->User->getLastInsertId()['LAST_ID']+1;
    }

    /**
     * Récupère les soigneurs supervisés par un responsable
     * @param int $id ID du responsable (soigneur supérieur)
     * @return array|null Tableau des soigneurs ou null
     */
    public function getSoigneursParSuperieur($id){
        return $this->User->getSoigneursParSuperieur($id);

    }

    /**
     * Récupère les employés ayant une fonction spécifique
     * @param int $id_fonction ID de la fonction
     * @return array|null Tableau des employés avec cette fonction ou null
     */
    public function getEmployeeParFonction($id_fonction){
        return $this->User->getParFonction($id_fonction);
    }
    /**
     * Récupère les contrats de travail d'un employé
     * @param int $id ID de l'employé
     * @return array|null Tableau des contrats ou null
     */
    public function getContratsParID($id)
    {
        if (!$id) {
            return null;
        }
        //Récupère les contrats de travail d'un employé en fonction de son id
        return $this->ContratTravail->getParPersonnel($id);
    }

    /**
     * Retourne tous les contrats de travail du zoo
     * @return array|null Tableau des contrats ou null
     */
    public function getAllContrats(){
        return $this->ContratTravail->getAll();
    }
    /**
     * Récupère un employé par son ID
     * @param int $id ID de l'employé
     * @return array|null Données de l'employé ou null
     */
    public function getEmployeeParID($id)
    {
        if (!$id) {
            return null;
        }
        //Récupère un employé de la base de données en fonction de l'id passé en paramètre
        return $this->User->getParID($id);
    }
    /**
     * Récupère un employé par son login (identifiant de connexion)
     * @param string $login Login de l'employé
     * @return array|null Données de l'employé ou null
     */
    public function getEmployeeParLogs($login)
    {
        if (!$login) {
            return null;
        }
        //Récupère un employé de la base de données en fonction du login passé en paramètre
        return $this->User->getParLogs($login);
    }
    
    //Ajout/MAJ/Suppression d'un employé + vérification dans l'ajout/modification d'un employé avec regex

    /**
     * Vérifie les données du formulaire d'ajout/modification d'employé
     * @param string $champ Suffixe du champ POST ('cree' ou 'modif')
     * @return string 'ok' si valide, le reste si erreur (nom, prénom, mail, salaire, login)
     */
    public function verificationForm($champ)
    {
        //ne doit pas retourner 1 car on peut confondre avec le retour du boolean de la fonction de création ou de modification d'un employé, c'est pour ça que les codes d'erreur commencent à 2
        if (!preg_match('/^[a-zA-Z-\'éèêëç ]+$/', $_POST['nom_' . $champ] ?? '')) {
            return 'nom';
        }
        if (!preg_match('/^[a-zA-Z-\'éèêëç ]+$/', $_POST['prenom_' . $champ] ?? '')) {
            return 'prenom';
        }
        if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $_POST['mail_' . $champ] ?? '')) {
            return 'mail';
        }
        if (!preg_match('/^\d+(?:[\.,]\d{2})?$/', $_POST['salaire_' . $champ] ?? '')) {
            return 'salaire';
        }
        if (!preg_match('/^[a-zA-Z0-9._-]+$/', $_POST['login_' . $champ] ?? '')) {
            return 'login';
        }
        return 'ok';
    }
    /**
     * Supprime un employé de la base de données
     * @param int $id ID de l'employé à supprimer
     * @return bool|null Résultat de la suppression
     */
    public function supprEmployee($id)
    {
        if (!$id) {
            return null;
        }
        //Supprime un employé de la base de données en fonction de l'id passé en paramètre
        return $this->User->suppr($id);
    }
    /**
     * Ajoute un nouvel employé et crée son contrat de travail
     * @return int|string ID du nouvel employé
     */
    public function ajoutEmployee()
    {
        // Vérifier que la fonction est bien définie, sinon utiliser une fonction par défaut
        $id_fonction = $_POST['id_fonction_cree'] ?? 'Comptable';

        // Valide les données du formulaire
        $validationCode = $this->verificationForm('cree');
        if ($validationCode != 'ok') {
            // Retourne le code d'erreur au lieu de lancer une exception
            return $validationCode;
        }

        // Prépare les données
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

        // Créer l'employé
        $newEmployeeId = $this->User->creer($data);
        if (!$newEmployeeId) {
            // Retourne 0 en cas d'erreur serveur
            return 0;
        }

        // Prépare les données du contrat
        $dateDebutContrat = $_POST['date_debut_contrat_cree'] ?? null;
        if (empty($dateDebutContrat)) {
            $dateDebutContrat = $_POST['date_entree_cree'] ?? date('Y-m-d');
        }

        $contratData = [
            'ID_PERSONNEL' => $newEmployeeId,
            'ID_FONCTION' => $id_fonction,
            'DATE_DEBUT' => $dateDebutContrat,
            'DATE_FIN' => $_POST['date_fin_contrat_cree'] ?? null
        ];

        // Crée le contrat
        $contratResult = $this->ContratTravail->creer($contratData);
        if (!$contratResult) {
            // Retourne 0 en cas d'erreur serveur
            return 0;
        }

        // Retour du succès : l'ID du nouvel employé
        return $newEmployeeId;
    }
    /**
     * Met à jour les données d'un employé
     * @param int $id ID de l'employé à modifier
     * @return int|string|bool|null Code d'erreur validation ou résultat de modification
     */
    public function majEmployee($id)
    {
        //Met à jour les données d'un employé dans la base de données en fonction de l'id passé en paramètre

        // récup les données de l'employé via son ID
        $employee = $this->User->getParID($id);

        //on modifie le champ id_fonction_modif pour qu'il contienne l'id de la fonction correspondant au nom de la fonction sélectionnée dans le form
        $nom_fonction = $_POST['role_modif'] ?? null;
        $id_fonction_final = $employee['ID_FONCTION']; // Par défaut, garder la fonction actuelle

        // Si un nom de fonction est fourni, récupérer son ID
        if (!empty($nom_fonction)) {
            $id_fonction = $this->Fonction->getIDParNom($nom_fonction);
            $id_fonction_final = $id_fonction['ID_FONCTION'];
        }

        // Si le champ mot de passe n'est pas vide on prend le nouveau mot de passe hashé sinon on garde l'ancien mot de passe
        $password = !empty($_POST['MDP_modif']) ? $this->Utils->hashPassword($_POST['MDP_modif']) : $employee['MDP'];

        // Si aucun remplaçant n'est spécifié, l'employé est son propre remplaçant
        $id_remplacant = !empty($_POST['id_remplacant_modif']) ? $_POST['id_remplacant_modif'] : $id;

        $validationCode = $this->verificationForm('modif');
        if ($validationCode != 'ok') {
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

    /**
     * Met à jour le mot de passe d'un employé
     * @param int $id ID de l'employé
     * @param string $MDP Nouveau mot de passe (sera hashé)
     * @return bool|null Résultat de la mise à jour
     */
    public function majPassword($id,$MDP)
    {
        if (!$id || !$MDP) {
            return null;
        }
        //Met à jour le mot de passe d'un employé dans la base de données en fonction de l'id passé en paramètre
        return $this->User->majPassword($id, $MDP);
    }

    /**
     * Met à jour le statut d'archivage d'un employé
     * @param int $id ID de l'employé
     * @param bool $estArchive True pour archiver, false pour désarchiver
     * @return bool|null Résultat de la mise à jour
     */
    public function majArchiveEmployee($id, $estArchive)
    {
        if (!$id || !isset($estArchive)) {
            return null;
        }
        //Met à jour le statut d'archivage d'un employé
        return $this->User->majArchive($id, $estArchive);
    }

    

    //Fonctions retournant des données nécessaires pour des affichages de formulaires
    /**
     * Récupère les données pour le formulaire d'édition d'un employé
     * @param int $id ID de l'employé à éditer
     * @return array|null Tableau contenant employé, rôles, liste employés ou null
     */
    public function dataEditionEmployee($id)
    {
        //Retourne les données nécessaires à l'affichage du formulaire d'édition d'un employé en fonction de l'id passé en paramètre
        if (!$id) {
            return null;
        }
        $liste_roles = $this->Fonction->getAll();
        $liste_employes = $this->User->getAll();
        $employee = $this->User->getParID($id);

        if (!$employee) {
            return null; // Employé non trouvé
        }
        //Récupération pour affichage par défaut du rôle actuel de l'employé
        $job = $this->Fonction->getNomFonctionParID($employee['ID_FONCTION']);

        $title = "Modifier un Employé";

        return [
            'title' => $title,
            'employee' => $employee,
            'liste_roles' => $liste_roles,
            'liste_employes' => $liste_employes,
            'job' => $job
        ];
    }
    /**
     * Récupère les données pour le formulaire de création d'un employé
     * @return array|null Tableau contenant fonctions, employés, mot de passe généré ou null
     */
    public function dataCreationEmployee()
    {
        //Retourne les données nécessaires à l'affichage du formulaire de création d'un employé
        $liste_fonctions = $this->Fonction->getAll();
        $liste_employes = $this->User->getAll();
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

    /**
     * Supprime un contrat de travail
     * @param int $id_contrat ID du contrat
     * @return bool Résultat de la suppression
     */
    public function supprContrat($id_contrat)
    {
        return $this->ContratTravail->suppr($id_contrat);
    }
}
