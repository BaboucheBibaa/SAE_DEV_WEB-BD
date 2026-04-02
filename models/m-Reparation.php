<?php
class Reparation extends BaseModel
{

    public function getAll()
    {
        //Retourne toutes les réparations effectuées sur un enclos donné (avec les détails du personnel et du prestataire s'il y en a eu un)
        $sql = "SELECT R.*, P.NOM, P.PRENOM,PR.NOM_PRESTATAIRE 
        FROM REPARATION R 
        LEFT JOIN PERSONNEL P ON R.ID_PERSONNEL = P.ID_PERSONNEL 
        LEFT JOIN PRESTATAIRE PR ON R.ID_PRESTATAIRE = PR.ID_PRESTATAIRE;";
        return $this->executeQueryAll($sql);
    }

    public function getReparation($dateDebut, $longitude, $latitude)
    {
        //Retourne toutes les réparations effectuées sur un enclos donné (avec les détails du personnel et du prestataire s'il y en a eu un)
        $sql = "SELECT R.*, P.NOM, P.PRENOM,PR.NOM_PRESTATAIRE 
        FROM REPARATION R 
        LEFT JOIN PERSONNEL P ON R.ID_PERSONNEL = P.ID_PERSONNEL 
        LEFT JOIN PRESTATAIRE PR ON R.ID_PRESTATAIRE = PR.ID_PRESTATAIRE
        WHERE R.DATE_DEBUT_REPARATION = TO_DATE(:date_debut, 'DD/MM/YY') AND R.LONGITUDE_ENCLOS = :longitude AND R.LATITUDE_ENCLOS = :latitude;";
        return $this->executeQuery($sql, [
            ':date_debut' => $dateDebut,
            ':longitude' => $longitude,
            ':latitude' => $latitude
        ]);
    }

    public function getParPersonnel($idPersonnel)
    {
        //Retourne toutes les réparations effectuées par un personnel donné (avec les détails de l'enclos réparé, de la zone et du prestataire)
        $sql = "SELECT R.*, E.ID_ZONE, E.TYPE_ENCLOS, Z.NOM_ZONE, PR.NOM_PRESTATAIRE, PR.PRENOM_PRESTATAIRE
                FROM REPARATION R 
                JOIN ENCLOS E ON R.LATITUDE_ENCLOS = E.LATITUDE AND R.LONGITUDE_ENCLOS = E.LONGITUDE
                JOIN ZONE Z ON E.ID_ZONE = Z.ID_ZONE
                LEFT JOIN PRESTATAIRE PR ON R.ID_PRESTATAIRE = PR.ID_PRESTATAIRE
                WHERE R.ID_PERSONNEL = :idPersonnel
                ORDER BY R.DATE_DEBUT_REPARATION DESC";
        return $this->executeQueryAll($sql, [':idPersonnel' => $idPersonnel]);
    }

    public function getParEnclos($latitude, $longitude)
    {
        //Retourne toutes les réparations effectuées sur un enclos donné (avec les détails du personnel et du prestataire s'il y en a eu un)
        $sql = "SELECT R.*, P.NOM, P.PRENOM,PR.NOM_PRESTATAIRE 
        FROM REPARATION R 
        LEFT JOIN PERSONNEL P ON R.ID_PERSONNEL = P.ID_PERSONNEL 
        LEFT JOIN PRESTATAIRE PR ON R.ID_PRESTATAIRE = PR.ID_PRESTATAIRE 
        WHERE R.LATITUDE_ENCLOS = :latitude AND R.LONGITUDE_ENCLOS = :longitude 
        ORDER BY R.DATE_DEBUT_REPARATION DESC";

        return $this->executeQueryAll($sql, [':latitude' => $latitude, ':longitude' => $longitude]);
    }

    public function creer($data)
    {
        $sql = "INSERT INTO REPARATION (
                    DATE_DEBUT_REPARATION,
                    LATITUDE_ENCLOS,
                    LONGITUDE_ENCLOS,
                    ID_PERSONNEL,
                    ID_PRESTATAIRE,
                    DATE_FIN,
                    NATURE_REPARATION,
                    COUT_REPARATION
                ) VALUES (
                    TO_DATE(:date_debut_reparation, 'YYYY-MM-DD'),
                    :latitude_enclos,
                    :longitude_enclos,
                    :id_personnel,
                    :id_prestataire,
                    TO_DATE(:date_fin, 'YYYY-MM-DD'),
                    :nature_reparation,
                    :cout_reparation
                )";

        $idPrestataire = $data['ID_PRESTATAIRE'] !== '' ? $data['ID_PRESTATAIRE'] : null;
        $dateFin = $data['DATE_FIN'] !== '' ? $data['DATE_FIN'] : null;
        $natureReparation = $data['NATURE_REPARATION'] !== '' ? $data['NATURE_REPARATION'] : null;
        $coutReparation = $data['COUT_REPARATION'] !== '' ? $data['COUT_REPARATION'] : null;

        return $this->executeModify($sql, [
            ':date_debut_reparation' => $data['DATE_DEBUT_REPARATION'],
            ':latitude_enclos' => $data['LATITUDE_ENCLOS'],
            ':longitude_enclos' => $data['LONGITUDE_ENCLOS'],
            ':id_personnel' => $data['ID_PERSONNEL'],
            ':id_prestataire' => $idPrestataire,
            ':date_fin' => $dateFin,
            ':nature_reparation' => $natureReparation,
            ':cout_reparation' => $coutReparation
        ]);
    }

    /**
     * Met à jour une réparation existante
     * 
     * @param string $dateDebut Date de début (clé primaire)
     * @param float $latitude Latitude de l'enclos (clé primaire)
     * @param float $longitude Longitude de l'enclos (clé primaire)
     * @param array $data Données à mettre à jour
     * @return bool Succès de l'opération
     */
    public function update($data)
    {
        $sql = "UPDATE REPARATION 
                SET ID_PRESTATAIRE = :id_prestataire,
                    DATE_FIN = TO_DATE(:date_fin,'YYYY-MM-DD'),
                    NATURE_REPARATION = :nature_reparation,
                    COUT_REPARATION = :cout_reparation
                WHERE DATE_DEBUT_REPARATION = TO_DATE(:date_debut,'YYYY-MM-DD') 
                AND LATITUDE_ENCLOS = :latitude 
                AND LONGITUDE_ENCLOS = :longitude";

        return $this->executeModify($sql, [
            ':date_debut' => $data['DATE_DEBUT_REPARATION'],
            ':latitude' => $data['LATITUDE_ENCLOS'],
            ':longitude' => $data['LONGITUDE_ENCLOS'],
            ':id_prestataire' => $data['ID_PRESTATAIRE'] ?: null,
            ':date_fin' => $data['DATE_FIN'] ?: null,
            ':nature_reparation' => $data['NATURE_REPARATION'] ?: null,
            ':cout_reparation' => $data['COUT_REPARATION'] ?: null
        ]);
    }

    /**
     * Supprime une réparation
     * 
     * @param string $dateDebut Date de début de la réparation
     * @param float $latitude Latitude de l'enclos
     * @param float $longitude Longitude de l'enclos
     * @return bool Succès de l'opération
     */
    public function suppr($dateDebut, $latitude, $longitude)
    {
        $sql = "DELETE FROM REPARATION 
                WHERE DATE_DEBUT_REPARATION = TO_DATE(:date_debut, 'DD/MM/YY') 
                AND LATITUDE_ENCLOS = :latitude 
                AND LONGITUDE_ENCLOS = :longitude";
        return $this->executeModify($sql, [
            ':date_debut' => $dateDebut,
            ':latitude' => $latitude,
            ':longitude' => $longitude
        ]);
    }
}
