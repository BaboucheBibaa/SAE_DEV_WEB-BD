<?php

class ServiceEnclos
{
    private $Enclos;
    public function __construct()
    {
        $this->Enclos = new Enclos();
    }

    /**
     * Récupère tous les enclos
     * @return array|null Tableau de tous les enclos ou null
     */
    public function getAll(){
        return $this->Enclos->getAll();
    }
    /**
     * Récupère un enclos par ses coordonnées GPS
     * @param float $latitude Latitude de l'enclos
     * @param float $longitude Longitude de l'enclos
     * @return array|null Données de l'enclos ou null
     */
    public function getEnclosParCoordonnees($latitude, $longitude)
    {
        $enclos = $this->Enclos->getParCoordonnees($latitude, $longitude);
        if (!$enclos) {
            return null;
        }
        return $enclos;
    }

    /**
     * Récupère tous les enclos d'une zone
     * @param int $id_zone ID de la zone
     * @return array|null Tableau des enclos de la zone ou null
     */
    public function getEnclosParZone($id_zone)
    {
        $enclos = $this->Enclos->getParZone($id_zone);
        if (!$enclos) {
            return null;
        }
        return $enclos;
    }

    public function verificationForm($champ)
    {
        // Valide le type d'enclos (lettres, chiffres, espaces, traits d'union)
        if (!preg_match('/^[a-zA-Z0-9\-éèêëç ]+$/', $_POST['type_enclos_' . $champ] ?? '')) {
            return 'type';
        }
        return 'ok';
    }

    /**
     * Crée un nouvel enclos
     * @return bool|string|null Succès de l'opération ou code d'erreur
     */
    public function ajoutEnclos()
    {
        $validationCode = $this->verificationForm('cree');
        if ($validationCode != 'ok') {
            return $validationCode;
        }

        $data = [
            'LATITUDE' => $_POST['latitude_cree'] ?? '',
            'LONGITUDE' => $_POST['longitude_cree'] ?? '',
            'ID_ZONE' => $_POST['id_zone_cree'] ?? '',
            'TYPE_ENCLOS' => $_POST['type_enclos_cree'] ?? ''
        ];
        return $this->Enclos->creer($data);
    }

    /**
     * Met à jour un enclos
     * @param float $latitude Latitude
     * @param float $longitude Longitude
     * @return bool|string|null Succès de l'opération ou code d'erreur
     */
    public function majEnclos($latitude, $longitude)
    {
        $validationCode = $this->verificationForm('modif');
        if ($validationCode != 'ok') {
            return $validationCode;
        }

        $data = [
            'ID_ZONE' => $_POST['id_zone_modif'] ?? '',
            'TYPE_ENCLOS' => $_POST['type_enclos_modif'] ?? ''
        ];

        return $this->Enclos->update($latitude, $longitude, $data);
    }

    /**
     * Supprime un enclos
     * @param float $latitude Latitude
     * @param float $longitude Longitude
     * @return bool|string Succès de l'opération ou echec
     */
    public function supprEnclos($latitude, $longitude)
    {
        //si coordonnées inexistantes
        if (!$this->getEnclosParCoordonnees($latitude, $longitude)){
            return 'coordonnees';
        }
        return $this->Enclos->suppr($latitude, $longitude);
    }
}