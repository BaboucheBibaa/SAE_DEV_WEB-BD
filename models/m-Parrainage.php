<?php

class Parrainage extends BaseModel
{
    public function getAll()
    {
        //Récupère tous les parrainages
        $sql = "SELECT ep.*, V.NOM_Visiteur, A.NOM_Animal FROM Animal A, Visiteur V, Est_Parraine ep WHERE ep.ID_Visiteur = V.ID_Visiteur AND ep.ID_ANIMAL = A.ID_Animal ORDER BY ep.ID_ANIMAL, ep.ID_Visiteur";
        return $this->executeQueryAll($sql);
    }

    public function getParAnimal($id_animal)
    {
        $sql = "SELECT V.ID_Visiteur, V.NOM_Visiteur,ep.LIBELLE LIBELLE FROM Visiteur V, Est_Parraine ep WHERE ep.ID_Visiteur = V.ID_Visiteur AND ep.ID_ANIMAL = :id_animal";
        return $this->executeQueryAll($sql, [':id_animal' => $id_animal]);
    }

    public function getAllVisiteurs()
    {
        $sql = "SELECT * FROM Visiteur ORDER BY NOM_Visiteur";
        return $this->executeQueryAll($sql);
    }

    public function getLibelle()
    {
        $sql = "SELECT DISTINCT LIBELLE FROM Est_Parraine";
        return $this->executeQueryAll($sql);
    }

    public function creer($data)
    {
        $sql = "INSERT INTO Est_Parraine (ID_Animal, ID_Visiteur, Libelle) VALUES (:id_animal, :id_visiteur, :libelle)";
        return $this->executeModify($sql, [
            ':id_animal' => $data['id_animal'],
            ':id_visiteur' => $data['id_visiteur'],
            ':libelle' => $data['libelle']
        ]);
    }

    public function suppr($id_animal, $id_visiteur)
    {
        //Supprime un parrainage entre un animal et un visiteur 
        $sql = "DELETE FROM Est_Parraine WHERE ID_Animal = :id_animal AND ID_Visiteur = :id_visiteur";
        return $this->executeModify($sql, [
            ':id_animal' => $id_animal,
            ':id_visiteur' => $id_visiteur
        ]);
    }
}