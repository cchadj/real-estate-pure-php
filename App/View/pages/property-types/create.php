<?php
/**
 * @var array $cities
 * @var array $areas
 */
?>
<?php require_once __ROOT__ . '/App/View/layout/header.php'; ?>

<div class="form-container pageContainer">
    <h1>
        Add Property Type
    </h1>

    <div class="form-with-message">

        <form id="propertyTypesCreateForm" action="/property-types/create">
            <div>
                <label for="name"> Name </label>
                <input id="name" type="text" name="name" placeholder="Name...">
            </div>
            <input type="submit" value="Add"/>
        </form>

        <p id="banner" class="message hidden"></p>
    </div>
</div>
