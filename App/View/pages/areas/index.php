<?php /**
 * @var Area[] $areas;
 */

use App\Model\Area;

$records = array_map(fn($area):array => [
    "id" => $area->id,
    "name" => $area->name,
    "city" => $area->city?->name ?? "N/A"
], $areas);
$columns = ["id" => "id", "name" => "name", "city" => "city"];
$pageTitle = "Areas";
include __ROOT__ . "/App/View/page-templates/table-page.php";
