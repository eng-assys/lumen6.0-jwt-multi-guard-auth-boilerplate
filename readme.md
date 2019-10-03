# Lumen Multi Guard JWT Authentication Boilerplate

A simple Lumen 6.0 boilerplate with JWT Multi Guard Authentication out of the box

## Dependencies
* Lumen 6.0
* **chuckrincon/lumen-config-discover:** Allow load automatically config files placed in /config directory
* **tymon/jwt-auth:** Allow use JWT authentication in Laravel/Lumen frameworks
* **spatie/laravel-permission:** Associate users with roles and permissions

## Instalation
* Copy `.env.example` file to `.env` (set the variables according your project)  
* At the root directory, run ``` composer install ```
* Generate JWT secret key ``` php artisan jwt:secret ```
* Run migrations: ``` php artisan migrate ```

## Running Project

* ```php -S localhost:8000 -t public```

## Postman Collection

* A postman collection and its correspondent environment, with the possible endpoints, can be found at the directory `/docs`

## API Blueprint

* A documentation to the project (using API Blueprint format) can be found at directory `/docs`

### Available user's Endpoints [api/v1/users]
* /register - Register a new user
* /login - Login into the system and get the JWT token
* /logout - Logout of the system and invalidate given JWT token
* /refresh - Refresh given JWT token and get a new one

* / - Get all registed users
* /me - Get the Token's Owner User
* /{id} - Get a user by its ID

### Available application's Endpoints [api/v1/applications]
* /register - Register a new application
* /login - Login into the system and get the JWT token
* /logout - Logout of the system and invalidate given JWT token
* /refresh - Refresh given JWT token and get a new one

* / - Get all registed applications
* /current - Get the Token's Owner Application
* /{id} - Get a user by its ID
