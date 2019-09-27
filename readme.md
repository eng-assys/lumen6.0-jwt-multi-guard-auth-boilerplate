# Lumen Authentication Boilerplate

A simple Lumen 6.0 boilerplate with JWT Authentication out of the box

## Dependencies
* Lumen 6.0
* **chuckrincon/lumen-config-discover:** loads automatically config files placed in /config directory
* **tymon/jwt-auth:** allows use JWT authentication in Laravel/Lumen frameworks

## Instalation
* Copy `.env.example` file to `.env` (set the variables according your project)  
* At the root directory, run ``` composer install ```
* Generate JWT secret key ``` php artisan jwt:secret ```
* Run migrations: ``` php artisan migrate ```

## Running Project

* ```php -S localhost:8000 -t public```

## Postman Collection

* A postman collection, with the existent endpoints, can be found at the location `/docs/AuthApp.postman_collection.json`

### Available user's Endpoints [api/v1/users]
* /register - Register a new user
* /login - Login into the system and get the JWT token
* /logout - Logout of the system and invalidate given JWT token
* /refresh - Refresh given JWT token and get a new one

* /users - Get all registed users
* /users/me - Get the Token's Owner User
* /users/{id} - Get a user by its ID

### Available application's Endpoints [api/v1/applications]
* /register - Register a new application
* /login - Login into the system and get the JWT token
* /logout - Logout of the system and invalidate given JWT token
* /refresh - Refresh given JWT token and get a new one

* /applications - Get all registed applications
* /applications/current - Get the Token's Owner Application
* /applications/{id} - Get a user by its ID
