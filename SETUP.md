# Setup Instructions

## Prerequisites

Before running the project, make sure the following are installed:

- PHP 8.x
- Composer
- MySQL
- Node.js & NPM
- Git

## Installation Steps

### 1. Clone Repository

git clone <repository-url>

cd project-folder

### 2. Install PHP Dependencies

composer install

### 3. Install Node Dependencies

npm install

### 4. Create Environment File

cp .env.example .env

### 5. Configure Database

Update database credentials in the .env file:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=assignment_notes_app
DB_USERNAME=root
DB_PASSWORD=

### 6. Generate Application Key

php artisan key:generate

### 7. Run Migrations

php artisan migrate

### 8. Start Laravel Development Server

php artisan serve

### 9. Start Vite Development Server

npm run dev

### 10. Access Application

http://127.0.0.1:8000

## API Testing

Use Postman, Thunder Client, or Insomnia to test the APIs.