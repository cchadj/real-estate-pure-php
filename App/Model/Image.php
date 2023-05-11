<?php

namespace App\Model;

use App\Helper\DB;
use PDO;

/**
 * @method static Image|null Create(array $record, DB $db = null)
 * @method static Image|null Find(int $id, DB $db = null)
 * @method static Image|null FindBy(string $column, string $value, int    $pdoParamType = PDO::PARAM_STR, ?DB    $db = null)
 * @method static Image[] All(DB $db = null)
 */
class Image extends Model
{
    protected static function getTable(): string
    {
        return "property_images";
    }

    protected static function getColumnToPdoParamType(): array
    {
        return array_merge(parent::getColumnToPdoParamType(), [
            "name" => PDO::PARAM_STR,
            "property_id" => PDO::PARAM_INT,
            "description" => PDO::PARAM_STR,
        ]);
    }

    protected static function fromRecord(array $record): Image
    {
        return new Image(...$record);
    }

    public int $id;
    public string $name;
    public int $property_id;
    public string $description;
    public string $path;

    public function __construct(
        int $id,
        string $name,
        int $property_id,
        string $path,
        ?string $description="",
        ?string $created_at = "",
        ?string $updated_at = "",
    )
    {
        parent::__construct($created_at, $updated_at);
        $this->id = $id;
        $this->name = $name;
        $this->path = $path;
        $this->property_id = $property_id;
        $this->description = $description ?? "";
    }
}
