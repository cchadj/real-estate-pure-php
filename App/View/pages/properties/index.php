<?php /**
 * @var Property[] $properties
 */

use App\Model\Property;

$records = array_map(fn($p): array => [
    "id" => $p->id,
    "name" => $p->name,
    "price" => $p->priceDisplay,
    "city" => $p->city?->name ?? "N/A",
    "area" => $p->area?->name ?? "N/A",
    "type" => $p->propertyType?->name ?? "N/A",
    "publication_date" => $p->publicationDate,
    "image" => $p->mainPhoto?->path ?? "/default-property.png",
    "edit" => "
        <a href='/properties/edit?id={$p->id}'>Edit</a>
    ",
    "delete" => <<<HEREDOC
        <a class="deleteButton" href='#' data-property-name="{$p->name}" data-property-id="{$p->id}" '>Delete</a>
    HEREDOC,
], $properties);
$columns = [
    "id" => "id",
    "name" => "name",
    "price" => "price ( € )",
    "city" => "city",
    "area" => "area",
    "type" => "type",
    "publication_date" => "Publication Date",
    "image" => "Main Photo",
    "edit" => "EDIT",
    "delete" => "DELETE"
];
$pageTitle = "Properties";
include __ROOT__ . "/App/View/page-templates/table-page.php";
