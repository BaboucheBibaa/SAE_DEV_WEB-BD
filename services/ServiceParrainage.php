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

    public function getNiveauxParrainages()
    {
        $parrainages = $this->Parrainage->recupNiveauxParrainage();
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

    public function getNiveauxParrainage()
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
        $data = [
            'id_animal' => $_POST['ID_ANIMAL'] ?? null,
            'id_visiteur' => $_POST['ID_VISITEUR'] ?? null,
            'niveau' => $_POST['NIVEAU'] ?? null,
            'libelle' => $_POST['LIBELLE'] ?? null
        ];
        return $this->Parrainage->creerParrainage($data);
    }
}