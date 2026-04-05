<?php
class Fonction extends BaseModel
{

    /**
     * Récupère tous les rôles (pour les listes déroulantes)
     */
    public function getAll()
    {
        $sql = 'SELECT ID_FONCTION, NOM_FONCTION FROM FONCTION';
        return $this->executeQueryAll($sql);
    }

    /**
     * Récupère l'ID d'un rôle par son nom
     */
    public function getIDParNom($nom_fonction)
    {
        $sql = "SELECT ID_FONCTION FROM FONCTION WHERE NOM_FONCTION = :nom_fonction";
        return $this->executeQuery($sql, [':nom_fonction' => $nom_fonction]);
    }

    /**
     * Récupère le nom d'un rôle par son ID
     */
    public function getNomFonctionParID($id_fonction)
    {
        $sql = "SELECT NOM_FONCTION FROM FONCTION WHERE ID_FONCTION = :id_fonction";
        $result = $this->executeQuery($sql, [':id_fonction' => $id_fonction]);

        // Si aucun résultat, retourner un tableau vide pour éviter les erreurs
        return $result ? $result : ['NOM_FONCTION' => ''];
    }
}
