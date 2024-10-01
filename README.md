# Exchange Rate Service

This project is an Exchange Rate Service built with Laravel 11, providing functionality to manage and display exchange
rates for various currencies. It includes features such as pagination, detailed currency views, and history tracking.

## Table of Contents

- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Database Migrations](#database-migrations)
- [Cron Setup](#cron-setup)

## Requirements

- PHP 8.x
- Composer
- MySQL
- Laravel 11
- Apache/Nginx

## Installation

1. **Clone the repository:**

   ```bash
   git clone https://github.com/sumoninfo/exchange-rate-service.git
   cd exchange-rate-service
2. **Install dependencies:**

   ```bash
   composer install
3. **Copy the environment file:**

    ```bash
    cp .env.example .env
4. **Generate the application key:**

    ```bash
    php artisan key:generate

## Configuration

1. **Open the .env file and configure your database settings:**
    ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
2. **Set the APP_URL to your local server URL:**
    ```bash
    APP_URL=http://localhost:8000

## Database migrations

1. **Run the migrations:**
      ```bash
    php artisan migrate

## Cron Setup

  ```bash
    * * * * * php /var/www/exchange-rate-service/artisan exchange:rates:update >> /dev/null 2>&1
