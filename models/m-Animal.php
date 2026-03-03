<?php
class Animal
{
    public static function recupParID($id)
    {
        $db = Database::getConnection();

        $query = "SELECT * FROM Animal WHERE ID_ANIMAL = :id_animal";
        $stid = oci_parse($db, $query);
        oci_bind_by_name($stid, ':id_animal', $id);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        return oci_fetch_assoc($stid);
    }

    public static function toutRecup()
    {
        $db = Database::getConnection();
        $sql = "SELECT * FROM Animal";
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

    public static function recupParZone($id_zone)
     {
         $db = Database::getConnection();

         $query = "SELECT * FROM Animal WHERE (LATITUDE_ENCLOS,LONGITUDE_ENCLOS) IN (SELECT LATITUDE,LONGITUDE FROM Enclos WHERE ID_ZONE = :id_zone)";
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

    public static function creer($data)
    {
        $db = Database::getConnection();
        
        // Génération du nouvel ID
        $sql_seq = "SELECT SEQ_Animal.NEXTVAL AS next_id FROM DUAL";
        $stid_seq = oci_parse($db, $sql_seq);
        oci_execute($stid_seq);
        $row = oci_fetch_assoc($stid_seq);
        $new_id = $row['NEXT_ID'];

        $sql = "INSERT INTO Animal (ID_ANIMAL, NOM_ANIMAL, DATE_NAISSANCE, POIDS, REGIME_ALIMENTAIRE, ID_ESPECE, LATITUDE_ENCLOS, LONGITUDE_ENCLOS) 
                VALUES (:id_animal, :nom_animal, TO_DATE(:date_naissance, 'YYYY-MM-DD'), :poids, :regime_alimentaire, :id_espece, :latitude_enclos, :longitude_enclos)";
        
        $stid = oci_parse($db, $sql);
        
        oci_bind_by_name($stid, ':id_animal', $new_id);
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

    public static function maj($id, $data)
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

    public static function suppr($id)
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
}
