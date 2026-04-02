<?php
class Comptable extends BaseModel
{
    /**
     * Récupère les données CA des boutiques
     * @return array|null Tableau avec les données de CA par boutique
     */
    public function getBoutiques()
    {
        $sql = "SELECT * FROM V_COMPTABLE_BOUTIQUES ORDER BY NOM_BOUTIQUE";
        return $this->executeQueryAll($sql);
    }

    /**
     * Récupère les données de réparations par zone
     * @return array|null Tableau avec les coûts moyens de réparation par zone
     */
    public function getZones()
    {
        $sql = "SELECT * FROM V_COMPTABLE_ZONES ORDER BY NOM_ZONE";
        return $this->executeQueryAll($sql);
    }

    /**
     * Récupère le résumé de la masse salariale
     * @return array|null Tableau avec les données de masse salariale
     */
    public function getEmployes()
    {
        $sql = "SELECT * FROM V_COMPTABLE_EMPLOYES";
        return $this->executeQuery($sql);
    }
}
