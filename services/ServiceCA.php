<?php
class ServiceCA
{
    private $CA;

    public function __construct()
    {
        $this->CA = new CA();
    }
    /**
     * Récupère tous les chiffres d'affaires enregistrés
     * @return array|null Tableau de tous les CA ou null
     */
    public function getAll()
    {
        return $this->CA->getAll();
    }
    /**
     * Ajoute un nouveau chiffre d'affaires
     * @param array $data Données du CA (id_boutique, date_ca, montant, etc.)
     * @return bool|null Résultat de l'ajout
     */
    public function ajoutCA($data)
    {
        return $this->CA->creer($data);
    }

    /**
     * Supprime un enregistrement de chiffre d'affaires
     * @param int $id_boutique ID de la boutique
     * @param string $date_ca Date du CA sous format YYYY-MM-DD
     * @return bool|null Résultat de la suppression
     */
    public function supprCA($id_boutique, $date_ca)
    {
        return $this->CA->suppr($id_boutique, $date_ca);
    }
    /**
     * Vérifie si un enregistrement CA existe pour une boutique à une date donnée
     * @param int $idBoutique ID de la boutique
     * @param string $date Date à vérifier
     * @return bool True si existe, false sinon
     */
    public function existeCA($idBoutique, $date)
    {
        return $this->CA->existeCA($idBoutique, $date);
    }

    /**
     * Calcule la somme du chiffre d'affaires d'une boutique
     * @param int $idBoutique ID de la boutique
     * @param int|null $annee Année optionnelle pour filtrer
     * @return numeric|null Total du CA ou null
     */
    public function getSommeCA($idBoutique, $annee = null)
    {
        return $this->CA->getSommeCA($idBoutique, $annee);
    }

    /**
     * Calcule la moyenne du chiffre d'affaires d'une boutique
     * @param int $idBoutique ID de la boutique
     * @param int|null $annee Année optionnelle pour filtrer
     * @return numeric|null Moyenne du CA ou null
     */
    public function getMoyenneCA($idBoutique, $annee = null)
    {
        return $this->CA->getMoyenneCA($idBoutique, $annee);
    }

    /**
     * Récupère le chiffre d'affaires journalier d'une boutique
     * @param int $idBoutique ID de la boutique
     * @return array|null Tableau des CA journaliers ou null
     */
    public function getCAJournalier($idBoutique)
    {
        return $this->CA->getCAJournee($idBoutique);
    }

    /**
     * Récupère le chiffre d'affaires mensuel d'une boutique
     * @param int $idBoutique ID de la boutique
     * @return array|null Tableau des CA mensuels ou null
     */
    public function getCAMensuel($idBoutique)
    {
        return $this->CA->getCAMensuel($idBoutique);
    }
}
