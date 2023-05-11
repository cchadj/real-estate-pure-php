<?php /**
 * @var array $records
 * @var array $columns
 * @var string $pageTitle
 */
?>

<h1><?php echo $pageTitle?></h1>

<div class="tableContainer">
<table>
    <thead>
        <tr>
            <?php foreach ($columns as $_ => $columnDisplayName): ?>
                <th><?= $columnDisplayName ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($records as $record): ?>
            <tr id="<?=$record["id"]?>">
                <?php
                    foreach ($columns as $columnDatabaseName => $columnDisplayName) {
                        if ($columnDatabaseName !== "image") {
                            echo "<td>{$record[$columnDatabaseName]}</td>";
                        }
                        else {
                            echo "<td>
                            <img class='tableImage' src='{$record[$columnDatabaseName]}' alt='{$columnDisplayName}'>
                            </td>";
                        }
                    }
                ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</div>