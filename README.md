<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://1874966808.rsc.cdn77.org/_next/static/media/logo.982c008d.svg" width="400" alt="Reservio Logo"></a></p>

## Reservio API task

This repository contains code for the PHP developer task at Reservio company. It is a basic reservation system
supporting user registration, login, and subsequent management of user reservations. The repository includes not only
PHP but also an openapi.json file describing public API endpoints with detailed specifications of expected input and
output data. Additionally, it contains a Dockerfile for easy system deployment, as well as a Makefile with predefined
commands for system startup, shutdown, and testing.

## Technologies

- PHP 8.1
    - Laravel 10
    - PHPUnit
- Mysql 8
- Redis
- Mailpit
- Composer

## Installation

### Using Docker

To launch using Docker the Makefile provides the following commands:

- `make up` builds and starts the system.
- `make down` Stops the system.
- `make test` Builds and starts the system, runs tests, and then stops the system.

The individual services are available at the following locations

- API: http://0.0.0.0
- Redis: localhost:6379
- Mailpit: http://localhost:8025/

### Manual installation

For manual installation, it is necessary to install the required technologies. Further, you need to go through the
following steps:

- `composer install`
- `cp .env.example .env`
- Configure individual services (database, mailing, cache, queue, redis) in .env
- `php artisan key:generate`
- `php artisan migrate`
- `php artisan serve`

After run `php artisan serve` the API will be available at http://127.0.0.1:8000

If asynchronous processing of the queue is set up, it is also necessary to start a worker that processes tasks in the
queue in the background.

- `php artisan queue:work`

## Tests

To run tests, you can use `make test` in the case of using Docker or `php artisan test` after the overall system setup.
Tests use separate test database in Mysql. Each test use `RefreshDatabase` trait to reset the database before each test.

Before running tests, it is necessary to set the test database in `phpunit.xml` env `DB_DATABASE` in case of manual
installation.
Don't use the same database as for the system data otherwise the data will be lost.

## API documentation

All endpoints are documented in the `openapi.json` file.

Available endpoints are:

- `POST api/auth/register` - register new user
- `POST api/auth/login` - login user, returns personal token
- `POST api/auth/logout/current` - logout user from current device
- `POST api/auth/logout/all` - logout user from all devices


- `GET api/auth/me` - get auth user details


- `GET api/reservations` - get all auth user reservations, some filters and sorting are available
- `GET api/reservations/{id}` - get auth user reservation by id
- `POST api/reservations` - create new reservation for auth user
- `PUT api/reservations/{id}` - update auth user reservation by id
- `DELETE api/reservations/{id}` - delete auth user reservation by id

## Task requirements

### Programming language

The programming language used is PHP 8.1, and the framework is Laravel.

### Database design

The system uses MySQL 8 as the database. Migrations are available in database/migrations. The schema includes tables for
recording user data `users`, login tokens `personal_access_tokens` and reservations `reservations`. Additionally, there
are system tables, such as the table to maintain migration statuses `migrations` or the `jobs` table used to store jobs
in
case of enabled asynchronous processing through queues.

System use two databases. One for system data and the second for testing. In case of manual instalation database for
system data must be set in `.env`, testing database must be set in `phpunit.xml` to env `DB_DATABASE`.

### API Development

The system implements an API through which communication is possible. A detailed list of endpoints is provided in the
`openapi.json` file. Some endpoints can only be accessed after successful authentication.

The system generally processes individual endpoints in separate invokable controllers for separation of logic.

### Testing

Tests utilize PHPUnit. Each test file corresponds to a specific controller, which tests various scenarios. The primary
focus is on testing success cases.

To run tests, you can use `make test` in the case of using Docker or `php artisan test` after the overall system setup.
For the correct execution of tests in the case of manual installation, it is necessary to set the required database
in `phpunit.xml` env `DB_DATABASE`.

### Version control

The project uses Git with a history of code modifications.

### Optional - Basic authentication

The system implements basic authentication using Laravel Sanctum. Specifically, it uses it for the login of a specific
user through the `api/auth/login` endpoint. Upon successful login, a personal token (Bearer) is returned, which must be
used when calling secure endpoints in the `Authorization` header. The token can be invalidated by calling
`api/auth/logout/current` to log out the current device or `api/auth/logout/all` to log out from all devices.

### Optional - Docker

In the project, there is a Dockerfile, respectively Docker-compose, based on Laravel Sail and slightly modified for the
project's needs. To start the system using Docker, you can run `make up`, and to stop it, you can use `make down`.
Alternatively, for running tests, you can execute `make test`.

### Optional - Asynchronous processing

The project uses asynchronous operations (if enabled in .env, `QUEUE_CONNECTION=database`) for sending email
notifications regarding the creation of
a new reservation `POST api/reservations/` and the cancellation of a reservation `DELETE /api/reservations/{id}` to the
specific user who owns the reservation. Asynchronous
processing is done using the native Laravel Queue solution, not RabbitMQ.

It is necessary to have a running worker to process individual tasks in the queue `php artisan queue:work`. When started
using Docker the worker is automatically launched in the background.

### Optional - Redis

The system uses Redis for data caching (if enabled in .env `CACHE_DRIVER=redis` and a connection to the Redis server is
configured),
specifically caching reservation details `GET api/reservations/{id}`. Cache is invalidated when the reservation is
updated `PUT /api/reservations/{id}` or canceled `DELETE /api/reservations/{id}`.

### Optional - Rate limiting

The project uses native throttle solutions to limit the number of requests. By default, a maximum of 60 requests per
minute is allowed. Login is restricted to 3 requests per minute. In case of exceeding these limits a `429 Too many
requests` response is returned and the user is blocked for 1 minute.
