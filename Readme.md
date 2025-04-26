# CRM

A **Laravel 10** project with **React.js** frontend integrated inside the `resources/js` folder.

## Requirements

-   PHP >= 8.1
-   Composer
-   Node.js & npm
-   MySQL (or any preferred database)
-   Webserver (XAMPP / Laragon / Laravel Sail / Docker, etc.)

## Getting Started

#### Step 1: Clone the repository and navigate to the project directory

```bash
git clone https://github.com/Afrid1719/CRM.git
cd CRM
```

#### Step 2: Install PHP dependencies

```bash
composer install
```

#### Step 3: Set up the environment file

```bash
cp .env.example .env
php artisan key:generate
```

#### Step 4: Install JavaScript dependencies

```bash
npm install
npm run dev
```

#### Step 5: Run database migrations

```bash
php artisan migrate
```

#### Step 6: Start the development server

```bash
php artisan serve
```

### Folder Structure

Below is an overview of the main folder structure:

```
CRM/
├── app/                # Contains the core application code
├── bootstrap/          # Contains the application bootstrap files
├── config/             # Configuration files for the application
├── database/           # Database migrations, factories, and seeders
├── public/             # Publicly accessible files (e.g., index.php, assets)
├── resources/          # Views, language files, and frontend assets
│   ├── js/             # React.js frontend code
│   ├── views/          # Blade templates
├── routes/             # Application route definitions
├── storage/            # Logs, cache, and compiled files
├── tests/              # Automated tests
├── vendor/             # Composer dependencies
├── .env.example        # Example environment configuration file
├── artisan             # Artisan CLI entry point
├── composer.json       # Composer dependencies configuration
├── package.json        # Node.js dependencies configuration
└── webpack.mix.js      # Laravel Mix configuration for asset compilation
```
