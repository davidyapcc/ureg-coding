# U-Reg Exchange Rates

A Laravel application that displays currency exchange rates with historical data support.

## Features

- View current exchange rates against USD
- Historical exchange rates lookup
- Interactive date picker
- Responsive card-based layout
- Support for multiple currencies

## Requirements

### Using Docker (Recommended)
- Docker
- Docker Compose

### Local Development
- PHP 8.2 or higher
- Node.js 20.0 or higher
- MySQL 8.0
- Composer
- npm

## Installation

### Using Docker (Recommended)

Just three simple steps:

1. Clone the repository:
```bash
git clone git@github.com:davidyapcc/ureg-coding.git
cd ureg-coding-challenge
```

2. Copy the Docker environment file:
```bash
cp .env.docker .env
```

3. Build and start the Docker containers:
```bash
docker-compose up -d --build
```

That's it! The application will be available at `http://localhost:8080`

The Docker setup automatically:
- Installs all PHP and Node.js dependencies
- Sets up the database
- Runs migrations and seeders
- Builds frontend assets
- Configures the web server
- Starts all necessary services

### Local Development

1. Clone the repository:
```bash
git clone git@github.com:davidyapcc/ureg-coding.git
cd ureg-coding-challenge
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install Node.js dependencies:
```bash
npm install
```

4. Copy the environment file:
```bash
cp .env.example .env
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Configure your database in `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=forex
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

7. Run database migrations and seeders:
```bash
php artisan migrate --seed
```

8. Build frontend assets:
```bash
npm run build
```

9. Start the development server:
```bash
php artisan serve
```

The application will be available at `http://localhost:8080`

## Development

For local development with hot-reload:

```bash
# Terminal 1: Start Laravel development server
php artisan serve

# Terminal 2: Start Vite development server
npm run dev
```

## Additional Commands

These commands are only needed if you want to refresh the database or run tests. The Docker setup handles the initial database setup automatically.

### Database Refresh

```bash
# Using Docker
docker-compose exec app php artisan migrate:fresh --seed

# Local development
php artisan migrate:fresh --seed
```

### Running Tests

```bash
# Using Docker
docker-compose exec app php artisan test

# Local development
php artisan test
```

## License

This application is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
