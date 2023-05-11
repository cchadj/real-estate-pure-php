<?php require_once __ROOT__ . '/App/View/layout/header.php'; ?>

<div class="pageContainer">
<div class="form-container">
    <h1>
        Add City
    </h1>

    <div class="form-with-message">
        <form id="citiesCreateForm">
            <div>
                <label for="name"> Name </label>
                <input id="name" type="text" name="name" placeholder="Name...">
            </div>
            <input type="submit" value="Add"/>
        </form>

        <p id="banner" class="message hidden"></p>
    </div>
</div>
</div>