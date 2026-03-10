<?php

class ServiceBoutique {
    public function dataCreationBoutique()
    {
        //Retourne les données nécessaires à la création du formulaire de création de boutique
        $zones = Zone::toutRecup();
        $employees = User::toutRecup();
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

    public function ajoutBoutique()
    {
        //Ajoute une nouvelle boutique à la base de données
        $data = [
            'id_manager' => !empty($_POST['id_manager_cree']) ? $_POST['id_manager_cree'] : null,
            'id_zone' => $_POST['id_zone_cree'] ?? null,
            'nom_boutique' => $_POST['nom_boutique_cree'] ?? null,
            'description_boutique' => $_POST['description_boutique_cree'] ?? null
        ];

        return Boutique::creer($data);
    }

    public function dataEditionBoutique($id)
    {
        //Retourne les données nécessaires à la création du formulaire d'édition de boutique
        if (!$id) {
            return null; //id inexistant
        }

        $boutique = Boutique::recupParID($id);
        if (!$boutique) {
            return null; // Boutique non trouvée
        }

        $zones = Zone::toutRecup();
        $employees = User::toutRecup();
        $title = "Modifier une Boutique";
        return [
            'title' => $title,
            'boutique' => $boutique,
            'zones' => $zones,
            'employees' => $employees
        ];
    }

    public function majBoutique($id)
    {
        //Met à jour les données d'une boutique
        $data = [
            'id_manager' => !empty($_POST['id_manager_modif']) ? $_POST['id_manager_modif'] : null,
            'id_zone' => $_POST['id_zone_modif'] ?? null,
            'nom_boutique' => $_POST['nom_boutique_modif'] ?? null,
            'description_boutique' => $_POST['description_boutique_modif'] ?? null
        ];

        return Boutique::maj($id, $data);
    }

    public function supprBoutique($id)
    {
        //Supprime une boutique de la base de données
        return Boutique::suppr($id);
    }
}