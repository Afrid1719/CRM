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

## Job Scheduling: Deleting Unused Files

This project includes a scheduled job to automatically delete unused files from storage. The job is defined as a Laravel command and registered in the `app/Console/Kernel.php` file using Laravel's scheduler.

**How it works:**

-   The job scans for files marked as soft deleted.
-   It runs at a specified interval (e.g., daily) as configured in the scheduler.
-   You can customize the logic and schedule as needed.

**To enable job scheduling:**

1. Ensure your server's cron is set up to run Laravel's scheduler:
    ```bash
    * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
    ```
2. Edit the job logic in `app/Console/Commands/DeleteUnusedFiles.php` as required.
3. In your development environment, you can run the scheduler manually with:
    ```bash
    php artisan schedule:work
    ```
    This will keep the scheduler running and execute scheduled tasks in real time.

For more details, refer to the [Laravel Task Scheduling documentation](https://laravel.com/docs/scheduling).
