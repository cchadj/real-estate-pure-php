<?php require_once __ROOT__ . '/App/View/layout/header.php'; ?>

<div class="form-container">
    <h1>
        Add City
    </h1>

    <div class="form-with-message">
        <form
            id="create-city-form"
            action="/cities/"
            method="post"
        >
            <div>
                <label for="name"> Name </label>
                <input id="name" type="text" name="name" placeholder="Name...">
            </div>
            <input type="submit" value="Add"/>
        </form>

        <?php
            if (isset($_SESSION["success_message"])) {
                echo "<p class='message success'>" . $_SESSION["success_message"] . "</p>";
                unset($_SESSION["success_message"]);
            }
            if (isset($_SESSION["error_message"])) {
                echo "<p class='message error'>" . $_SESSION["error_message"] . "</p>";
                unset($_SESSION["error_message"]);
            }
        ?>
    </div>
</div>
