<?php

namespace App\Controller;

use ErrorException;
use App\Model\City;
use JetBrains\PhpStorm\NoReturn;
use App\Web\ErrorCodes;

class ApiCitiesController
{
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

        $name = $input["name"];
        try {
            City::Create(["name" => $name]);
            $response["responseCode"] = ErrorCodes::CREATED;
            $response["message"] = "successfully added " . '"' . $name . '"';
        }
        catch (\PDOException $e){
            if ($e->getCode() == '23000') {
                $errorMessage = '"'. $name . '"' ." city already exists.";
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
        header('Location: /cities/create');
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
            throw new ErrorException("City name can't be empty");
        }

        if (!preg_match('/^[\p{L} .-]+$/', $name)) {
            throw new ErrorException("Invalid city name. Please only use letters and spaces");
        };

        if (strlen($name) > 255) {
            throw new ErrorException("City name can't be larger than 255 characters");
        }

        return [
            "name" => $name
        ];
    }
}
