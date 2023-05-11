<?php
require_once __ROOT__ . '/App/View/layout/header.php';
/**
 * @var City[] $cities
 */

use App\Model\City;

?>

<div class="form-container pageContainer">
    <h1>
        Add Area
    </h1>

    <div class="form-with-message">
        <form id="areasCreateForm">
            <div>
                <label for="name"> Name </label>
                <input id="name" type="text" name="name" placeholder="Name...">
            </div>

            <?php
            $label = "City";
            $selectId = "citySelect";
            $name = "city_id";

            $options = [];
            foreach ($cities as $c) {$options[$c->id]   = $c->name;}
            include __ROOT__ . "/App/View/components/dropdown.php"
            ?>

            <input type="submit" value="Add"/>
        </form>

        <p id="banner" class="message hidden"></p>
    </div>
</div>

</div>