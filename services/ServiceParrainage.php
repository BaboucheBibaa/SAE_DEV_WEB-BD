<?php

class ServiceParrainage
{
    public function getParrainsParAnimal($id_animal)
    {
        $parrains = Parrainage::recupParAnimal($id_animal);
        if (!$parrains) {
            return null;
        }
        return $parrains;
    }

    public function getTousVisiteurs()
    {
        $visiteurs = Parrainage::recupTousVisiteurs();
        if (!$visiteurs) {
            return null;
        }
        return $visiteurs;
    }

    public function getNiveauxParrainage()
    {
        $niveaux = Parrainage::toutRecup();
        if (!$niveaux) {
            return null;
        }
        return $niveaux;
    }

    public function supprimerParrainage($id_animal, $id_visiteur)
    {
        return Parrainage::supprimerParrainage($id_animal, $id_visiteur);
    }

    public function creerParrainage($id_animal, $id_visiteur, $id_parrainage)
    {
        return Parrainage::creerParrainage($id_animal, $id_visiteur, $id_parrainage);
    }
}