<?php
class Compatibilité {
    public function verifierCompatibilite($id_espece1, $id_espece2) {
        // Vérifie si les deux espèces sont compatibles
        $db = Database::getConnection();

        $query = "SELECT * FROM Compatibilite_Especes 
                  WHERE (ID_ESPECE1 = :id_espece1 AND ID_ESPECE2 = :id_espece2) 
                     OR (ID_ESPECE1 = :id_espece2 AND ID_ESPECE2 = :id_espece1)";
        $stid = oci_parse($db, $query);
        oci_bind_by_name($stid, ':id_espece1', $id_espece1);
        oci_bind_by_name($stid, ':id_espece2', $id_espece2);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        return oci_fetch_assoc($stid) !== false;
    }

    public function getEspecesCompatibles($id_espece) {
        // Récupère les espèces compatibles avec l'espèce donnée
        $db = Database::getConnection();

        $query = "SELECT E.* FROM Espece E
                  JOIN Compatibilite_Especes C ON (E.ID_ESPECE = C.ID_ESPECE1 AND C.ID_ESPECE2 = :id_espece)
                                              OR (E.ID_ESPECE = C.ID_ESPECE2 AND C.ID_ESPECE1 = :id_espece)";
        $stid = oci_parse($db, $query);
        oci_bind_by_name($stid, ':id_espece', $id_espece);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $result = [];
        oci_fetch_all($stid, $result, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        return $result;
    }


    public function ajouterCompatibilite($id_espece1, $id_espece2) {
        // Ajoute une compatibilité entre deux espèces
        $db = Database::getConnection();

        $query = "INSERT INTO Compatibilite_Especes (ID_ESPECE1, ID_ESPECE2) VALUES (:id_espece1, :id_espece2)";
        $stid = oci_parse($db, $query);
        oci_bind_by_name($stid, ':id_espece1', $id_espece1);
        oci_bind_by_name($stid, ':id_espece2', $id_espece2);

        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        return $r;
    }
}
