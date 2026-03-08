<?php 


class ProfilAnimalController extends BaseController {

    public function profilAnimal($id) {
        if ($id === null) {
            $this->redirectWithMessage('home', 'Animal non trouvé.', 'error');
        }

        $animal = Animal::recupParId($id);
        if (!$animal) {
            $this->redirectWithMessage('home', 'Animal non trouvé.', 'error');
        }
        $nourriture = HistoriqueSoins::recupNourritureParAnimal($id);
        $soins = HistoriqueSoins::recupSoinsParAnimal($id);
        $title = "Profil de {$animal['NOM_ANIMAL']} - Zoo'land";
        $this->render('animal/v-profil', ['title' => $title, 'animal' => $animal, 'nourriture' => $nourriture, 'soins' => $soins]);
    }
}