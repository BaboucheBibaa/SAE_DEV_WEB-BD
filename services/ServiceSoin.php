<?php


class ServiceSoin
{
    public function getAnimauxParSoigneur($id_soigneur)
    {
        $animaux = Animal::recupTousParSoigneurs($id_soigneur);
        if (!$animaux) {
            return null;
        }
        return $animaux;
    }

    public function getSoinsParSoigneur($id_soigneur){
        $soins = HistoriqueSoins::recupSoinsParPersonne($id_soigneur);
        if (!$soins) {
            return null;
        }
        return $soins;
    }

    public function getSoinsParAnimal($id_animal){
        $soins = HistoriqueSoins::recupSoinsParAnimal($id_animal);
        if (!$soins) {
            return null;
        }
        return $soins;
    }
    public function getNourritureParAnimal($id_animal){
        $nourriture = HistoriqueSoins::recupNourritureParAnimal($id_animal);
        if (!$nourriture) {
            return null;
        }
        return $nourriture;
    }

    public function ajoutSoin()
    {
        $idAnimal = isset($_POST['ID_ANIMAL']) && $_POST['ID_ANIMAL'] !== '' ? intval($_POST['ID_ANIMAL']) : null;
        $dateSoin = $_POST['DATE_SOIN'] ?? null;
        $descriptionSoin = $_POST['DESCRIPTION_SOIN'] ?? null;
        $idPersonnel = $_SESSION['user']['ID_PERSONNEL'];

        if (!$idAnimal || !$dateSoin || !$descriptionSoin || !$idPersonnel) {
            return null;
        }

        $data = [
            'ID_ANIMAL' => $idAnimal,
            'DATE_SOIN' => $dateSoin,
            'DESCRIPTION_SOIN' => $descriptionSoin,
            'ID_PERSONNEL' => $idPersonnel
        ];
        return HistoriqueSoins::creer($data);
    }
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
        return HistoriqueSoins::creerNourriture($data);
    }
}
