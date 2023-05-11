<div>
    <h1>
        Add Property Type
    </h1>

    <div class="form-with-message">
        <form
            id="add-form add-city-form"
            action="/controllers/add-city.php"
            method="post"
        >
            <div>
                <label for="city"> City </label>
                <input id="city" type="text" name="name" placeholder="City...">
            </div>
            <input type="submit" value="Add City"/>
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
