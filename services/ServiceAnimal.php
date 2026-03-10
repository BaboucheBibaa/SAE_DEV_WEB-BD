<?php
class ServiceAnimal
{
    public function dataEditionAnimal($id)
    {
        //Retourne les données nécessaires à l'affichage du formulaire d'édition d'un animal en fonction de l'id passé en paramètre
        if (!$id) {
            return null; //id inexistant
        }

        $animal = Animal::recupParID($id);
        if (!$animal) {
            return null; // Animal non trouvé
        }

        $especes = Espece::toutRecup();
        $zones = Zone::toutRecup();

        // Récupérer la zone sélectionnée (soit depuis le formulaire, soit depuis l'animal)
        $id_zone_selected = $_POST['id_zone_modif'] ?? $_GET['id_zone_modif'] ?? null;

        // Si pas de zone sélectionnée, trouver la zone de l'enclos actuel
        if (empty($id_zone_selected) && !empty($animal['LATITUDE_ENCLOS']) && !empty($animal['LONGITUDE_ENCLOS'])) {
            foreach ($zones as $zone) {
                $enclos_zone = Enclos::recupEnclosZone($zone['ID_ZONE']);
                foreach ($enclos_zone as $enc) {
                    if ($enc['LATITUDE'] == $animal['LATITUDE_ENCLOS'] && $enc['LONGITUDE'] == $animal['LONGITUDE_ENCLOS']) {
                        $id_zone_selected = $zone['ID_ZONE'];
                        break 2; // Sortir des deux boucles une fois la zone trouvée
                    }
                }
            }
        }

        // Charger les enclos de la zone sélectionnée
        $enclos = [];
        if (!empty($id_zone_selected)) {
            $enclos = Enclos::recupEnclosZone($id_zone_selected);
        }

        $title = "Modifier un Animal";
        return [
            'animal' => $animal,
            'especes' => $especes,
            'zones' => $zones,
            'enclos' => $enclos,
            'id_zone_selected' => $id_zone_selected,
            'title' => $title
        ];
    }
    public function ajoutAnimal()
    {
        //Ajoute un nouvel animal à la base de données
        $data = [
            'nom_animal' => $_POST['nom_animal_cree'] ?? null,
            'date_naissance' => $_POST['date_naissance_cree'] ?? null,
            'poids' => $_POST['poids_cree'] ?? null,
            'regime_alimentaire' => $_POST['regime_alimentaire_cree'] ?? null,
            'id_espece' => $_POST['id_espece_cree'] ?? null,
            'latitude_enclos' => $_POST['latitude_enclos_cree'] ?? null,
            'longitude_enclos' => $_POST['longitude_enclos_cree'] ?? null
        ];

        return Animal::creer($data);
    }

    public function majAnimal($id)
    {
        //Met à jour les données d'un animal
        $data = [
            'nom_animal' => $_POST['nom_animal_modif'] ?? null,
            'date_naissance' => $_POST['date_naissance_modif'] ?? null,
            'poids' => $_POST['poids_modif'] ?? null,
            'regime_alimentaire' => $_POST['regime_alimentaire_modif'] ?? null,
            'id_espece' => $_POST['id_espece_modif'] ?? null,
            'latitude_enclos' => $_POST['latitude_enclos_modif'] ?? null,
            'longitude_enclos' => $_POST['longitude_enclos_modif'] ?? null
        ];

        return Animal::maj($id, $data);
    }

    public function supprAnimal($id)
    {
        //Supprime un animal de la base de données
        return Animal::suppr($id);
    }

    public function dataCreationAnimal()
    {
        //Retourne les données nécessaires à l'affichage du formulaire de création d'un nouvel animal
        $especes = Espece::toutRecup();
        $zones = Zone::toutRecup();

        if (empty($especes) || empty($zones)) {
            return null; // Impossible de créer un animal sans espèces ou zones
        }
        // Récupérer les données du formulaire pour pré-remplissage
        $formData = [
            'nom_animal' => $_POST['nom_animal_cree'] ?? '',
            'id_espece' => $_POST['id_espece_cree'] ?? '',
            'date_naissance' => $_POST['date_naissance_cree'] ?? '',
            'poids' => $_POST['poids_cree'] ?? '',
            'regime_alimentaire' => $_POST['regime_alimentaire_cree'] ?? '',
            'id_zone' => $_POST['id_zone_cree'] ?? '',
            'latitude_enclos' => $_POST['latitude_enclos_cree'] ?? '',
            'longitude_enclos' => $_POST['longitude_enclos_cree'] ?? ''
        ];

        // Charger les enclos si une zone est sélectionnée
        $enclos = [];
        if (!empty($formData['id_zone'])) {
            $enclos = Enclos::recupEnclosZone($formData['id_zone']);
        }

        $title = "Créer un Animal";
        return [
            'especes' => $especes,
            'zones' => $zones,
            'formData' => $formData,
            'enclos' => $enclos,
            'title' => $title
        ];
    }
}
