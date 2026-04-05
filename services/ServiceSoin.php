<?php


class ServiceSoin
{
    private $Animal;
    private $Soin;
    private $Nourriture;
    public function __construct()
    {
        $this->Animal = new Animal();
        $this->Soin = new Soin();
        $this->Nourriture = new Nourriture();
    }

    /**
     * Récupère tous les animaux gérés par un soigneur
     * @param int $id_soigneur ID du soigneur
     * @return array|null Tableau des animaux ou null
     */
    public function getAnimauxParSoigneur($id_soigneur)
    {
        $animaux = $this->Animal->getAllSoigneurs($id_soigneur);
        if (!$animaux) {
            return null;
        }
        return $animaux;
    }

    /**
     * Récupère tous les soins effectués par un soigneur
     * @param int $id_soigneur ID du soigneur
     * @return array|null Tableau des soins ou null
     */
    public function getSoinsParSoigneur($id_soigneur)
    {
        $soins = $this->Soin->getParPersonne($id_soigneur);
        if (!$soins) {
            return null;
        }
        return $soins;
    }

    /**
     * Récupère tous les soins effectués sur un animal
     * @param int $id_animal ID de l'animal
     * @return array|null Tableau des soins ou null
     */
    public function getSoinsParAnimal($id_animal)
    {
        $soins = $this->Soin->getParAnimal($id_animal);
        if (!$soins) {
            return null;
        }
        return $soins;
    }
    /**
     * Récupère l'historique de nourriture d'un animal
     * @param int $id_animal ID de l'animal
     * @return array|null Tableau des nourritures ou null
     */
    public function getNourritureParAnimal($id_animal)
    {
        $nourriture = $this->Nourriture->getNourritureParAnimal($id_animal);
        if (!$nourriture) {
            return null;
        }
        return $nourriture;
    }

    /**
     * Ajoute un nouveau soin à partir des données POST
     * Vérifie que le soigneur est autorisé à ajouter un soin
     * @return bool|null Résultat de la création
     */
    public function ajoutSoin()
    {
        $estImplique = isset($_POST['estImplique']) ? $_POST['estImplique'] : 'non';
        $idAnimal = isset($_POST['ID_ANIMAL']) && $_POST['ID_ANIMAL'] !== '' ? intval($_POST['ID_ANIMAL']) : null;
        $dateSoin = $_POST['DATE_SOIN'] ?? null;
        $descriptionSoin = $_POST['DESCRIPTION_SOIN'] ?? null;
        //Si le membre du personnel est impliqué dans le soin alors on l'ajoute sinon non donc null
        $idPersonnel = $estImplique == 'oui' ? $_SESSION['user']['ID_PERSONNEL'] : null;

        $idVeterinaire = isset($_POST['ID_VETERINAIRE']) ? $_POST['ID_VETERINAIRE'] : null;

        //gestion si un soigneur qui n'est pas le soigneur attitré d'un animal décide d'ajouter un soin sur un animal qu'il ne gère pas
        $soigneurEtRemplacant = $this->Animal->getSoigneurEtRemplacant($idAnimal);
        if ($soigneurEtRemplacant['SOIGNEUR'] != $_SESSION['user']['ID_PERSONNEL'] || $soigneurEtRemplacant['REMPLACANT'] != $_SESSION['user']['ID_REMPLACANT']) {
            return null;
        }
        //le personnel ET le vétérinaire ne peuvent être null en même temps
        if (!$idAnimal || !$dateSoin || !$descriptionSoin || (!$idPersonnel && !$idVeterinaire)) {
            return null;
        }

        $data = [
            'ID_ANIMAL' => $idAnimal,
            'DATE_SOIN' => $dateSoin,
            'DESCRIPTION_SOIN' => $descriptionSoin,
            'ID_PERSONNEL' => $idPersonnel,
            'ID_VETERINAIRE' => $idVeterinaire
        ];
        return $this->Soin->creer($data);
    }

    /**
     * Supprime un soin enregistré
     * @param int $id_animal ID de l'animal
     * @param string $date_soin Date du soin
     * @return bool|null Résultat de la suppression
     */
    public function supprimerSoin($id_animal,$date_soin){
        return $this->Soin->suppr($id_animal,$date_soin);
    }

    /**
     * Supprime un enregistrement de nourriture
     * @param int $id_animal ID de l'animal
     * @param int $id_personnel ID du member du personnel
     * @param string $date_nourrit Date de la nourriture
     * @return bool|null Résultat de la suppression
     */
    public function supprimerNourriture($id_animal,$id_personnel,$date_nourrit){
        return $this->Nourriture->suppr($id_animal,$id_personnel,$date_nourrit);
    }

    /**
     * Ajoute un enregistrement de nourriture d'un animal
     * @return bool|null Résultat de la création
     */
    public function ajoutNourriture()
    {

        $idAnimal = isset($_POST['ID_ANIMAL']) && $_POST['ID_ANIMAL'] !== '' ? intval($_POST['ID_ANIMAL']) : null;
        $dateNourrit = $_POST['DATE_NOURRIT'] ?? null;
        $doseNourriture = $_POST['DOSE_NOURRITURE'] ?? null;
        $idPersonnel = $_SESSION['user']['ID_PERSONNEL'] ?? null;
        if (!$idAnimal || !$dateNourrit || !$doseNourriture || !$idPersonnel) {
            return null;
        }

        $data = [
            'ID_ANIMAL' => $idAnimal,
            'DATE_NOURRIT' => $dateNourrit,
            'DOSE_NOURRITURE' => $doseNourriture,
            'ID_PERSONNEL' => $idPersonnel
        ];
        return $this->Nourriture->creer($data);
    }
}
