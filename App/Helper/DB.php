<?php

namespace App\Helper;

use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;
use PDO;

/**
 * @property  PDO $connection
 * @property  array $databaseSecret
 */
class DB
{
    private PDO|null $connection;
    private array $databaseSecret;

    private function __construct(array $databaseSecret, PDO $connection)
    {
        $this->connection = $connection;
        $this->databaseSecret = $databaseSecret;
    }

    public function __destruct()
    {
        $this->connection = null;
    }

    public static function connect(array $databaseSecret = null): DB
    {
        $databaseSecret = $databaseSecret ?? $_ENV;
        $dsn = 'mysql:host='. $databaseSecret["MYSQL_HOST"] .';dbname='. $databaseSecret["MYSQL_DATABASE"];
        $connection = new PDO(
            $dsn,
            $databaseSecret["MYSQL_USER"],
            $databaseSecret["MYSQL_PASSWORD"]
        );
        return new DB($databaseSecret, $connection);
    }

    public function query(
        #[LanguageLevelTypeAware(['8.0' => 'string'], default: '')] $query,
        #[LanguageLevelTypeAware(['8.0' => 'int|null'], default: '')] $fetchMode = null,
        #[LanguageLevelTypeAware(['8.0' => 'mixed'], default: '')] ...$fetch_mode_args
    ): bool|\PDOStatement
    {
        return $this->connection?->query($query, $fetchMode, ...$fetch_mode_args) ?? false;
    }

    public function __get(string $name)
    {
        if ($name == "connection") {
            return $this->connection;
        }
        elseif ($name == "databaseSecret") {
            return $this->databaseSecret;
        }
    }
}
