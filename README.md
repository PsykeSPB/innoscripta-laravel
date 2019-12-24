## About

This application is solution to Innoscripta GmbH 'Pizza task'.
Here you will find source code of the back-end Laravel application.

[This](https://hidden-lowlands-01519.herokuapp.com/) is the demo of deployed application using [Heroku](https://heroku.com) and [RemoteMySql](https://remotemysql.com/).
Because it is a back-end application mainly, you probably will not find anything interesting here. 

## Deployment
### Local with Docker
The recommended way to test application in the local environment is to build and serve it with Docker.
Prerequisites:
1. [DockerEngine](https://docs.docker.com/install/)
2. [DockerCompose](https://docs.docker.com/compose/install/)

After cloning this prepository copy content of `.env.example` to `.env` file
And fill in database access parameters, such as:
* `DB_HOST`
* `DB_PORT`
* `DB_DATABASE`
* `DB_USERNAME`
* `DB_PASSWORD`

After that run sequence of commands to prepare Laravel application:
```
docker-compose run php composer install
docker-compose run php artisan key:generate
docker-compose run php artisan migrate --seed
docker-compose up
```
This will raise up php dev-server, and application will be available at `http://localhost:8000/`.

### Local native
If you refuse to use Docker, this is the way you could deploy nativly.
Prerequisites:
1. [PHP 7.3](https://www.php.net/manual/en/install.php)
2. [Composer](https://getcomposer.org/download/)

First of all update dependencies using Composer. If you have composer globaly available,
then `cd` into app root directory and simply run:
```
composer install
```

Then copy content of `.env.example` to `.env` file
And fill in database access parameters, such as:
* `DB_HOST`
* `DB_PORT`
* `DB_DATABASE`
* `DB_USERNAME`
* `DB_PASSWORD`

Set your applications data:
```
php artisan key:generate
php artisan migrate --seed
```

To run application you may use php dev-server:
```
php artisan serve --host=0.0.0.0 --port=8000
```
This makes application available at `http://localhost:8000/`.

Otherwise you will have to set up nginx + fpm or Apache to serve you application.
