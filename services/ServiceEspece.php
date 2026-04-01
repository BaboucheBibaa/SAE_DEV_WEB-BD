<?php

class ServiceEspece {
    private $Espece;


    public function __construct()
    {
        $this->Espece = new Espece();
    }

    /**
     * Récupère toutes les espèces
     * @return array|null Tableau de toutes les espèces ou null
     */
    public function getAll(){
        return $this->Espece->getAll();
    }

    /**
     * Récupère une espèce par son ID
     * @param int $id ID de l'espèce
     * @return array|null Données de l'espèce ou null
     */
    public function getParID($id){
        return $this->Espece->getParID($id);
    }

    /**
     * Supprime une espèce de la base de données
     * @param int $id_espece ID de l'espèce à supprimer
     * @return bool|null Résultat de la suppression
     */
    public function supprimerEspece($id_espece){
        if (!$id_espece){
            return null;
        }
        return $this->Espece->suppr($id_espece);
    }

    /**
     * Récupère les espèces compatibles avec une espèce donnée
     * @param int $id_espece ID de l'espèce
     * @return array|null Tableau des espèces compatibles ou null
     */
    public function getEspecesCompatibles($id_espece){
        return $this->Espece->getEspecesCompatibles($id_espece);
    }

    /**
     * Récupère tous les animaux d'une espèce donnée
     * @param int $id_espece ID de l'espèce
     * @return array|null Tableau des animaux de cette espèce ou null
     */
    public function getAnimauxParEspece($id_espece){
        return $this->Espece->getAnimauxParEspece($id_espece);
    }
}