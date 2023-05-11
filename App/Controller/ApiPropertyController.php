<?php

namespace App\Controller;

use App\Model\Area;
use App\Model\City;
use App\Model\Image;
use App\Model\Property;
use App\Model\PropertyType;
use DateTime;
use App\Web\ErrorCodes;
use ErrorException;
use JetBrains\PhpStorm\NoReturn;

require_once __ROOT__ . "/App/database.php";

class ApiPropertyController
{
    public function delete() {
        // TODO: validate id
        $id = $_GET["id"];

        $deleted = Property::Find($id)?->delete();
        // TODO: return appropriate response, and message
        return [
            "responseCode" => ErrorCodes::OK,
            "message" => "Deleted property $id"
        ];
    }

    public function create()
    {
        // this is also used for edit because php doesn't offer a way to parse multipart PUT data
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

            if (isset($input["id"])) {
                $isCreate = false;
                $id = $input["id"];
                $createdProperty  = Property::Find($id);
                $createdProperty->replace(
                    [
                        "name" => $input["name"],
                        "property_type_id" => $input["property_type_id"],
                        "city_id" => $input["city_id"],
                        "area_id" => $input["area_id"],
                        "price" => $input["price"],
                        "publication_date" => $input["publication_date"],
                        "description" => $input["description"]?? "",
                    ]
                );
            }
            else {
                $isCreate = true;
                $createdProperty = Property::Create([
                    "name" => $input["name"],
                    "property_type_id" => $input["property_type_id"],
                    "city_id" => $input["city_id"],
                    "area_id" => $input["area_id"],
                    "price" => $input["price"],
                    "publication_date" => $input["publication_date"],
                ]);
            }

            $file = $input["image"];
            $uploadDir = "images/{$createdProperty->id}/";
            $path = $uploadDir . uniqid() . "-" . $file["name"];
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            else {
                chmod($uploadDir, 0755);
            }
            $couldMove = move_uploaded_file($file['tmp_name'], $path);
            # here I should remove the old image
            Image::Create([
                    "name" => $file["name"],
//                    "type" => $file["type"],
//                    "size" => $file["size"],
                    "path" => "/" . $path,
                    "property_id" => $createdProperty->id
                ]
            );

            $response["responseCode"] = ErrorCodes::CREATED;
            $createdAdded = $isCreate ? "added":"edited";
            $response["message"] = "successfully $createdAdded " . '"' . $name . '"';
        } catch (\PDOException $e) {
            if ($e->getCode() == "23000") {
                $errorMessage = '"' . $name . '"' . " property type already exists.";
            } else {
                $errorMessage = $e->getMessage();
            }
            $response["responseCode"] = ErrorCodes::CONFLICT;
            $response["message"] = $errorMessage;
        } catch (\TypeError $e) {
            $response["responseCode"] = ErrorCodes::BAD_REQUEST;
            $response["message"] = $e->getMessage();
        }
        return $response;
    }

    public function replace(): array {
        # normally this should be used for PUT requests but I can't parse the put multipart body ( php doesn't have a build in way to do that)
        # instead I use the create method and if property id is set then I replace the existing instead of creating new
        return [];
    }

    #[NoReturn] private function rerouteAndExit(): void
    {
        header('Location: /create-property-type');
        die();
    }

    /**
     * @throws ErrorException
     */
    private function validateInput(array $input = null): array
    {
        $input = $input ?? array_merge($_POST, $_FILES);
        $input = $this->requiredValidationString($input, "name", "Property Name");
        $input = $this->onlyLettersValidation($input, "name", "Property Name");
        $input = $this->stringSizeValidation($input, "name", "Property Name");

        $input = $this->requiredValidationString($input, "price", "Price");
        $input = $this->mustBeNumberValidation($input, "price", "Price");

        $input = $this->requiredValidationString($input, "publication_date", "Publication Date");
        $input = $this->dateValidation($input, "publication_date", "Publication Date");
//        $input = $this->mustBeNumberValidation($input, "publication_date", "Price");


        $input = $this->requiredValidationString($input, "property_type_id", "Property Type");
        $input = $this->mustBeNumberValidation($input, "property_type_id", "Property Type");
        $input = $this->mustExistInDatabaseValidation($input, "property_type_id", "Property Type", PropertyType::class);

        $input = $this->requiredValidationString($input, "city_id", "City");
        $input = $this->mustBeNumberValidation($input, "city_id", "City");
        $input = $this->mustExistInDatabaseValidation($input, "city_id", "City", City::class);

        $input = $this->requiredValidationString($input, "area_id", "Area");
        $input = $this->mustBeNumberValidation($input, "area_id", "Area");
        $input = $this->mustExistInDatabaseValidation($input, "area_id", "Area", Area::class);

        if (isset($input["id"])) {
            $input = $this->mustBeNumberValidation($input, "id", "Property id");
            $input = $this->mustExistInDatabaseValidation($input, "id", "Property", Property::class);
        }

        $input = $this->requiredValidation($input, "image", "Image");
        if (!empty($input['image']['name'])) {
            $file = $input['image'];

            $this->requiredValidationString($file, "name", "File name");
            $this->requiredValidationString($file, "tmp_name", "File Temporary path");
            $this->requiredValidationString($file, "size", "File size");

            $fileError = $file['error'];
            if ($fileError !== UPLOAD_ERR_OK) {
                throw new ErrorException("Error uploading image");
            }
        } else {
            throw new ErrorException("Problem uploading image");
        }

        return $input;
    }

    private function mustBeNumberValidation(
        array  $input,
        string $property,
        string $propertyName,
    )
    {
        if (is_numeric(trim($input[$property]))) {
            $input[$property] = trim($input[$property]);
        } else {
            throw new ErrorException("$propertyName should be a number.");
        }
        return $input;
    }

    private function mustExistInDatabaseValidation(
        array  $input,
        string $property,
        string $propertyName,
        string $modelClass,
    )
    {
        $id = $input[$property];

        $cantBeFound = is_null($modelClass::Find($id));
        if ($cantBeFound) {
            throw new ErrorException("$propertyName can't be found");
        }
        return $input;
    }

    private function requiredValidationString(array $input, string $property, string $propertyName): array
    {
        if (isset($input[$property]) && trim($input[$property]) != "") {
            $input[$property] = trim($input[$property]);
        } else {
            throw new ErrorException("$propertyName can't be empty");
        }
        return $input;
    }

    private function requiredValidation(array $input, string $property, string $propertyName): array
    {
        if (!isset($input[$property])) {
            throw new ErrorException("$propertyName can't be empty");
        }
        return $input;
    }

    private function onlyLettersValidation(array $input, string $property, string $propertyName): array
    {
        if (!preg_match('/^[\p{L}\p{N} .-]+$/', $input[$property])) {
            throw new ErrorException("Invalid {$propertyName}. Please only use letters, numbers, and spaces");
        };
        return $input;
    }

    private function stringSizeValidation(array $input, string $property, string $propertyName, ?int $size = 255,): array
    {
        if (strlen($input[$property]) >= $size) {
            throw new ErrorException("Invalid {$propertyName}. Please only use letters, numbers, and spaces");
        }
        return $input;
    }

    private function dateValidation(array $input, string $property, string $propertyName, $format = "d/m/Y"): array
    {
        $date = $input[$property];
        if (!$this->isValidDate($date, $format)) {
            throw new ErrorException("Invalid {$propertyName}. Please make sure date is correct and has {$format} format.");
        }
        $date = DateTime::createFromFormat($format, $date)->format("Y-m-d");
        $input[$property] = $date;
        return $input;
    }

    private function isValidDate(string $dateString, string $format = "d/m/Y"): bool
    {
        $date = DateTime::createFromFormat($format, $dateString);

        if ($date && $date->format($format) === $dateString) {
            $day = $date->format('d');
            $month = $date->format('m');
            $year = $date->format('Y');

            if (checkdate($month, $day, $year)) {
                return true;
            }
        }

        return false;
    }
}
