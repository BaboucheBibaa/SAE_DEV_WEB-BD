<?php

class EmployeeBoutique extends BaseController {

    public function index() {
        $title = "Espace Employé Boutique - Zoo'land";
        $this->render('employeBoutique/v-index', ['title' => $title]);
    }
}