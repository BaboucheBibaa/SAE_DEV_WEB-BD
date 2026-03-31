<?php
class ServiceAnimal
{
    private $Animal;
    private $Espece;
    private $Zone;
    private $Enclos;
    private $User;
    public function __construct()
    {
        $this->Animal = new Animal();
        $this->Espece = new Espece();
        $this->Zone = new Zone();
        $this->Enclos = new Enclos();
        $this->User = new User();
    }
    //Getters
    public function getTousAnimaux()
    {
        $animaux = $this->Animal->toutRecup();
        if (!$animaux) {
            return null;
        }
        return $animaux;
    }
    public function getAnimalParID($id)
    {
        $animal = $this->Animal->recupParID($id);
        if (!$animal) {
            return null;
        }
        return $animal;
    }
    public function getAnimalParCoordonnees($latitude, $longitude)
    {
        $animal = $this->Animal->recupParCoordonnees($latitude, $longitude);
        if (!$animal) {
            return null;
        }
        return $animal;
    }
    public function getEspeceAnimalParID($id)
    {
        $espece = $this->Espece->recupParID($id);
        if (!$espece) {
            return null;
        }
        return $espece;
    }
    public function getAnimauxParZone($id_zone)
    {
        $animaux = $this->Animal->recupParZone($id_zone);
        if (!$animaux) {
            return null;
        }
        return $animaux;
    }

    //Ajout/MAJ/Suppression d'un animal + validation des données du formulaire

    public function verificationForm($champ)
    {
        //ne doit pas retourner 1 car on peut confondre avec le retour du boolean de la fonction de création ou de modification d'un animal, c'est pour ça que les codes d'erreur commencent à 2
        if (!preg_match('/^[a-zA-Z-\'éèêëç ]+$/', $_POST['nom_animal_' . $champ] ?? '')) {
            return 2; // valeur de retour 2 = erreur du nom
        }
        if (!preg_match('/^\d+(?:[\.,]\d{1,2})?$/', $_POST['poids_' . $champ] ?? '')) {
            return 3; // valeur de retour 3 = erreur du poids
        }
        return 0;
    }

    public function ajoutAnimal()
    {
        $validationCode = $this->verificationForm('cree');

        if ($validationCode != 0) {
            return $validationCode; // Retourne le code d'erreur correspondant à la première validation qui a échoué
        }
        //Ajoute un nouvel animal à la base de données
        $data = [
            'nom_animal' => $_POST['nom_animal_cree'] ?? null,
            'date_naissance' => $_POST['date_naissance_cree'] ?? null,
            'poids' => $_POST['poids_cree'] ?? null,
            'id_soigneur' => $_POST['id_soigneur'] ?? null,
            'regime_alimentaire' => $_POST['regime_alimentaire_cree'] ?? null,
            'id_espece' => $_POST['id_espece_cree'] ?? null,
            'latitude_enclos' => $_POST['latitude_enclos_cree'] ?? null,
            'longitude_enclos' => $_POST['longitude_enclos_cree'] ?? null
        ];

        return $this->Animal->creer($data);
    }
    public function majAnimal($id)
    {
        $validationCode = $this->verificationForm('modif');
        if ($validationCode != 0) {
            return $validationCode; // Retourne le code d'erreur correspondant à la première validation qui a échoué
        };

        $poids = str_replace('.', ',', $_POST['poids_modif']);
        //Met à jour les données d'un animal
        $data = [
            'nom_animal' => $_POST['nom_animal_modif'] ?? null,
            'date_naissance' => $_POST['date_naissance_modif'] ?? null,
            'poids' => $_POST['poids_modif'] ?? null,
            'regime_alimentaire' => $_POST['regime_alimentaire_modif'] ?? null,
            'id_soigneur' => $_POST['id_soigneur'] ?? null,
            'id_espece' => $_POST['id_espece_modif'] ?? null,
            'latitude_enclos' => $_POST['latitude_enclos_modif'] ?? null,
            'longitude_enclos' => $_POST['longitude_enclos_modif'] ?? null
        ];
        return $this->Animal->maj($id, $data);
    }
    public function supprAnimal($id)
    {
        //Supprime un animal de la base de données
        return $this->Animal->suppr($id);
    }



    //Retourne les données nécessaires à des affichages de formulaires
    public function dataEditionAnimal($id)
    {
        //Retourne les données nécessaires à l'affichage du formulaire d'édition d'un animal en fonction de l'id passé en paramètre
        if (!$id) {
            return null; //id inexistant
        }

        //données de l'animal
        $animal = $this->Animal->recupParID($id);
        if (!$animal) {
            return null; // Animal non trouvé
        }

        //données quant à tout ce qui concerne les espèces / zones / soigneurs
        $especes = $this->Espece->toutRecup();
        $zones = $this->Zone->toutRecup();
        $soigneurs = $this->User->recupParFonction(SOIGNEUR);

        if (!empty($animal['LATITUDE_ENCLOS']) && !empty($animal['LONGITUDE_ENCLOS'])) {
            $id_zone_selected = $this->Zone->recupZoneParEnclos($animal['LATITUDE_ENCLOS'], $animal['LONGITUDE_ENCLOS']);
        }

        $soigneur_attire = $this->User->recupParID($animal['ID_SOIGNEUR']);
        $especeAnimal = $this->Espece->recupParID($animal['ID_ESPECE']);
        // Charger les enclos de la zone sélectionnée
        $enclos = [];
        if (!empty($id_zone_selected)) {
            $enclos = $this->Enclos->recupEnclosZone($id_zone_selected);
        }

        $animal['POIDS'] = str_replace(',', '.', $animal['POIDS']);
        $title = "Modifier un Animal";
        return [
            'animal' => $animal,
            'especes' => $especes,
            'zones' => $zones,
            'enclos' => $enclos,
            'id_zone_selected' => $id_zone_selected,
            'title' => $title,
            'soigneurs' => $soigneurs,
            'soigneur_attitre' => $soigneur_attire,
            'especeAnimal' => $especeAnimal
        ];
    }
    public function dataCreationAnimal()
    {
        //Retourne les données nécessaires à l'affichage du formulaire de création d'un nouvel animal
        $especes = $this->Espece->toutRecup();
        $zones = $this->Zone->toutRecup();
        $soigneurs = $this->User->recupParFonction(SOIGNEUR);

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
            'id_soigneur' => $_POST['id_soigneur'] ?? '',
            'id_zone' => $_POST['id_zone_cree'] ?? '',
            'latitude_enclos' => $_POST['latitude_enclos_cree'] ?? '',
            'longitude_enclos' => $_POST['longitude_enclos_cree'] ?? ''
        ];

        // Charger les enclos si une zone est sélectionnée
        $enclos = [];
        if (!empty($formData['id_zone'])) {
            $enclos = $this->Enclos->recupEnclosZone($formData['id_zone']);
        }

        $title = "Créer un Animal";
        return [
            'especes' => $especes,
            'zones' => $zones,
            'formData' => $formData,
            'enclos' => $enclos,
            'title' => $title,
            'soigneurs' => $soigneurs
        ];
    }
}
