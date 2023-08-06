# CRUD test task

## Installation

1. ``composer install``
2. ``docker compose up -d``
3. ``cp .env.example .env``
4. ``php jwt-secret.php`` - to generate jwt secret string
5. Fill .env file with data. You can get database connections parameters from docker-compose.yml in db container section
6. ``docker compose exec app php bin/doctrine orm:schema-tool:create
   ``

And you ready to go! Application will be exposed on localhost:8000 by default. I also left database container with open 3306 port if you want to connect directly.

You can check all api calls in postman json collection in project root directory.