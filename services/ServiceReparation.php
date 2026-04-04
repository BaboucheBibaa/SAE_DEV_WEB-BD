<?php

class ServiceReparation
{
    private $Reparation;
    private $Prestataire;
    public function __construct()
    {
        $this->Reparation = new Reparation();
        $this->Prestataire = new Prestataire();
    }

    /**
     * Récupère toutes les réparations/entretiens enregistrés
     * @return array|null Tableau de toutes les réparations ou null
     */
    public function getAll(){
        return $this->Reparation->getAll();
    }

    public function getAllPrestataires(){
        return $this->Prestataire->getAll();
    }

    public function getPrestataireByID($id){
        return $this->Prestataire->getById($id);
    }

    /**
     * Alias pour getPrestataireByID
     * @param int $id ID du prestataire
     * @return array|false Données du prestataire
     */
    public function getPrestataire($id){
        return $this->Prestataire->getById($id);
    }

    /**
     * Récupère toutes les réparations effectuées par un prestataire
     * @param int $id_prestataire ID du prestataire
     * @return array|false Tableau des réparations
     */
    public function getReparationsParPrestataire($id_prestataire){
        return $this->Prestataire->getReparations($id_prestataire);
    }

    public function getReparation($date_debut,$longitude,$latitude){
        return $this->Reparation->getReparation($date_debut,$longitude,$latitude);
    }

    /**
     * Récupère les réparations effectuées par un member du personnel
     * @param int $idPersonnel ID du member du personnel
     * @return array|null Tableau des réparations ou null
     */
    public function getReparationsParPersonnel($idPersonnel)
    {
        $reparations = $this->Reparation->getParPersonnel($idPersonnel);
        if (!$reparations) {
            return null;
        }
        return $reparations;
    }
    /**
     * Récupère les réparations d'un enclos par ses coordonnées GPS
     * @param float $latitude Latitude de l'enclos
     * @param float $longitude Longitude de l'enclos
     * @return array|null Tableau des réparations ou null
     */
    public function getReparationsParEnclos($latitude, $longitude)
    {
        $reparations = $this->Reparation->getParEnclos($latitude, $longitude);
        if (!$reparations) {
            return null;
        }
        return $reparations;
    }

    /**
     * Valide les données d'une réparation/entretien
     * @param string $champ Suffixe du champ (_cree ou _modif)
     * @return string 'ok' ou code d'erreur ('nature', 'cout')
     */
    public function verificationFormReparation($champ)
    {
        // Valide la nature de la réparation (255 caractères max, contenu libre avec caractères spéciaux)
        if (empty($_POST['nature_reparation_' . $champ] ?? '')) {
            return 'nature';
        }
        
        // Valide le coût (optionnel mais doit être numérique s'il est fourni)
        if (!empty($_POST['cout_reparation_' . $champ] ?? '')) {
            if (!is_numeric($_POST['cout_reparation_' . $champ]) || floatval($_POST['cout_reparation_' . $champ]) < 0) {
                return 'cout';
            }
        }
        
        return 'ok';
    }

    /**
     * Ajoute une nouvelle réparation/entretien
     * Vérifie les données POST et crée l'enregistrement
     * @return bool|string|null Résultat de la création ou code d'erreur
     */
    public function ajoutEntretien()
    {
        $validationCode = $this->verificationFormReparation('cree');
        if ($validationCode != 'ok') {
            return $validationCode;
        }

        $dateDebut = $_POST['date_debut_reparation_cree'] ?? null;
        $latitude = isset($_POST['latitude_enclos_cree']) && $_POST['latitude_enclos_cree'] !== '' ? floatval($_POST['latitude_enclos_cree']) : null;
        $longitude = isset($_POST['longitude_enclos_cree']) && $_POST['longitude_enclos_cree'] !== '' ? floatval($_POST['longitude_enclos_cree']) : null;
        $idPersonnel = $_SESSION['user']['ID_PERSONNEL'] ?? null;

        if (!$dateDebut || $latitude === null || $longitude === null || !$idPersonnel) {
            return null;
        }

        $data = [
            'DATE_DEBUT_REPARATION' => $dateDebut,
            'LATITUDE_ENCLOS' => $latitude,
            'LONGITUDE_ENCLOS' => $longitude,
            'ID_PERSONNEL' => intval($idPersonnel),
            'ID_PRESTATAIRE' => $_POST['id_prestataire_cree'] ?? '',
            'DATE_FIN' => $_POST['date_fin_cree'] ?? '',
            'NATURE_REPARATION' => $_POST['nature_reparation_cree'] ?? '',
            'COUT_REPARATION' => $_POST['cout_reparation_cree'] ?? ''
        ];

        return $this->Reparation->creer($data);
    }

    /**
     * Met à jour une réparation/entretien existante
     * @param string $dateDebut Date de début
     * @param float $latitude Latitude de l'enclos
     * @param float $longitude Longitude de l'enclos
     * @return bool|string Succès ou code d'erreur
     */
    public function majEntretien($dateDebut, $latitude, $longitude)
    {
        $validationCode = $this->verificationFormReparation('modif');
        if ($validationCode != 'ok') {
            return $validationCode;
        }

        $data = [
            'DATE_DEBUT_REPARATION' => $dateDebut,
            'LONGITUDE_ENCLOS' => $longitude,
            'LATITUDE_ENCLOS' => $latitude,
            'ID_PRESTATAIRE' => $_POST['id_prestataire_modif'] ?? null,
            'DATE_FIN' => $_POST['date_fin_modif'] ?? null,
            'NATURE_REPARATION' => $_POST['nature_reparation_modif'] ?? null,
            'COUT_REPARATION' => $_POST['cout_reparation_modif'] ?? null
        ];

        return $this->Reparation->update($data);
    }

    public function verificationFormPrestataire($champ)
    {
        if (!preg_match('/^[a-zA-Z-\'éèêëç ]+$/', $_POST['nom_' . $champ] ?? '')) {
            return 'nom';
        }
        if (!preg_match('/^[a-zA-Z-\'éèêëç ]+$/', $_POST['prenom_' . $champ] ?? '')) {
            return 'prenom';
        }
        return 'ok';
    }

    /**
     * Ajoute un nouveau prestataire
     * Vérifie les données POST et crée l'enregistrement
     * @return bool|string|null Résultat de la création ou code d'erreur
     */
    public function ajoutPrestataire()
    {
        $validationCode = $this->verificationFormPrestataire('cree');
        if ($validationCode != 'ok') {
            return $validationCode; // Retourne le code d'erreur correspondant à la première validation qui a échoué
        }

        $data = [
            'NOM_PRESTATAIRE' => $_POST['nom_cree'] ?? null,
            'PRENOM_PRESTATAIRE' => $_POST['prenom_cree'] ?? null
        ];

        return $this->Prestataire->creer($data);
    }

    /**
     * Met à jour un prestataire existant
     * @param int $id ID du prestataire
     * @return bool|string|null Résultat de la mise à jour ou code d'erreur
     */
    public function majPrestataire(int $id)
    {
        $validationCode = $this->verificationFormPrestataire('modif');
        if ($validationCode != 'ok') {
            return $validationCode; // Retourne le code d'erreur correspondant à la première validation qui a échoué
        }

        $data = [
            'NOM_PRESTATAIRE' => $_POST['nom_modif'] ?? null,
            'PRENOM_PRESTATAIRE' => $_POST['prenom_modif'] ?? null
        ];

        return $this->Prestataire->update($id, $data);
    }

    /**
     * Alias pour majPrestataire avec données fournies (pour rétrocompatibilité)
     * @param int $id ID du prestataire
     * @param array $data Données à mettre à jour
     * @return bool|null Résultat de la mise à jour
     */
    public function updatePrestataire(int $id, array $data)
    {
        return $this->Prestataire->update($id, $data);
    }

    /**
     * Supprime un prestataire
     * @param int $id ID du prestataire
     * @return bool|null Résultat de la suppression
     */
    public function supprPrestataire(int $id)
    {
        return $this->Prestataire->suppr($id);
    }

    /**
     * Met à jour une réparation/entretien existante
     * @param string $dateDebut Date de début
     * @param float $latitude Latitude de l'enclos
     * @param float $longitude Longitude de l'enclos
     * @param array $data Données à mettre à jour
     * @return bool Résultat de la mise à jour
     */
    public function updateReparation($data)
    {
        return $this->Reparation->update($data);
    }

    /**
     * Supprime une réparation/entretien
     * @param string $dateDebut Date de début
     * @param float $latitude Latitude de l'enclos
     * @param float $longitude Longitude de l'enclos
     * @return bool Résultat de la suppression
     */
    public function supprReparation($dateDebut, $latitude, $longitude)
    {
        return $this->Reparation->suppr($dateDebut, $latitude, $longitude);
    }
}