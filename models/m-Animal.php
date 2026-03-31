<?php
class Animal
{


    public  function recupNomParID($id)
    {
        $db = Database::getConnection();

        $query = "SELECT NOM_ANIMAL FROM Animal WHERE ID_ANIMAL = :id_animal";
        $stid = oci_parse($db, $query);
        oci_bind_by_name($stid, ':id_animal', $id);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $result = oci_fetch_assoc($stid);
        return $result ? $result['NOM_ANIMAL'] : null;
    }
    public function recupParID($id)
    {
        $db = Database::getConnection();

        $query = "SELECT A.*,E.NOM_ESPECE FROM Animal A LEFT JOIN Espece E ON A.ID_ESPECE = E.ID_ESPECE WHERE A.ID_ANIMAL = :id_animal";
        $stid = oci_parse($db, $query);
        oci_bind_by_name($stid, ':id_animal', $id);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        return oci_fetch_assoc($stid);
    }

    public function recupSoigneurEtRemplacant($id_animal)
    {
        //récupère le soigneur attitré ainsi que le soigneur remplaçant de l'animal
        $db = Database::getConnection();
        $sql = "SELECT P.ID_SOIGNEUR SOIGNEUR,P.ID_REMPLACANT REMPLACANT FROM Animal A, Personnel P WHERE A.ID_SOIGNEUR = P.ID_PERSONNEL AND A.ID_ANIMAL = :id_animal";
        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ':id_animal', $id_animal);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $result = oci_fetch_assoc($stid);
        return $result;
    }

    public function toutRecup()
    {
        $db = Database::getConnection();
        $sql = "SELECT A.*,E.NOM_ESPECE FROM Animal A LEFT JOIN Espece E ON A.ID_ESPECE = E.ID_ESPECE";
        $stid = oci_parse($db, $sql);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $result = [];
        //OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC sont des constantes qui définissent le comportement du tableau retourné dans $result
        //la première constante fait en sorte qu'elle soit sous la forme d'un seul tableau et la 2eme fait en sorte que les index soient associatifs (clé => valeur)
        oci_fetch_all($stid, $result, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        return $result;
    }
    public function recupParCoordonnees($latitude, $longitude)
    {
        $db = Database::getConnection();

        $query = "SELECT A.* FROM Animal A WHERE A.LATITUDE_ENCLOS = :latitude AND A.LONGITUDE_ENCLOS = :longitude";
        $stid = oci_parse($db, $query);
        oci_bind_by_name($stid, ':latitude', $latitude);
        oci_bind_by_name($stid, ':longitude', $longitude);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $result = [];
        oci_fetch_all($stid, $result, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        return $result;
    }
    public function recupTousParSoigneurs($id_soigneur)
    {
        /* Récupère tous les animaux ou le soigneur $id_soigneur est responsable */
        $db = Database::getConnection();
        $query = "SELECT A.*,E.NOM_ESPECE
            FROM Animal A JOIN Espece E ON A.ID_Espece = E.ID_Espece WHERE A.ID_Soigneur = :id_soigneur;";

        $stid = oci_parse($db, $query);
        oci_bind_by_name($stid, ':id_soigneur', $id_soigneur);
        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        $result = [];
        oci_fetch_all($stid, $result, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        return $result;
    }
    public function recupParZone($id_zone)
    {
        $db = Database::getConnection();

        $query = "SELECT
                A.*,E.NOM_ESPECE 
                FROM Animal A 
                LEFT JOIN Espece E ON A.ID_ESPECE = E.ID_ESPECE 
                    WHERE (A.LATITUDE_ENCLOS,A.LONGITUDE_ENCLOS) IN 
                        (SELECT LATITUDE,LONGITUDE FROM Enclos WHERE ID_ZONE = :id_zone
    )";
        $stid = oci_parse($db, $query);
        oci_bind_by_name($stid, ':id_zone', $id_zone);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $result = [];
        oci_fetch_all($stid, $result, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        return $result;
    }
    public function creer($data)
    {
        $db = Database::getConnection();

        $sql = "INSERT INTO Animal (ID_ANIMAL, NOM_ANIMAL, DATE_NAISSANCE, POIDS, REGIME_ALIMENTAIRE, ID_ESPECE, LATITUDE_ENCLOS, LONGITUDE_ENCLOS, ID_SOIGNEUR) 
                VALUES ((SELECT NVL(MAX(ID_ANIMAL), 0) + 1 FROM Animal), :nom_animal, TO_DATE(:date_naissance, 'YYYY-MM-DD'), :poids, :regime_alimentaire, :id_espece, :latitude_enclos, :longitude_enclos, :id_soigneur)";

        $stid = oci_parse($db, $sql);

        $data['poids'] = str_replace('.',',',$data['poids']);

        oci_bind_by_name($stid, ':nom_animal', $data['nom_animal']);
        oci_bind_by_name($stid, ':date_naissance', $data['date_naissance']);
        oci_bind_by_name($stid, ':poids', $data['poids']);
        oci_bind_by_name($stid, ':regime_alimentaire', $data['regime_alimentaire']);
        oci_bind_by_name($stid, ':id_espece', $data['id_espece']);
        oci_bind_by_name($stid, ':latitude_enclos', $data['latitude_enclos']);
        oci_bind_by_name($stid, ':longitude_enclos', $data['longitude_enclos']);
        oci_bind_by_name($stid, ':id_soigneur', $data['id_soigneur']);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        return $r;
    }
    public function maj($id, $data)
    {
        $db = Database::getConnection();

        $sql = "UPDATE Animal SET 
                NOM_ANIMAL = :nom_animal,
                DATE_NAISSANCE = TO_DATE(:date_naissance, 'YYYY-MM-DD'),
                POIDS = :poids,
                REGIME_ALIMENTAIRE = :regime_alimentaire,
                ID_ESPECE = :id_espece,
                LATITUDE_ENCLOS = :latitude_enclos,
                LONGITUDE_ENCLOS = :longitude_enclos
                WHERE ID_ANIMAL = :id_animal";

        $stid = oci_parse($db, $sql);

        $data['poids'] = str_replace('.',',',$data['poids']);

        oci_bind_by_name($stid, ':id_animal', $id);
        oci_bind_by_name($stid, ':nom_animal', $data['nom_animal']);
        oci_bind_by_name($stid, ':date_naissance', $data['date_naissance']);
        oci_bind_by_name($stid, ':poids', $data['poids']);
        oci_bind_by_name($stid, ':regime_alimentaire', $data['regime_alimentaire']);
        oci_bind_by_name($stid, ':id_espece', $data['id_espece']);
        oci_bind_by_name($stid, ':latitude_enclos', $data['latitude_enclos']);
        oci_bind_by_name($stid, ':longitude_enclos', $data['longitude_enclos']);
        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        return $r;
    }
    public function suppr($id)
    {
        $db = Database::getConnection();

        $sql = "DELETE FROM Animal WHERE ID_ANIMAL = :id_animal";
        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ':id_animal', $id);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        return $r;
    }

    public function moteurRechercheRecup($searchTerm)
    {
        $db = Database::getConnection();

        $sql = "SELECT * FROM ANIMAL WHERE LOWER(NOM_ANIMAL) LIKE LOWER(:searchTerm)";
        $stid = oci_parse($db, $sql);
        $likeTerm = '%' . $searchTerm . '%';
        oci_bind_by_name($stid, ':searchTerm', $likeTerm);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $result = [];
        oci_fetch_all($stid, $result, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        return $result;
    }
}
