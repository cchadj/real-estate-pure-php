<?php

namespace App\Controller;

use App\Model\City;

class CityController
{
    public function index(): void {
        $cities = City::AllAssoc();
        require_once __ROOT__ . "/App/View/pages/cities/index.php";
    }

    public function create(): array
    {
        require_once __ROOT__ . "/App/View/pages/cities/create.php";
        return [
            "scripts" => ["/js/form-submission.js"]
        ];
    }
}