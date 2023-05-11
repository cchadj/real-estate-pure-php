<?php

namespace App\Model;

use App\Helper\DB;
use  PDO;

require_once __ROOT__ . "/App/database.php";


/**
 * @property Area[] $areas
 * @method static City|null Create(array $record, DB $db = null)
 * @method static City|null Find(int $id, DB $db = null)
 * @method static City|null FindBy(string $column, string $value, int $pdoParamType = PDO::PARAM_STR, ?DB $db = null)
 * @method static City[] All(DB $db = null)
 */
class City extends Model
{
    protected static function getTable(): string
    {
        return "cities";
    }

    protected static function getColumnToPdoParamType(): array
    {
        return [
            "name" => PDO::PARAM_STR
        ];
    }

    protected static function fromRecord(array $record): City
    {
        return new City($record["id"], $record["name"]);
    }

    public int $id;
    public string $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return Area[]
     */
    public function getAreas(DB $db = null): array {
        $db = $db ?? DB::connect();

        $stmt = $db->connection->prepare(
            "
            SELECT areas.*
            FROM real_estate.areas
            JOIN real_estate.cities ON cities.id = areas.city_id
            WHERE cities.id = :id
            "
        );
        $stmt->bindValue(":id", $this->id, PDO::PARAM_INT);
        $stmt->execute();
        $records = $stmt->fetchAll();
        $recordModelInstances = array_map(fn($record): Area => Area::fromRecord($record), $records);
        return $recordModelInstances;
    }
    public function __get(string $name)
    {
        if ($name == "areas") {
            return $this->getAreas();
        }
    }

}