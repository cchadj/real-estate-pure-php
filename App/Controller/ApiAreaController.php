<?php

namespace App\Controller;

use App\Model\Area;
use App\Model\City;
use PDO;
use App\Web\ErrorCodes;
use ErrorException;
use JetBrains\PhpStorm\NoReturn;
use const http\Client\Curl\Versions\ARES;

require_once __ROOT__ . "/App/database.php";

class ApiAreaController
{
    public function index(): array
    {
        $cityId = $_GET["city"] ?? null;
        if ($cityId) {
           $areas = Area::Where("city_id", $cityId, PDO::PARAM_INT) ?? [];
        }
        else {
            $areas = Area::All();
        }
        $areasAssoc = array_map(fn($a): array => [
            "id" => $a->id,
            "name" => $a->name,
            "city" => $a->city?->name ?? "N/A",
        ], $areas);
        return [
            "responseCode" => ErrorCodes::OK,
            "data" => $areasAssoc,
        ];
    }

    public function create(): array
    {
        $response = [];
        try {
            $input = $this->validateInput();
        } catch (ErrorException $e) {
            $errorMessage = $e->getMessage();

            $response["responseCode"] = ErrorCodes::BAD_REQUEST;
            $response["message"] = $errorMessage;
            return $response;
        }

        try {
            $name = $input["name"];
            Area::Create([
                "name" => $input["name"],
                "city_id" => $input["city_id"],
            ]);
            $response["responseCode"] = ErrorCodes::CREATED;
            $response["message"] = "successfully added " . '"' . $name . '"';
        } catch (\PDOException $e) {
            if ($e->getCode() == "23000") {
                $errorMessage = '"' . $name . '"' . " area already exists.";
            } else {
                $errorMessage = $e->getMessage();
            }
            $response["responseCode"] = ErrorCodes::CONFLICT;
            $response["message"] = $errorMessage;
        }
        catch (\Exception $e) {
            $response["responseCode"] = ErrorCodes::CONFLICT;
            $response["message"] = $e->getMessage();
        }
        return $response;
    }

    #[NoReturn] private function rerouteAndExit(): void
    {
        header('Location: /areas/create');
        die();
    }

    /**
     * @throws ErrorException
     */
    private function validateInput(): array
    {
        if (isset($_POST["name"]) && trim($_POST["name"]) != "") {
            $name = trim($_POST["name"]);
        } else {
            throw new ErrorException("Area name can't be empty");
        }

        if (isset($_POST["city_id"]) && trim($_POST["city_id"]) != "") {
            $cityId = trim($_POST["city_id"]);
        } else {
            throw new ErrorException("City can't be empty");
        }

        if (!preg_match('/^[\p{L}\p{N} .-]+$/', $name)) {
            throw new ErrorException("Invalid property type. Please only use letters, numbers, and spaces");
        };

        if (strlen($name) > 255) {
            throw new ErrorException("Property type can't be larger than 255 characters");
        }

        if (!is_numeric($cityId)) {
            throw new ErrorException("Invalid city id. Must be numeric");
        };

        $cityToAssociate = City::Find($cityId);
        if (is_null($cityToAssociate)) {
            throw new ErrorException("City with id " . $cityId . " not found");
        }

        return [
            "name" => $name,
            "city_id" => $cityToAssociate->id,
        ];
    }
}
