<div>
    <h1>
        Add Property Type
    </h1>

    <div class="form-with-message">
        <form
            id="add-property-type-form"
            action="/controllers/add-property-type.php"
            method="post"
        >
            <?php if (isset($_GET['error'])) { ?>

                <p class="error"><?php echo $_GET['error']; ?></p>

            <?php } ?>

            <div>
                <label for="type"> Property Type </label>
                <input id="type" type="text" name="name" placeholder="Type...">
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
