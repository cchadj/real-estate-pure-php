<?php
/**
 * @var City[] $cities
 * @var Area[] $areas
 * @var PropertyType[] $propertyTypes
 */

use App\Model\Area;
use App\Model\City;
use App\Model\PropertyType;

require_once __ROOT__ . '/App/View/layout/header.php'; ?>

<div class="form-container pageContainer">
    <h1>
        Add Property
    </h1>

    <div class="form-with-message">
        <form id="propertiesCreateForm" enctype="multipart/form-data">
            <div>
                <label for="name"> Name </label>
                <input id="name" type="text" name="name" placeholder="Name..." required>
            </div>

            <div>
                <label for="price"> Price ( € ) </label>
                <input class="priceInput" step="0.01" id="price" type="number" name="price" placeholder="Price..." required>
            </div>

            <?php
            $label = "Type";
            $selectId = "propertyTypeSelect";
            $name = "property_type_id";
            $required = true;
            $options = [];
            foreach ($propertyTypes as $p) { $options[$p->id] = $p->name; }
            include __ROOT__ . "/App/View/components/dropdown.php"
            ?>
            <?php
            $label = "City";
            $selectId = "citySelect";
            $name = "city_id";
            $required = true;
            $options = [];
            foreach ($cities as $c) {$options[$c->id]   = $c->name;}
            include __ROOT__ . "/App/View/components/dropdown.php"
            ?>
            <?php
            $label = "Area";
            $selectId = "areaSelect";
            $name = "area_id";
            $required = true;
            $options = [];
            foreach ($areas as $a) {$options[$a->id]   = $a->name;}
            include __ROOT__ . "/App/View/components/dropdown.php"
            ?>

            <div>
                <label for="datepicker"> Published Date </label>
                <input type="text" id="datepicker" name="publication_date" value="<?= (new DateTime())->format("d/m/Y") ?>" required>
            </div>

            <div>
                <label for="file"> Image </label>
                <input type="file" id="file" name="image" accept="image/*"  required>
            </div>

            <input type="submit" value="Add"/>
        </form>

        <p id="banner" class="message hidden"></p>
    </div>
</div>
