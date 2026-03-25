<?php

class ServiceParrainage
{
    private $Parrainage;
    public function __construct()
    {
        $this->Parrainage = new Parrainage();
    }
    public function getParrainsParAnimal($id_animal)
    {
        $parrains = $this->Parrainage->recupParAnimal($id_animal);
        if (!$parrains) {
            return null;
        }
        return $parrains;
    }

    public function getLibelleParrainages()
    {
        $parrainages = $this->Parrainage->recupLibelleParrainages();
        if (!$parrainages) {
            return null;
        }
        return $parrainages;
    }
    public function getTousVisiteurs()
    {
        $visiteurs = $this->Parrainage->recupTousVisiteurs();
        if (!$visiteurs) {
            return null;
        }
        return $visiteurs;
    }

    public function getAll()
    {
        $niveaux = $this->Parrainage->toutRecup();
        if (!$niveaux) {
            return null;
        }
        return $niveaux;
    }

    public function supprimerParrainage($id_animal, $id_visiteur)
    {
        return $this->Parrainage->supprimerParrainage($id_animal, $id_visiteur);
    }

    public function creerParrainage()
    {
        echo $_POST['id_animal'];
        echo $_POST['id_visiteur'];
        echo $_POST['libelle'];

        $data = [
            'id_animal' => $_POST['id_animal'] ?? null,
            'id_visiteur' => $_POST['id_visiteur'] ?? null,
            'libelle' => $_POST['libelle'] ?? null
        ];
        return $this->Parrainage->creerParrainage($data);
    }
}
