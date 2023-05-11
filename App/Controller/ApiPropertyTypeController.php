<?php

namespace App\Controller;

use App\Model\PropertyType;
use App\Web\ErrorCodes;
use ErrorException;
use JetBrains\PhpStorm\NoReturn;

require_once __ROOT__ . "/App/database.php";

class ApiPropertyTypeController
{
    public function create()
    {
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
            PropertyType::Create(["name" => $name]);

            $response["responseCode"] = ErrorCodes::CREATED;
            $response["message"] = "successfully added " . '"' . $name . '"';
        } catch (\PDOException $e) {
            if ($e->getCode() == "23000") {
                $errorMessage = '"' . $name . '"' . " property type already exists.";
            } else {
                $errorMessage = $e->getMessage();
            }
            $response["responseCode"] = ErrorCodes::CONFLICT;
            $response["message"] = $errorMessage;
        }
        return $response;
    }

    #[NoReturn] private function rerouteAndExit(): void
    {
        header('Location: /properties/create');
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
            throw new ErrorException("Property type can't be empty");
        }

        if (!preg_match('/^[\p{L} .-]+$/', $name)) {
            throw new ErrorException("Invalid property type. Please only use letters and spaces");
        };

        if (strlen($name) > 255) {
            throw new ErrorException("Property type can't be larger than 255 characters");
        }

        return [
            "name" => $name
        ];
    }
}
