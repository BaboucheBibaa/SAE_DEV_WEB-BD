<?php

class EmployeeBoutique extends BaseController {
    public function index() {
        $this->requireRole(EMPLOYEE_BOUTIQUE);
        $title = "Espace Employé Boutique - Zoo'land";
        $this->render('employeBoutique/v-index', ['title' => $title]);
    }
}