<?php

define('__ROOT__', dirname(__FILE__, 2));

$mysql_host = "database";
$mysql_database = "real_estate";
$mysql_user = "root";
$mysql_password = "root";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database);

if ($connection->connect_errno) {
    die("Failed to connect to MySQL: " . $connection->connect_error);
}

$migration_dir = __ROOT__ . "/database/migrations/";
$file_names = scandir($migration_dir);
sort($file_names);
foreach ($file_names as $file_name) {
    if ($file_name === "." or $file_name === "..") continue;
    echo $file_name . "\n";

    $query = file_get_contents($migration_dir . $file_name);
    echo $query . "\n";

    $connection->multi_query($query);
    do {
        $connection->use_result();
        if ($connection->error) {
            die($connection->error);
        }
        if ($connection->more_results()) {
            printf("-----------------\n");
        }
    } while ($connection->next_result());
}

$connection->close();
