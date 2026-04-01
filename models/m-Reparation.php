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

    public function getParPersonnel($idPersonnel)
    {
        //Retourne toutes les réparations effectuées par un personnel donné (avec les détails de l'enclos réparé)
        $sql = "SELECT R.*, E.ID_ZONE, E.TYPE_ENCLOS 
                FROM REPARATION R 
            JOIN ENCLOS E ON R.LATITUDE_ENCLOS = E.LATITUDE AND R.LONGITUDE_ENCLOS = E.LONGITUDE
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
}
