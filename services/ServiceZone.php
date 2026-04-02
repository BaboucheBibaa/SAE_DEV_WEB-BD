<?php

class ServiceZone
{
    private $Zone;
    private $User;
    public function __construct()
    {
        $this->Zone = new Zone();
        $this->User = new User();
    }

    /**
     * Récupère toutes les zones
     * @return array|null Tableau de toutes les zones ou null
     */
    public function getAll()
    {
        //Récupère toutes les zones de la base de données
        return $this->Zone->getAll();
    }
    /**
     * Récupère une zone par son ID
     * @param int $id_zone ID de la zone
     * @return array|null Données de la zone ou null
     */
    public function getZoneParID($id_zone)
    {
        //Récupère une zone spécifique à partir de son ID
        return $this->Zone->getParID($id_zone);
    }

    /**
     * Récupère la zone d'un enclos par ses coordonnées GPS
     * @param float $latitude Latitude de l'enclos
     * @param float $longitude Longitude de l'enclos
     * @return array|null Données de la zone ou null
     */
    public function getZoneParEnclos($latitude,$longitude){
        return $this->Zone->getParEnclos($latitude,$longitude);
    }

    /**
     * Récupère le manager d'une zone
     * @param int $id_zone ID de la zone
     * @return array|null Données du manager ou null
     */
    public function getManagerParZone($id_zone)
    {
        //Récupère le manager d'une zone donnée
        return $this->Zone->getNomManager($id_zone);
    }

    /**
     * Récupère la zone gérée par un manager
     * @param int $id_manager ID du manager
     * @return array|null Données de la zone ou null
     */
    public function getZoneDuManager($id_manager)
    {
        //Récupère la zone dont l'utilisateur est le manager
        return $this->Zone->getZoneManager($id_manager);
    }

    //MAJ/Suppression/Création d'une zone
    /**
     * Met à jour les données d'une zone
     * @param int $id ID de la zone à modifier
     * @return bool|null Résultat de la modification
     */
    public function majZone($id)
    {
        //Met à jour les données d'une zone
        $data = [
            'nom_zone' => $_POST['nom_zone_modif'] ?? null,
            'id_manager' => !empty($_POST['id_manager_modif']) ? $_POST['id_manager_modif'] : null
        ];

        return $this->Zone->maj($id, $data);
    }
    /**
     * Supprime une zone de la base de données
     * @param int $id ID de la zone à supprimer
     * @return bool|null Résultat de la suppression
     */
    public function supprZone($id)
    {
        //Supprime une zone de la base de données
        return $this->Zone->suppr($id);
    }
    /**
     * Ajoute une nouvelle zone à la base de données
     * @return bool|null Résultat de la création
     */
    public function ajoutZone()
    {
        //Ajoute une nouvelle zone à la base de données
        $data = [
            'nom_zone' => $_POST['nom_zone_cree'] ?? null,
            'id_manager' => !empty($_POST['id_manager_cree']) ? $_POST['id_manager_cree'] : null
        ];

        return $this->Zone->creer($data);
    }

    //Fonctions permettant l'affichage de formulaires d'édition/création de zone
    /**
     * Récupère les données pour le formulaire de création d'une zone
     * @return array|null Tableau contenant title et employees ou null
     */
    public function dataCreationZone()
    {
        //Retourne les données pour la création d'un formulaire de création de zone
        $employees = $this->User->getAll();
        if (!$employees) {
            return null; // Pas d'employés disponibles pour être manager
        }
        $title = "Ajouter une Zone";
        return [
            'title' => $title,
            'employees' => $employees
        ];
    }

    /**
     * Récupère les données pour le formulaire d'édition d'une zone
     * @param int $id ID de la zone à éditer
     * @return array|null Tableau contenant zone, title, employees ou null
     */
    public function dataEditionZone($id)
    {
        //Retourne les données nécessaires à la création du formulaire d'édition de la zone avec l'id $id
        if (!$id) {
            return null; //id inexistant
        }

        $zone = $this->Zone->getParID($id);
        if (!$zone) {
            return null; // Zone non trouvée
        }

        $employees = $this->User->getAll();
        $title = "Modifier une Zone";
        return [
            'title' => $title,
            'zone' => $zone,
            'employees' => $employees
        ];
    }
}
