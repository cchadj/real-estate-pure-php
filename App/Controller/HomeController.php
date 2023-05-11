<?php

namespace App\Controller;

class HomeController
{
    public function index() {
        require_once __ROOT__ . "/App/View/pages/home.php";
    }
}