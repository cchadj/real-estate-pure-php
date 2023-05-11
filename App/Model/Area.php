<?php

namespace App\Model;

use App\Traits\HasCity;
use App\Helper\DB;
use PDO;

/**
 * @property City|null city
 * @method static Area|null Create(array $record, DB $db = null)
 * @method static Area|null Find(int $id, DB $db = null)
 * @method static Area|null FindBy(string $column, string $value, int $pdoParamType = PDO::PARAM_STR, ?DB $db = null)
 * @method static Area|null Where(string $column, string $value, int $pdoParamType = PDO::PARAM_STR, ?DB $db = null)
 * @method static Area[] All(DB $db = null)
 */
class Area extends Model
{
    use HasCity;

    protected static function getTable(): string { return "areas";}
    protected static function getColumnToPdoParamType(): array {
        return array_merge(parent::getColumnToPdoParamType(), [
            "name" => PDO::PARAM_STR,
            "city_id" => PDO::PARAM_INT,
        ]);
    }

    protected static function fromRecord(array $record): Area
    {
        return new Area(...$record);
    }

    public int $id;
    public int $city_id;
    public string $name;

    public function __construct(int $id, string $name, int $city_id, ?string $created_at="", ?string $updated_at="")
    {
        parent::__construct($created_at, $updated_at);
        $this->id = $id;
        $this->name = $name;
        $this->city_id = $city_id;
    }

    public function __get(string $name)
    {
        if ($name == "city") {
            return $this->getCity();
        }
    }
}
