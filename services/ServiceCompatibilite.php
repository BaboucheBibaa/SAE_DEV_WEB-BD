<?php

class ServiceCompatibilite
{
    private $Compatibilite;

    public function __construct()
    {
        $this->Compatibilite = new Compatibilité();
    }

    /**
     * Récupère toutes les compatibilités
     * @return array Tableau des compatibilités
     */
    public function getAll()
    {
        return $this->Compatibilite->getAll();
    }

    /**
     * Vérifie si deux espèces sont compatibles
     * @param int $id_espece1 Première espèce
     * @param int $id_espece2 Deuxième espèce
     * @return bool Compatibilité existe
     */
    public function verifierCompatibilite($id_espece1, $id_espece2)
    {
        return $this->Compatibilite->verifierCompatibilite($id_espece1, $id_espece2);
    }

    /**
     * Ajoute une compatibilité entre deux espèces
     * @return bool Succès de l'opération
     */
    public function ajoutCompatibilite()
    {
        $id_espece1 = $_POST['id_espece1'] ?? null;
        $id_espece2 = $_POST['id_espece2'] ?? null;

        if (!$id_espece1 || !$id_espece2) {
            return false;
        }

        return $this->Compatibilite->creer($id_espece1, $id_espece2);
    }

    /**
     * Supprime une compatibilité entre deux espèces
     * @param int $id_espece1 Première espèce
     * @param int $id_espece2 Deuxième espèce
     * @return bool Succès de l'opération
     */
    public function supprCompatibilite($id_espece1, $id_espece2)
    {
        return $this->Compatibilite->suppr($id_espece1, $id_espece2);
    }
}
