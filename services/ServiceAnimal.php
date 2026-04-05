<?php
class ServiceAnimal
{
    private $Animal;
    private $Espece;
    private $Zone;
    private $Enclos;
    private $User;
    private $Compatibilite;
    public function __construct()
    {
        $this->Animal = new Animal();
        $this->Espece = new Espece();
        $this->Zone = new Zone();
        $this->Enclos = new Enclos();
        $this->User = new User();
        $this->Compatibilite = new Compatibilité();
    }
    //Getters
    /**
     * Récupère tous les animaux de la base de données
     * @return array|null Tableau de tous les animaux ou null si erreur
     */
    public function getTousAnimaux()
    {
        $animaux = $this->Animal->getAll();
        if (!$animaux) {
            return null;
        }
        return $animaux;
    }
    /**
     * Récupère un animal par son ID
     * @param int $id ID de l'animal
     * @return array|null Données de l'animal ou null si non trouvé
     */
    public function getAnimalParID($id)
    {
        $animal = $this->Animal->getParID($id);
        if (!$animal) {
            return null;
        }
        return $animal;
    }
    /**
     * Récupère un animal par ses coordonnées GPS
     * @param float $latitude Latitude de l'enclos
     * @param float $longitude Longitude de l'enclos
     * @return array|null Données de l'animal ou null si non trouvé
     */
    public function getAnimalParCoordonnees($latitude, $longitude)
    {
        $animal = $this->Animal->getParCoordonnees($latitude, $longitude);
        if (!$animal) {
            return null;
        }
        return $animal;
    }
    /**
     * Récupère tous les animaux d'une zone
     * @param int $id_zone ID de la zone
     * @return array|null Tableau des animaux de la zone ou null si erreur
     */
    public function getAnimauxParZone($id_zone)
    {
        $animaux = $this->Animal->getAllParZone($id_zone);
        if (!$animaux) {
            return null;
        }
        return $animaux;
    }

    //Ajout/MAJ/Suppression d'un animal + validation des données du formulaire

    /**
     * Valide les données du formulaire d'ajout/modification d'animal
     * @param string $champ Suffixe du champ POST ('cree' ou 'modif')
     * @return string Code d'erreur ('nom', 'poids') ou 'ok' si valide
     */
    public function verificationForm($champ)
    {
        if (!preg_match('/^[a-zA-Z-\'éèêëç ]+$/', $_POST['nom_animal_' . $champ] ?? '')) {
            return 'nom';
        }
        if (!preg_match('/^\d+(?:[\.,]\d{1,2})?$/', $_POST['poids_' . $champ] ?? '')) {
            return 'poids';
        }
        return 'ok';
    }

    /**
     * Vérifie si une espèce est compatible avec tous les animaux présents dans un enclos
     * @param int $id_espece_nouvelle ID de l'espèce à ajouter
     * @param float $latitude Latitude de l'enclos
     * @param float $longitude Longitude de l'enclos
     * @return bool true si compatible avec tous, false sinon
     */
    public function verifierCompatibiliteAvecEnclos($id_espece_nouvelle, $latitude, $longitude)
    {
        // Récupérer tous les animaux présents dans cet enclos
        $animaux_enclos = $this->Animal->getParCoordonnees($latitude, $longitude);
        
        // Si l'enclos est vide, la compatibilité est OK
        if (empty($animaux_enclos)) {
            return true;
        }
        
        // Vérifier la compatibilité avec chaque animal présent
        foreach ($animaux_enclos as $animal_enclos) {
            $id_espece_enclos = $animal_enclos['ID_ESPECE'];
            
            // Vérifier si les deux espèces sont compatibles
            $compatible = $this->Compatibilite->verifierCompatibilite($id_espece_nouvelle, $id_espece_enclos);
            
            // Si une espèce n'est pas compatible, retourner false
            if (!$compatible) {
                return false;
            }
        }
        
        // Tous les animaux présents sont compatibles
        return true;
    }

    /**
     * Ajoute un nouvel animal à la base de données
     * @return bool|string|null Résultat de la création ou code d'erreur
     */
    public function ajoutAnimal()
    {
        $validationCode = $this->verificationForm('cree');
        if ($validationCode != 'ok') {
            return $validationCode; // Retourne le code d'erreur correspondant à la première validation qui a échoué
        }
        
        // Récupérer les coordonnées et l'espèce du nouvel animal
        $latitude = $_POST['latitude_enclos_cree'] ?? null;
        $longitude = $_POST['longitude_enclos_cree'] ?? null;
        $id_espece_nouvelle = $_POST['id_espece_cree'] ?? null;
        
        // Vérifier la compatibilité avec tous les animaux présents dans l'enclos
        if (!$this->verifierCompatibiliteAvecEnclos($id_espece_nouvelle, $latitude, $longitude)) {
            return 'compatibilite';
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
    /**
     * Met à jour les données d'un animal
     * @param int $id ID de l'animal à modifier
     * @return bool|string|null Résultat de la modification ou code d'erreur
     */
    public function majAnimal($id)
    {
        $validationCode = $this->verificationForm('modif');
        if ($validationCode != 'ok') {
            return $validationCode; // Retourne le code d'erreur correspondant à la première validation qui a échoué
        }
        
        // Récupérer l'animal actuellement en base
        $animal_actuel = $this->Animal->getParID($id);
        if (!$animal_actuel) {
            return false;
        }
        
        // Vérifier la compatibilité si l'espèce ou l'enclos change
        $id_espece_nouvelle = $_POST['id_espece_modif'] ?? $animal_actuel['ID_ESPECE'];
        $latitude_nouvelle = $_POST['latitude_enclos_modif'] ?? $animal_actuel['LATITUDE_ENCLOS'];
        $longitude_nouvelle = $_POST['longitude_enclos_modif'] ?? $animal_actuel['LONGITUDE_ENCLOS'];
        
        // Si l'enclos ou l'espèce a changé, vérifier la compatibilité
        if ($id_espece_nouvelle != $animal_actuel['ID_ESPECE'] || 
            $latitude_nouvelle != $animal_actuel['LATITUDE_ENCLOS'] || 
            $longitude_nouvelle != $animal_actuel['LONGITUDE_ENCLOS']) {
            
            // Récupérer les animaux du nouvel enclos
            $animaux_enclos = $this->Animal->getParCoordonnees($latitude_nouvelle, $longitude_nouvelle);
            
            // Vérifier la compatibilité avec les animaux présents dans l'enclos
            if (!empty($animaux_enclos)) {
                foreach ($animaux_enclos as $animal_enclos) {
                    // Ne pas comparer avec soi-même
                    if ($animal_enclos['ID_ANIMAL'] == $id) {
                        continue;
                    }
                    
                    $id_espece_enclos = $animal_enclos['ID_ESPECE'];
                    
                    // Vérifier si les deux espèces sont compatibles
                    $compatible = $this->Compatibilite->verifierCompatibilite($id_espece_nouvelle, $id_espece_enclos);
                    
                    // Si une espèce n'est pas compatible, retourner false
                    if (!$compatible) {
                        return 'compatibilite';
                    }
                }
            }
        }
        
        if (isset($_POST['poids_modif'])) {
            $poids = str_replace('.', ',', $_POST['poids_modif']);
        }
        //Met à jour les données d'un animal
        $data = [
            'nom_animal' => $_POST['nom_animal_modif'] ?? null,
            'date_naissance' => $_POST['date_naissance_modif'] ?? null,
            'poids' => $poids ?? null,
            'regime_alimentaire' => $_POST['regime_alimentaire_modif'] ?? null,
            'id_soigneur' => $_POST['id_soigneur'] ?? null,
            'id_espece' => $_POST['id_espece_modif'] ?? null,
            'latitude_enclos' => $_POST['latitude_enclos_modif'] ?? null,
            'longitude_enclos' => $_POST['longitude_enclos_modif'] ?? null
        ];
        return $this->Animal->maj($id, $data);
    }
    /**
     * Supprime un animal de la base de données
     * @param int $id ID de l'animal à supprimer
     * @return bool|null Résultat de la suppression
     */
    public function supprAnimal($id)
    {
        //Supprime un animal de la base de données
        return $this->Animal->suppr($id);
    }

    //Retourne les données nécessaires à des affichages de formulaires
    /**
     * Récupère les données pour le formulaire d'édition d'un animal
     * @param int $id ID de l'animal à éditer
     * @return array|null Tableau contenannt animal, espèces, zones, enclos, soigneurs ou null si erreur
     */
    public function dataEditionAnimal($id)
    {
        //Retourne les données nécessaires à l'affichage du formulaire d'édition d'un animal en fonction de l'id passé en paramètre
        if (!$id) {
            return null; //id inexistant
        }

        //données de l'animal
        $animal = $this->Animal->getParID($id);
        if (!$animal) {
            return null; // Animal non trouvé
        }

        //données quant à tout ce qui concerne les espèces / zones / soigneurs
        $especes = $this->Espece->getAll();
        $zones = $this->Zone->getAll();
        $soigneurs = $this->User->getParFonction(SOIGNEUR);
        if (!empty($animal['LATITUDE_ENCLOS']) && !empty($animal['LONGITUDE_ENCLOS'])) {
            $id_zone_selected = $this->Zone->getParEnclos($animal['LATITUDE_ENCLOS'], $animal['LONGITUDE_ENCLOS']);
        }

        $soigneur_attire = $this->User->getParID($animal['ID_SOIGNEUR']);
        $especeAnimal = $this->Espece->getParID($animal['ID_ESPECE']);
        // Charger les enclos de la zone sélectionnée
        if (!empty($id_zone_selected)) {
            $enclos = $this->Enclos->getParZone($id_zone_selected['ID_ZONE']);
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
    /**
     * Récupère les données pour le formulaire de création d'un nouvel animal
     * @return array|null Tableau contenant espèces, zones, soigneurs, enclos ou null si erreur
     */
    public function dataCreationAnimal()
    {
        //Retourne les données nécessaires à l'affichage du formulaire de création d'un nouvel animal
        $especes = $this->Espece->getAll();
        $zones = $this->Zone->getAll();
        $soigneurs = $this->User->getParFonction(SOIGNEUR);

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
            $enclos = $this->Enclos->getParZone($formData['id_zone']);
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

    /**
     * Récupère les parents d'un animal
     * @param int $id ID de l'animal
     * @return array|null Tableau des parents ou null si aucun
     */
    public function getParents($id)
    {
        $parents = $this->Animal->getParents($id);
        if (!$parents) {
            return null;
        }
        return $parents;
    }

    /**
     * Récupère les enfants d'un animal
     * @param int $id ID de l'animal
     * @return array|null Tableau des enfants ou null si aucun
     */
    public function getEnfants($id)
    {
        $enfants = $this->Animal->getEnfants($id);
        if (!$enfants) {
            return null;
        }
        return $enfants;
    }

    /**
     * Crée un lien de parenté entre deux animaux
     * @param int $id_parent ID du parent
     * @param int $id_enfant ID de l'enfant
     * @return bool|null Résultat de la création
     */
    public function creerParente($id_parent, $id_enfant)
    {
        return $this->Animal->creerParente($id_parent, $id_enfant);
    }

    /**
     * Supprime un lien de parenté entre deux animaux
     * @param int $id_parent ID du parent
     * @param int $id_enfant ID de l'enfant
     * @return bool|null Résultat de la suppression
     */
    public function supprimerParente($id_parent, $id_enfant)
    {
        return $this->Animal->supprimerParente($id_parent, $id_enfant);
    }
}
