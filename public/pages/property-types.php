<div>
    <h1>
        Property Types
    </h1>

    <form id="create-property-type-form" method="post">
        <h2>Create</h2>

        <?php if (isset($_GET['error'])) { ?>

            <p class="error"><?php echo $_GET['error']; ?></p>

        <?php } ?>

        <label>
            User Name
            <input type="text" name="uname" placeholder="User Name">
        </label>

        <label>
            Password
            <input type="password" name="password" placeholder="Password">
        </label>

        <button type="submit">Login</button>
    </form>
</div>
