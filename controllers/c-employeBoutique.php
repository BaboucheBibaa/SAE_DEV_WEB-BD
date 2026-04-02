<?php

class EmployeeBoutiqueController extends BaseController {
    /**
     * Affiche le tableau de bord de l'espace employé boutique
     *
     * @return void
     */
    public function index(): void {
        $this->requireRole(EMPLOYEE_BOUTIQUE);
        $title = "Espace Employé Boutique - Zoo'land";
        $this->render('employeBoutique/v-index', ['title' => $title]);
    }
}