<?php

class ServiceParrainage
{
    private $Parrainage;
    public function __construct()
    {
        $this->Parrainage = new Parrainage();
    }
    /**
     * Récupère les parrains d'un animal
     * @param int $id_animal ID de l'animal
     * @return array|null Tableau des parrains ou null
     */
    public function getParrainsParAnimal($id_animal)
    {
        $parrains = $this->Parrainage->getParAnimal($id_animal);
        if (!$parrains) {
            return null;
        }
        return $parrains;
    }

    /**
     * Récupère les libellés de parrainages disponibles
     * @return array|null Tableau des libellés ou null
     */
    public function getLibelleParrainages()
    {
        $parrainages = $this->Parrainage->getLibelle();
        if (!$parrainages) {
            return null;
        }
        return $parrainages;
    }
    /**
     * Récupère tous les visiteurs parrains
     * @return array|null Tableau de tous les visiteurs ou null
     */
    public function getTousVisiteurs()
    {
        $visiteurs = $this->Parrainage->getAllVisiteurs();
        if (!$visiteurs) {
            return null;
        }
        return $visiteurs;
    }


    /**
     * Supprime un parrainage entre un animal et un visiteur
     * @param int $id_animal ID de l'animal
     * @param int $id_visiteur ID du visiteur
     * @return bool|null Résultat de la suppression
     */
    public function supprimerParrainage($id_animal, $id_visiteur)
    {
        return $this->Parrainage->suppr($id_animal, $id_visiteur);
    }

    /**
     * Crée un nouveau parrainage à partir des données POST
     * @return bool|null Résultat de la création
     */
    public function creerParrainage()
    {
        $data = [
            'id_animal' => $_POST['id_animal'] ?? null,
            'id_visiteur' => $_POST['id_visiteur'] ?? null,
            'libelle' => $_POST['libelle'] ?? null
        ];
        return $this->Parrainage->creer($data);
    }
}
