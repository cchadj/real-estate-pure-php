<?php

function connect_to_database(array $database_secret = null): PDO
{
    $database_secret = $database_secret ?? $_ENV;
    $dsn = 'mysql:host='. $database_secret["MYSQL_HOST"] .';dbname='. $database_secret["MYSQL_DATABASE"];
    return new PDO(
        $dsn,
        $database_secret["MYSQL_USER"],
        $database_secret["MYSQL_PASSWORD"]
    );
}
