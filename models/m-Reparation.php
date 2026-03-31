<?php
class Reparation
{

    public function recupReparationParPersonnel($idPersonnel)
    {
        //Retourne toutes les réparations effectuées par un personnel donné (avec les détails de l'enclos réparé)
        $db = Database::getConnection();
        $sql = "SELECT R.*, E.ID_ZONE, E.TYPE_ENCLOS 
                FROM REPARATION R 
            JOIN ENCLOS E ON R.LATITUDE_ENCLOS = E.LATITUDE AND R.LONGITUDE_ENCLOS = E.LONGITUDE
                WHERE R.ID_PERSONNEL = :idPersonnel
                ORDER BY R.DATE_DEBUT_REPARATION DESC";
        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ":idPersonnel", $idPersonnel);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        $result = [];
        oci_fetch_all($stid, $result,0,-1,OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        return $result;
    }
    public function recupReparationsParEnclos($latitude, $longitude)
    {
        //Retourne toutes les réparations effectuées sur un enclos donné (avec les détails du personnel et du prestataire s'il y en a eu un)
        $db = Database::getConnection();
        $sql = "SELECT R.*, P.NOM, P.PRENOM,PR.NOM_PRESTATAIRE 
        FROM REPARATION R 
        LEFT JOIN PERSONNEL P ON R.ID_PERSONNEL = P.ID_PERSONNEL 
        LEFT JOIN PRESTATAIRE PR ON R.ID_PRESTATAIRE = PR.ID_PRESTATAIRE 
        WHERE R.LATITUDE_ENCLOS = :latitude AND R.LONGITUDE_ENCLOS = :longitude 
        ORDER BY R.DATE_DEBUT_REPARATION DESC";

        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ":latitude", $latitude);
        oci_bind_by_name($stid, ":longitude", $longitude);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        $result = [];
        oci_fetch_all($stid, $result,0,-1,OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        return $result;
    }

    public function creer($data)
    {
        $db = Database::getConnection();
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

        $stid = oci_parse($db, $sql);

        $idPrestataire = $data['ID_PRESTATAIRE'] !== '' ? $data['ID_PRESTATAIRE'] : null;
        $dateFin = $data['DATE_FIN'] !== '' ? $data['DATE_FIN'] : null;
        $natureReparation = $data['NATURE_REPARATION'] !== '' ? $data['NATURE_REPARATION'] : null;
        $coutReparation = $data['COUT_REPARATION'] !== '' ? $data['COUT_REPARATION'] : null;

        oci_bind_by_name($stid, ':date_debut_reparation', $data['DATE_DEBUT_REPARATION']);
        oci_bind_by_name($stid, ':latitude_enclos', $data['LATITUDE_ENCLOS']);
        oci_bind_by_name($stid, ':longitude_enclos', $data['LONGITUDE_ENCLOS']);
        oci_bind_by_name($stid, ':id_personnel', $data['ID_PERSONNEL']);
        oci_bind_by_name($stid, ':id_prestataire', $idPrestataire);
        oci_bind_by_name($stid, ':date_fin', $dateFin);
        oci_bind_by_name($stid, ':nature_reparation', $natureReparation);
        oci_bind_by_name($stid, ':cout_reparation', $coutReparation);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        return $r;
    }
}
