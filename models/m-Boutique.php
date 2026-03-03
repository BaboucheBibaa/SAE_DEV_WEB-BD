<?php
class Boutique
{
    public static function toutRecup()
    {
        /*Récupère toutes les boutiques
        */
        $db = Database::getConnection();
        $sql = "SELECT *
                FROM Boutique";
        $stid = oci_parse($db, $sql);
        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        $boutiques = [];
        oci_fetch_all($stid, $boutiques, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        return $boutiques;
    }

    /**
     * Récupère une boutique par son ID
     */
    public static function recupParID($id)
    {
        $db = Database::getConnection();
        $sql = "SELECT * FROM Boutique WHERE ID_BOUTIQUE = :id";
        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ':id', $id);
        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        return oci_fetch_assoc($stid);
    }

        public static function creer($data)
    {
        $db = Database::getConnection();
        $sql = "INSERT INTO Boutique (ID_BOUTIQUE,ID_MANAGER,ID_ZONE,NOM_BOUTIQUE,DESCRIPTION_BOUTIQUE) 
            VALUES (seq_boutique.NEXTVAL, :id_manager, :id_zone, :nom_boutique, :description_boutique)";
        $stid = oci_parse($db, $sql);

        $id_manager = $data['id_manager'] ?? null;
        $id_zone = $data['id_zone'] ?? null;
        $nom_boutique = $data['nom_boutique'] ?? null;
        $description_boutique = $data['description_boutique'] ?? null;

        oci_bind_by_name($stid, ':id_manager', $id_manager);
        oci_bind_by_name($stid, ':id_zone', $id_zone);
        oci_bind_by_name($stid, ':nom_boutique', $nom_boutique);
        oci_bind_by_name($stid, ':description_boutique', $description_boutique);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        return $r;
    }

    /**
     * Met à jour une boutique
     */
    public static function maj($id, $data)
    {
        $db = Database::getConnection();
        $sql = 'UPDATE Boutique 
            SET ID_MANAGER = :id_manager, ID_ZONE = :id_zone, NOM_BOUTIQUE = :nom_boutique, DESCRIPTION_BOUTIQUE = :description_boutique
            WHERE ID_BOUTIQUE = :id';
        $stid = oci_parse($db, $sql);

        $id_manager = $data['id_manager'] ?? null;
        $id_zone = $data['id_zone'] ?? null;
        $nom_boutique = $data['nom_boutique'] ?? null;
        $description_boutique = $data['description_boutique'] ?? null;

        oci_bind_by_name($stid, ':id_manager', $id_manager);
        oci_bind_by_name($stid, ':id_zone', $id_zone);
        oci_bind_by_name($stid, ':nom_boutique', $nom_boutique);
        oci_bind_by_name($stid, ':description_boutique', $description_boutique);
        oci_bind_by_name($stid, ':id', $id);
        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        return $r;
    }

    /**
     * Supprime une boutique
     */
    public static function suppr($id)
    {
        $db = Database::getConnection();
        $sql = "DELETE FROM Boutique WHERE ID_BOUTIQUE = :id";
        $stid = oci_parse($db, $sql);
        oci_bind_by_name($stid, ':id', $id);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        return $r;
    }
}

?>