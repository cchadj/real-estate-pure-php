<?php

namespace App\Model;

use App\Helper\DB;
use PDO;

/**
 * @property static string $table
 * @property static array<string, int>  $columnToPdoParamType
 */
class Model
{
    protected string $created_at;
    protected string $updated_at;

    protected function __construct(?string $created_at = "", ?string $updated_at = "")
    {
        $this->created_at = $created_at ?? "";
        $this->updated_at = $updated_at ?? "";
    }

    protected static function fromRecord(array $record): Model
    {
        return new Model();
    }

    protected static function getTable(): string
    {
        return "models";
    }

    /**
     * @return array<string, int>
     */
    protected static function getColumnToPdoParamType(): array
    {
        return ["id" => PDO::PARAM_INT];
    }

    /**
     * @return Model[]
     */
    public static function All(DB $db = null): array
    {
        $records = static::AllAssoc($db);
        return array_map(fn($record): Model => static::fromRecord($record), $records);
    }

    public static function AllAssoc(?DB $db = null, int $mode = PDO::FETCH_ASSOC): array
    {
        $db = $db ?? DB::connect();

        $query = "SELECT * FROM real_estate." . static::getTable();
        $stmt = $db->connection->query($query);
        $cities = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $cities;
    }

    public static function Create(
        array $record,
        DB    $db = null
    ): Model|null
    {
        $db = $db ?? DB::connect();

        $column_names = implode(", ", array_keys($record));
        $values_placeholders = implode(", ", array_map(fn($k) => ":{$k}", array_keys($record)));
        $table = static::getTable();
        $query = "INSERT INTO real_estate.{$table} ({$column_names}) VALUES ({$values_placeholders}) ";

        $db->connection->beginTransaction();
        $stmt = $db->connection->prepare($query);

        if (!$stmt) {
            return null;
        }

        foreach ($record as $column => $value) {
            $columnToParamType = static::getColumnToPdoParamType();
            $paramType = $columnToParamType[$column] ?? PDO::PARAM_STR;
            $stmt->bindValue(":{$column}", $value, $paramType);
        }

        $success = $stmt->execute();
        if ($success) {
            $lastId = $db->connection->lastInsertId();
            $createdRecord = static::FindBy("id", $lastId, PDO::PARAM_INT, $db);
            $ret = $createdRecord;
            $db->connection->commit();
        } else {
            $ret = null;
            $db->connection->rollBack();
        }
        return $ret;
    }

    public static function First(DB $db = null): Model|null
    {
        $db = $db ?? DB::connect();

        $table = static::getTable();
        $stmt = $db->query("SELECT * FROM real_estate.{$table} ORDER BY created_at Limit 1");
        $stmt->execute();
        $record = $stmt->fetch(PDO::FETCH_ASSOC);
        return $record ? static::fromRecord($record) : null;
    }

//    public static function Last(?DB $db = null): Model | null
//    {
//        $db = $db ?? DB::connect();
//
//        $stmt = $db->connection->prepare("SELECT * FROM real_estate.{$table} WHERE $id");
//        $stmt->execute();
//        $record = $stmt->fetch(PDO::FETCH_ASSOC);
//        return $record? static::fromRecord($record) : null;
//    }

    public static function Find(
        int $id, DB $db = null
    ): Model|null
    {
        return static::FindBy("id", $id, PDO::PARAM_INT, $db);
    }

    public static function FindByAssoc(
        string $column,
        string $value,
        int    $pdoParamType = PDO::PARAM_STR,
        ?DB    $db = null
    ): array | null
    {
        $db = $db ?? DB::connect();

        $table = static::getTable();
        $query = "SELECT * FROM real_estate.{$table} WHERE {$column} = :value LIMIT 1";
        $stmt = $db->connection->prepare($query);
        $stmt->bindValue(":value", $value, $pdoParamType);
        $stmt->execute();

        $record = $stmt->fetch(PDO::FETCH_ASSOC);
        return $record?: null;
    }

    public static function WhereAssoc(
        string $column,
        string $value,
        int    $pdoParamType = PDO::PARAM_STR,
        ?DB    $db = null
    ): array | null
    {
        $db = $db ?? DB::connect();

        $table = static::getTable();
        $query = "SELECT * FROM real_estate.{$table} WHERE {$column} = :value";
        $stmt = $db->connection->prepare($query);
        $stmt->bindValue(":value", $value, $pdoParamType);
        $stmt->execute();

        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $records?: null;
    }

    /**
     * @return Model[]|null
     */
    public static function Where(
        string $column,
        string $value,
        int    $pdoParamType = PDO::PARAM_STR,
        ?DB    $db = null
    ): ?array
    {
        $records = static::WhereAssoc($column, $value, $pdoParamType, $db);
        return $records ? array_map(fn($r): Model => static::fromRecord($r), $records): null;
    }

    public static function FindBy(
        string $column,
        string $value,
        int    $pdoParamType = PDO::PARAM_STR,
        ?DB    $db = null
    ): ?Model
    {
        $record = static::FindByAssoc($column, $value, $pdoParamType, $db);
        return $record ? static::fromRecord($record) : null;
    }
}