# How to run

1. Clone Repo:
```bash
git clone git@github.com:cchadj/real-estate-pure-php.git
cd real-estate-pure-php
```

2. Create .env with this "secret" as content at the root of the repo:
.env
```.env
MYSQL_HOST=database
MYSQL_ROOT_PASSWORD=root
MYSQL_DATABASE=real_estate
MYSQL_USER=root
MYSQL_PASSWORD=root
```

3. Launch containers using docker compose.

From the root of the rerpo do:
```
docker compose up -d               
docker compose exec -it web /bin/bash  
composer dump-autoload -o && php bin/migrate.php && php bin/seed.php
```

Explanation ( Optional ) :

This will create 3 containers, one for MySql ( database ) , one for the web server ( web ), and one for phpmyadmin.
Phpmyadmin was included for my convenience os I can see the state of the database easily during development.

`docker compose up -d` This creates the containers for each service based on `docker-compose.yml`. The `-d` flag is for convenience to run in detached mode so the terminal is given back to you ( otherwise open another terminal window ).

`docker compose exec -it web /bin/bash` Access the just created web server with an interactive terminal.

`composer dump-autoload -o && php bin/migrate.php && php bin/seed.php` 
With `composer dump-autoload -o` we create the optimised autoload files. I used composer solely for loading classes easily.
With `php bin/migrate.php && php bin/seed.php` we run the migrations to create the tables and seed them with some data to have something to dsplay.

4. Access the website at http://localhost:8000/ . Access phpmyadmin at  http://localhost:8080/

# What was implemented
1. a docker compose configuration with MySql database, and a web server for the website along with phpmyadmin. Xdebug was also used to aid development. Phpstorm IDE was used and was really helpful for stepping through code with Xdebug.
2. An ad-hoc pure php MVC architecture was implemented. The Models can be found at App/Model, the controllers at App/Controller, the views at App/View.
3. Ajax was used exstensively to avoid reloading the website when adding and editing.
4. An ad-hoc routing system was implemented in public/index.js for routing the requests to the Controllers.
5. Database migrations and seeders were added as scripts in /bin/
6. User can add Cities, Areas, Property Types, and Properties
7. A simple table is provided for Cities, Areas, Property Types, and Properties
8. A crude CRUD API was implemented for adding and getting Cities, Areas, Property Types and Properties. For Properties, edit and delete is also supported. ( For Areas, Cities, Property Types, edit and delete was not added due to time constraints but the logic would be similar to that of Properties ). Attempted to respond with the right response codes based on the GET, POST, PUT, and DELETE conventions. PUT was not used for replacing Properties because simple php doesn't offer a way for reading multipart form PUT body. POST was used instead for editing a property.
9. When adding Properties, when selecting Cities, ajax is used to fetch the areas of that city to show in the select input.
10. Added validations for duplicates, format of inputs, required fields e.t.c The validations are not complete because of time constraints. On validation error from the server, the user is notified of the reason.
11. Add uploading an image for properties. More than one images not implemented due to time contstraints. Known "bug": Because images where implemented with One to Many relationship ( one property, many images ), on editing an image, the old image is still associated with the property and not deleted. The main photo of the Property can't be changed at the moment.
