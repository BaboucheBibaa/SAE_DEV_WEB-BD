<?php

class ServiceBoutique
{
    private $Boutique;
    private $Zone;
    private $User;

    public function __construct()
    {
        $this->Boutique = new Boutique();
        $this->Zone = new Zone();
        $this->User = new User();
    }

    // ============ GETTERS ============

    /**
     * Récupère le chiffre d'affaires d'une boutique
     * @param int $id_boutique ID de la boutique
     * @return array|null Données CA ou null
     */
    public function getCA($id_boutique)
    {
        return $this->Boutique->getAllCA($id_boutique);
    }

    /**
     * Récupère une boutique par son ID
     * @param int $id ID de la boutique
     * @return array|null Données boutique ou null si non trouvée
     */
    public function getBoutiqueParID($id)
    {
        return $this->Boutique->getParID($id);
    }

    /**
     * Récupère une boutique par son manager
     * @param int $id_manager ID du manager
     * @return array|null Données boutique ou null
     */
    public function getBoutiqueParManager($id_manager)
    {
        return $this->Boutique->getParManager($id_manager);
    }

    /**
     * Récupère le manager d'une boutique
     * @param int $id_boutique ID de la boutique
     * @return array|null Données manager ou null
     */
    public function getManagerParBoutique($id_boutique)
    {
        return $this->Boutique->getNomManager($id_boutique);
    }

    /**
     * Récupère les employés d'une boutique
     * @param int $id_boutique ID de la boutique
     * @return array Tableau des employés
     */
    public function getEmployeesParBoutique($id_boutique)
    {
        return $this->Boutique->getEmployees($id_boutique);
    }

    /**
     * Récupère toutes les boutiques
     * @return array Tableau de toutes les boutiques
     */
    public function getToutesLesBoutiques()
    {
        return $this->Boutique->getAll();
    }

    // ============ AJOUT / SUPPRESSION / MODIFICATION ============

    /**
     * Ajoute une nouvelle boutique à la base de données
     * @return bool|null Résultat de la création
     */
    public function ajoutBoutique()
    {
        $id_manager = $_POST['id_manager_cree'];
        $id_zone = $_POST['id_zone_cree'];
        $nom_boutique = $_POST['nom_boutique_cree'];
        $description_boutique = $_POST['description_boutique_cree'];

        return $this->Boutique->creer([
            'id_manager' => $id_manager,
            'id_zone' => $id_zone,
            'nom_boutique' => $nom_boutique,
            'description_boutique' => $description_boutique
        ]);
    }

    /**
     * Met à jour une boutique
     * @param int $id ID de la boutique à modifier
     * @return bool|null Résultat de la modification
     */
    public function majBoutique($id)
    {
        $id_manager = $_POST['id_manager_modif'];
        $id_zone = $_POST['id_zone_modif'];
        $nom_boutique = $_POST['nom_boutique_modif'];
        $description_boutique = $_POST['description_boutique_modif'];

        return $this->Boutique->maj($id, [
            'id_manager' => $id_manager,
            'id_zone' => $id_zone,
            'nom_boutique' => $nom_boutique,
            'description_boutique' => $description_boutique
        ]);
    }

    /**
     * Supprime une boutique
     * @param int $id ID de la boutique à supprimer
     * @return bool|null True si succès, false/null si erreur
     */
    public function supprBoutique($id)
    {
        if (!$id) {
            return null;  // ID invalide
        }
        return $this->Boutique->suppr($id);
    }

    // ============ DONNÉES POUR FORMULAIRES ============

    /**
     * Récupère les données pour le formulaire de création de boutique
     * @return array|null Array avec 'zones', 'employees', 'title' ou null si erreur
     */
    public function dataCreationBoutique()
    {
        $zones = $this->Zone->getAll();
        $employees = $this->User->getAll();
        if (!$zones || !$employees) {
            return null; // Erreur lors de la récupération des données nécessaires
        }
        $title = "Créer une Boutique";
        return [
            'zones' => $zones,
            'employees' => $employees,
            'title' => $title
        ];
    }

    /**
     * Récupère les données pour le formulaire d'édition de boutique
     * @param int $id ID de la boutique à éditer
     * @return array|null Array avec 'boutique', 'zones', 'employees', 'title' ou null si erreur
     */
    public function dataEditionBoutique($id)
    {
        if (!$id) {
            return null;
        }

        $boutique = $this->Boutique->getParID($id);
        $zones = $this->Zone->getAll();
        $employees = $this->User->getAll();
        if (!$zones || !$boutique || !$employees) {
            return null;
        }

        $title = "Modifier une Boutique";
        return [
            'title' => $title,
            'boutique' => $boutique,
            'zones' => $zones,
            'employees' => $employees
        ];
    }
}
