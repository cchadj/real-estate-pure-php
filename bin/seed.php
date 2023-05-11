<?php

define('__ROOT__', dirname(__FILE__, 2));

require_once __ROOT__ . "/vendor/autoload.php";
require_once __ROOT__ . "/bin/migrate.php";

use App\Model\City;
use App\Model\Area;
use App\Model\Property;
use App\Model\PropertyType;

$cityNames = ["Nicosia",  "Limassol", "Larnaca", "Paphos", "Kyrenia"];
$cityToAreas = [
    "Nicosia" => ["Strovolos", "Lakatamia", "Latsia"],
    "Limassol" => ["Germasogeia", "Mesa Geitonia"],
    "Larnaca" => ["Dromolaxia", "Kamares"],
    "Paphos" => ["Yeroskipou", "Peyia",  "Polis Chrysochous"],
    "Kyrenia" => ["Lapethos", "Karavas"]
];
$propertyTypes = [
    "rent",
    "sale",
    "flat"
];

foreach ($cityNames as $cityName) {
    $createdCity = City::Create(["name" => $cityName]);
    foreach ($cityToAreas[$cityName] ?? [] as $areaName) {
        Area::Create(["name" => $areaName, "city_id"=> $createdCity->id]);
    }
}

foreach ($propertyTypes as $propertyTypeName) {
   PropertyType::Create(["name" => $propertyTypeName]);
}

$propertyArea = Area::FindBy("name", "Strovolos");
$propertyCity = City::FindBy("name", "Nicosia");
$propertyType = PropertyType::FindBy("name", "flat");
$nicosiaProperty = Property::Create([
    "name" => "Flat In Nicosia",
    "area_id" => $propertyArea->id,
    "city_id" => $propertyCity->id,
    "property_type_id" => $propertyType->id,
    "price" => 100_000.00,
    "publication_date" => (new DateTime())->format('Y-m-d H:i:s'),
]);

$propertyArea = Area::FindBy("name", "Lapethos");
$propertyCity = City::FindBy("name", "Kyrenia");
$propertyType = PropertyType::FindBy("name", "sale");
$limassolProperty = Property::Create([
    "name" => "Home for sale in Lapethos",
    "area_id" => $propertyArea->id,
    "city_id" => $propertyCity->id,
    "property_type_id" => $propertyType->id,
    "price" => 100.00,
    "publication_date" => (new DateTime())->format('Y-m-d H:i:s'),
]);

$propertyArea = Area::FindBy("name", "Peyia");
$propertyCity = City::FindBy("name", "Paphos");
$propertyType = PropertyType::FindBy("name", "rent");
$limassolProperty = Property::Create([
    "name" => "House for rent in Paphos",
    "area_id" => $propertyArea->id,
    "city_id" => $propertyCity->id,
    "property_type_id" => $propertyType->id,
    "price" => 100.00,
    "publication_date" => (new DateTime())->format('Y-m-d H:i:s'),
]);
