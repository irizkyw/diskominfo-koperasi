# KODIJA (Koperasi Diskominfo Jawabarat)

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Getting Started

This project is built with Laravel, a powerful and elegant PHP framework. To get started with KODIJA, follow the instructions below.

### Prerequisites

-   [Docker](https://www.docker.com) installed on your machine.

### Running the Project

1. **Clone the Repository**

   ```bash
   git clone https://github.com/yourusername/kodija.git
   cd kodija```
2. **Set Up Environment Variables**\
   Copy the .env.example file to .env and configure it according to your environment.
   ```bash
    cp .env.example .env
    ```
   Ensure that your database configuration matches your Docker setup.
4. **Build and Start the Docker Containers**\
   Use Docker Compose to build and run the containers.
   ```bash
    docker-compose up -d --build
    ```
    This command will start the application, database, and any other necessary services.
6. **Install Dependencies**\
   Once the containers are running, install the PHP dependencies using Composer:
   ```bash
    docker-compose exec app composer install
    ```
8. **Run Migrations and Seed the Database**\
   Set up your database by running the migrations and seeding the database with initial data.
   ```bash
    docker-compose exec app php artisan migrate --seed
    ```
10. **Access the Application**\
    After the setup is complete, you can access the application at ```http://localhost:8080``` for access aplication, ```http://localhost:8888``` for access web phpmyadmin in your web browser

### Additional Commands
docker-compose down
```bash
docker-compose down
```
