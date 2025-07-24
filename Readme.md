# CRM

A simple CRM application built with Laravel 10, React.js, Inertia.js, and Tailwind CSS, designed for local development using Docker.

## Requirements

-   Docker Desktop (for Windows) or Docker and Docker Compose (for Linux/macOS)
-   Git

## Tech Stack

-   **Backend**: Laravel 10
-   **Frontend**: React.js, Inertia.js, and Tailwind CSS
-   **Database**: MySQL
-   **Web Server**: Laravel's built-in server
-   **Containerization**: Docker
-   **Task Scheduling**: Laravel's built-in scheduler for background jobs
-   **SSL**: Self-signed SSL certificate for local development
-   **Version Control**: Git
-   **Package Management**: Composer for PHP dependencies, npm for JavaScript dependencies
-   **Project Management**: Github --> [CRM](https://github.com/users/Afrid1719/projects/1)

## Getting Started

#### Step 1: Clone the repository and navigate to the project directory

```bash
git clone https://github.com/Afrid1719/CRM.git
cd CRM
```

#### Step 2: Install Docker Desktop on Windows (alternatively, you can install Docker and Docker Compose on Linux or macOS)

Follow the [official Docker installation guide](https://docs.docker.com/get-docker/) for your operating system.

#### Step 3: Set up the environment file

```bash
cp .env.example .env
```

#### Step 4: Build and start the Docker containers

```bash
docker-compose up -d --build
```

This command builds the Docker containers and starts them in detached mode. It also installs the necessary composer dependencies and npm dependencies. It generates a self-signed SSL certificate for local development and sets up the database. It generates the application key and runs the migrations. It also links the storage directory.

For seeding the database with initial data, you can run (inspect the app logs to run this after migrations are complete):

```bash
docker-compose exec app php artisan db:seed
```

#### Step 5: Access the application

You can access the application in your web browser at `https://crm.localhost` and database management at `https://db.crm.localhost`.

### Folder Structure

Below is an overview of the main folder structure:

```
CRM/
├── app/                # Contains the core application code
├── bootstrap/          # Contains the application bootstrap files
├── certs/              # Contains the SSL certificates
├── config/             # Configuration files for the application
├── database/           # Database migrations, factories, and seeders
├── nginx/              # Nginx configuration files
├── public/             # Publicly accessible files (e.g., index.php, assets)
├── resources/          # Views, language files, and frontend assets
│   ├── js/             # React.js frontend code
│   ├── views/          # Blade templates
├── routes/             # Application route definitions
├── storage/            # Logs, cache, and compiled files
├── tests/              # Automated tests
├── vendor/             # Composer dependencies
├── .dockerignore       # Files to ignore in Docker builds
├── .env.example        # Example environment configuration file
├── artisan             # Artisan CLI entry point
├── composer.json       # Composer dependencies configuration
├── docker-compose.yml  # Docker Compose configuration
├── docker-entrypoint.sh # Custom entrypoint script for Docker
├── Dockerfile          # Dockerfile for building the application image
├── jsconfig.json      # JavaScript configuration file
├── package.json        # Node.js dependencies configuration
├── tailwind.config.js  # Tailwind CSS configuration
└── vite.config.js      # Vite configuration for asset compilation
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
