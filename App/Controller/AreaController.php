<?php

namespace App\Controller;

use App\Model\Area;
use App\Model\City;

class AreaController
{
    public function index(): void {
        $areas = Area::All();
        require_once __ROOT__ . "/App/View/pages/areas/index.php";
    }

    public function create(): array
    {
        $cities = City::All();
        require_once __ROOT__ . "/App/View/pages/areas/create.php";
        return [
            "scripts" => ["/js/form-submission.js"]
        ];
    }
}