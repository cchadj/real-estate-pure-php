<?php

namespace App\Controller;

use \App\Model\PropertyType;

class PropertyTypeController
{
    public function index(): void
    {
        $propertyTypes = PropertyType::AllAssoc();
        require_once __ROOT__ . "/App/View/pages/property-types/index.php";
    }

    public function create(): array
    {
        require_once __ROOT__ . "/App/View/pages/property-types/create.php";
        return [
            "scripts" => ["/js/form-submission.js"]
        ];
    }
}