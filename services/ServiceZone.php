<?php

class ServiceZone {


    public function recupToutesLesZones()
    {
        //Récupère toutes les zones de la base de données
        return Zone::toutRecup();
    }

    public function dataEditionZone($id)
    {
        //Retourne les données nécessaires à la création du formulaire d'édition de la zone avec l'id $id
        if (!$id) {
            return null; //id inexistant
        }

        $zone = Zone::recupParID($id);
        if (!$zone) {
            return null; // Zone non trouvée
        }

        $employees = User::toutRecup();
        $title = "Modifier une Zone";
        return [
            'title' => $title,
            'zone' => $zone,
            'employees' => $employees
        ];
    }

    public function majZone($id)
    {
        //Met à jour les données d'une zone
        $data = [
            'nom_zone' => $_POST['nom_zone_modif'] ?? null,
            'id_manager' => !empty($_POST['id_manager_modif']) ? $_POST['id_manager_modif'] : null
        ];

        return Zone::maj($id, $data);
    }

    public function supprZone($id)
    {
        //Supprime une zone de la base de données
        return Zone::suppr($id);
    }

    public function dataCreationZone()
    {
        //Retourne les données pour la création d'un formulaire de création de zone
        $employees = User::toutRecup();
        if (!$employees) {
            return null; // Pas d'employés disponibles pour être manager
        }
        $title = "Ajouter une Zone";
        return [
            'title' => $title,
            'employees' => $employees
        ];
    }

    public function ajoutZone()
    {
        //Ajoute une nouvelle zone à la base de données
        $data = [
            'nom_zone' => $_POST['nom_zone_cree'] ?? null,
            'id_manager' => !empty($_POST['id_manager_cree']) ? $_POST['id_manager_cree'] : null
        ];

        return Zone::creer($data);
    }
    
    
}