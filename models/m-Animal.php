<?php
class Animal extends BaseModel
{
    /**
     * Récupère le nom d'un animal par son ID
     */
    public function getNomParID($id)
    {
        $query = "SELECT NOM_ANIMAL FROM Animal WHERE ID_ANIMAL = :id_animal";
        return $this->executeQuery($query, [':id_animal' => $id]);
    }

    /**
     * Récupère un animal avec son espèce par ID
     */
    public function getParID($id)
    {
        $query = "SELECT A.*, E.NOM_ESPECE FROM Animal A 
                 LEFT JOIN Espece E ON A.ID_ESPECE = E.ID_ESPECE 
                 WHERE A.ID_ANIMAL = :id_animal";
        return $this->executeQuery($query, [':id_animal' => $id]);
    }

    public function getParents($id)
    {
        $sql = "SELECT 
    P.ID_ANIMAL,
    P.NOM_ANIMAL,
    P.POIDS,
    P.DATE_NAISSANCE,
    ES.NOM_ESPECE,
    'Parent' as LIEN
    FROM ANIMAL P
    JOIN EST_LE_PARENT_DE E ON P.ID_ANIMAL = E.ID_PARENT
    JOIN ESPECE ES ON P.ID_ESPECE = ES.ID_ESPECE
    WHERE E.ID_ENFANT = :id_animal";
        return $this->executeQueryAll($sql, [':id_animal' => $id]);
    }

    /**
     * Récupère les enfants d'un animal
     */
    public function getEnfants($id)
    {
        $sql = "SELECT 
    E.ID_ANIMAL,
    E.NOM_ANIMAL,
    E.POIDS,
    E.DATE_NAISSANCE,
    ES.NOM_ESPECE,
    'Enfant' as LIEN
    FROM ANIMAL E
    JOIN EST_LE_PARENT_DE EP ON E.ID_ANIMAL = EP.ID_ENFANT
    JOIN ESPECE ES ON E.ID_ESPECE = ES.ID_ESPECE
    WHERE EP.ID_PARENT = :id_animal";
        return $this->executeQueryAll($sql, [':id_animal' => $id]);
    }

    /**
     * Récupère le soigneur et remplaçant d'un animal
     */
    public function getSoigneurEtRemplacant($id_animal)
    {
        $query = "SELECT P.ID_PERSONNEL SOIGNEUR, P.ID_REMPLACANT REMPLACANT 
                 FROM Animal A, Personnel P 
                 WHERE A.ID_SOIGNEUR = P.ID_PERSONNEL AND A.ID_ANIMAL = :id_animal";
        return $this->executeQuery($query, [':id_animal' => $id_animal]);
    }

    /**
     * Récupère tous les animaux avec leurs espèces
     */
    public function getAll()
    {
        $query = "SELECT A.*, E.NOM_ESPECE FROM Animal A 
                 LEFT JOIN Espece E ON A.ID_ESPECE = E.ID_ESPECE";
        return $this->executeQueryAll($query);
    }

    /**
     * Récupère les animaux par coordonnées d'enclos
     */
    public function getParCoordonnees($latitude, $longitude)
    {
        $query = "SELECT A.* FROM Animal A 
                 WHERE A.LATITUDE_ENCLOS = :latitude AND A.LONGITUDE_ENCLOS = :longitude";
        return $this->executeQueryAll($query, [
            ':latitude' => $latitude,
            ':longitude' => $longitude
        ]);
    }

    /**
     * Récupère tous les animaux d'un soigneur
     */
    public function getAllSoigneurs($id_soigneur)
    {
        $query = "SELECT A.*, E.NOM_ESPECE FROM Animal A 
                 JOIN Espece E ON A.ID_Espece = E.ID_Espece 
                 WHERE A.ID_Soigneur = :id_soigneur";
        return $this->executeQueryAll($query, [':id_soigneur' => $id_soigneur]);
    }

    /**
     * Récupère tous les animaux d'une zone
     */
    public function getAllParZone($id_zone)
    {
        $query = "SELECT A.*, E.NOM_ESPECE FROM Animal A 
                 LEFT JOIN Espece E ON A.ID_ESPECE = E.ID_ESPECE 
                 WHERE (A.LATITUDE_ENCLOS, A.LONGITUDE_ENCLOS) IN 
                    (SELECT LATITUDE, LONGITUDE FROM Enclos WHERE ID_ZONE = :id_zone)";
        return $this->executeQueryAll($query, [':id_zone' => $id_zone]);
    }

    /**
     * Crée un nouvel animal
     */
    public function creer($data)
    {
        $data['poids'] = str_replace('.', ',', $data['poids']);

        $query = "INSERT INTO Animal (ID_ANIMAL, NOM_ANIMAL, DATE_NAISSANCE, POIDS, REGIME_ALIMENTAIRE, ID_ESPECE, LATITUDE_ENCLOS, LONGITUDE_ENCLOS, ID_SOIGNEUR) 
                 VALUES ((SELECT NVL(MAX(ID_ANIMAL), 0) + 1 FROM Animal), :nom_animal, TO_DATE(:date_naissance, 'YYYY-MM-DD'), :poids, :regime_alimentaire, :id_espece, :latitude_enclos, :longitude_enclos, :id_soigneur)";

        return $this->executeModify($query, [
            ':nom_animal' => $data['nom_animal'],
            ':date_naissance' => $data['date_naissance'],
            ':poids' => $data['poids'],
            ':regime_alimentaire' => $data['regime_alimentaire'],
            ':id_espece' => $data['id_espece'],
            ':latitude_enclos' => $data['latitude_enclos'],
            ':longitude_enclos' => $data['longitude_enclos'],
            ':id_soigneur' => $data['id_soigneur']
        ]);
    }

    /**
     * Met à jour un animal
     */
    public function maj($id, $data)
    {
        // Normaliser le poids
        $data['poids'] = str_replace('.', ',', $data['poids']);

        $query = "UPDATE Animal SET 
                 NOM_ANIMAL = :nom_animal,
                 DATE_NAISSANCE = TO_DATE(:date_naissance, 'YYYY-MM-DD'),
                 POIDS = :poids,
                 REGIME_ALIMENTAIRE = :regime_alimentaire,
                 ID_ESPECE = :id_espece,
                 LATITUDE_ENCLOS = :latitude_enclos,
                 LONGITUDE_ENCLOS = :longitude_enclos
                 WHERE ID_ANIMAL = :id_animal";

        return $this->executeModify($query, [
            ':id_animal' => $id,
            ':nom_animal' => $data['nom_animal'],
            ':date_naissance' => $data['date_naissance'],
            ':poids' => $data['poids'],
            ':regime_alimentaire' => $data['regime_alimentaire'],
            ':id_espece' => $data['id_espece'],
            ':latitude_enclos' => $data['latitude_enclos'],
            ':longitude_enclos' => $data['longitude_enclos']
        ]);
    }

    /**
     * Supprime un animal
     */
    public function suppr($id)
    {
        $query = "DELETE FROM Animal WHERE ID_ANIMAL = :id_animal";
        return $this->executeModify($query, [':id_animal' => $id]);
    }

    /**
     * Recherche d'animaux avec filtres dynamiques
     */
    public function moteurRechercheRecup($searchTerm, $filters = [])
    {
        $sql = "SELECT * FROM ANIMAL WHERE 1=1";
        $params = [];

        if (!empty($searchTerm)) {
            $sql .= " AND (LOWER(NOM_ANIMAL) LIKE LOWER(:searchTerm))";
            $params[':searchTerm'] = "%" . $searchTerm . "%";
        }

        if (!empty($filters['espece'])) {
            $sql .= " AND ID_ESPECE IN (SELECT ID_ESPECE FROM ESPECE WHERE LOWER(NOM_ESPECE) LIKE LOWER(:espece))";
            $params[':espece'] = "%" . $filters['espece'] . "%";
        }

        if (!empty($filters['zone'])) {
            $sql .= " AND EXISTS (SELECT 1 FROM ENCLOS e JOIN ZONE z ON z.ID_ZONE = e.ID_ZONE 
                     WHERE e.LATITUDE = LATITUDE_ENCLOS AND e.LONGITUDE = LONGITUDE_ENCLOS 
                     AND LOWER(z.NOM_ZONE) LIKE LOWER(:zone))";
            $params[':zone'] = "%" . $filters['zone'] . "%";
        }

        if (!empty($filters['regime'])) {
            $sql .= " AND LOWER(REGIME_ALIMENTAIRE) LIKE LOWER(:regime)";
            $params[':regime'] = "%" . $filters['regime'] . "%";
        }

        if (!empty($filters['type_enclos'])) {
            $sql .= " AND (LATITUDE_ENCLOS, LONGITUDE_ENCLOS) IN (SELECT LATITUDE, LONGITUDE FROM ENCLOS WHERE LOWER(TYPE_ENCLOS) LIKE LOWER(:type_enclos))";
            $params[':type_enclos'] = "%" . $filters['type_enclos'] . "%";
        }

        return $this->executeQueryAll($sql, $params);
    }
}
