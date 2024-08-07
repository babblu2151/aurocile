## Prerequisites

Before you begin, ensure you have the following installed:
- PHP (>= 8.0)
- Composer
- MySQL or another database server
- Node.js and npm (for frontend dependencies if needed)
- Git

Download or clone the repository

## Setup Backend

Open Backend task_backend folder in vs code or command prompt and type below commands
- composer install
- check for .env file or create new one and setup database credentials in Mysql
- php artisan key:generate
- php artisan migrate
- php artisan serve

The backend will be available at http://127.0.0.1:8000

## Setup Frontend
Open Frontend task_frontend folder in vs code or command prompt and type below commands

- composer install
- php spark serve

The frontend will be available at http://localhost:8080 or http://localhost:8081

Now using the frontend interface you can easily communicate with backend database usin RESTful apis
