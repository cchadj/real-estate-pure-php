<?php

namespace App\Controller;

use App\Model\Area;
use App\Model\City;
use App\Model\Property;
use App\Model\PropertyType;

class PropertyController
{
    public function index(): array
    {
        $properties = Property::All();
        require_once __ROOT__ . "/App/View/pages/properties/index.php";
        return [
            "scripts" => [
                "/js/delete.js",
            ]
        ];
    }

    public function create(): array
    {
        $cities = City::All();
        $areas = Area::All();
        $propertyTypes = PropertyType::All();
        require_once __ROOT__ . "/App/View/pages/properties/create.php";
        return [
            "scripts" => [
                "/js/properties-create.js",
                "/js/form-submission.js",
                "/js/datepicker.js",
                "https://code.jquery.com/ui/1.13.2/jquery-ui.js",
            ]
        ];
    }

    public function edit(): array
    {
        # TODO: validate this to make sure it's in website and handle appropriately
        if (!isset($_GET["id"]) or !is_numeric($_GET["id"])) {
            # TODO: show 404
            return [];
        }
        $id = +$_GET["id"];

        $property = Property::Find($id);
        $cities = City::All();
        $areas = Area::All();
        $propertyTypes = PropertyType::All();
        require_once __ROOT__ . "/App/View/pages/properties/edit.php";
        return [
            "scripts" => [
                "/js/properties-create.js",
                "/js/form-submission.js",
                "/js/datepicker.js",
                "https://code.jquery.com/ui/1.13.2/jquery-ui.js",
            ]
        ];
    }
}