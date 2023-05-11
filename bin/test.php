<?php

define('__ROOT__', dirname(__FILE__, 2));

require_once __ROOT__ . "/vendor/autoload.php";
require_once __ROOT__ . "/bin/migrate.php";

use App\Model\City;
use App\Model\Area;
use App\Model\Property;
use App\Model\PropertyType;

//$createdCity = City::Create(["name" => "Larnaca"]);
//print_r($createdCity);
//$limassolCity = City::Create(["name" => "Limassol"]);
//print_r($limassolCity);
//$createdArea = Area::Create(["name" => "Dromolaxia", "city_id" => $createdCity->id]);
//$createdPropertyType = PropertyType::Create(["name" => "rent"]);
//
//$city = City::Find(1);
//$area = Area::Find(1);
//$propertyType = PropertyType::Find(1);
//
//$foundCity = City::FindBy("name", "Limassol");
//assert($foundCity->id === $limassolCity->id);
//
//echo "\n\n\n";
//print_r($foundCity->id );
//print_r($limassolCity->id );
//print_r($limassolCity->name );
//print_r($createdCity->id );
//
//$createdProperty = Property::Create([
//    "name" => "Property Title",
//    "area_id" => $area->id,
//    "city_id" => $city->id,
//    "property_type_id" => $propertyType->id,
//    "price" => 100_000.00,
//    "publication_date" => (new DateTime())->format('Y-m-d H:i:s'),
//]);
//print_r($createdProperty);

$date = "10/28/2021";
$dateTime = DateTime::createFromFormat("Y-m-d", $date );
