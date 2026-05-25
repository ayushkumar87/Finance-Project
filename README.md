# Personal Finance Dashboard Project

This is a Laravel-based Personal Finance Dashboard application designed to help users track their income and expenses, view financial literacy resources, and use financial calculators.

## Prerequisites

Before you can run this project on your system, you must have the following installed:
- **PHP** (v8.2 or higher)
- **Composer** (Dependency manager for PHP)
- **Node.js & npm** (For compiling frontend assets like Tailwind CSS via Vite)
- **XAMPP / MySQL Server** (To run the MySQL database)
- **Git** (optional, if cloning)

## Installation & Setup Instructions

Follow these steps carefully to set up and run the project locally:

### 1. Extract or Clone the Project
If you received this as a zip file, extract it into a folder.
If you are using Git, clone the repository and navigate into the folder:
```bash
cd myproject
```

### 2. Install PHP Dependencies
Run Composer to install all the required backend packages:
```bash
composer install
```

### 3. Install Frontend Dependencies
Run npm to install Vite, Tailwind CSS, and other frontend tools:
```bash
npm install
```

### 4. Setup Environment Variables
Duplicate the example environment file to create your own configuration:
```bash
# On Windows (Command Prompt / PowerShell)
copy .env.example .env

# On Mac / Linux
cp .env.example .env
```
Open the `.env` file in your text editor and ensure the database settings match your local XAMPP MySQL configuration:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=myproject
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Generate Application Key
Generate the unique application key for Laravel encryption:
```bash
php artisan key:generate
```

### 6. Set Up the Database
Before running migrations, you must create the database in XAMPP:
1. Open the **XAMPP Control Panel** and start **Apache** and **MySQL**.
2. Go to `http://localhost/phpmyadmin` in your web browser.
3. Click on **New** on the left sidebar to create a new database.
4. Name the database `myproject` and click **Create**.

Once the database is created, run the following command in your terminal to create your database tables and seed them with a default test user:
```bash
php artisan migrate --seed
```

## Running the Application

To run the application, you need to start **both** the backend and frontend servers simultaneously.

### Start the Backend Server (Terminal 1)
Open a terminal in the project folder and run:
```bash
php artisan serve
```
This will start the PHP server, usually at `http://127.0.0.1:8000`.

### Start the Frontend Server (Terminal 2)
Open a **second, separate terminal** in the same folder and run:
```bash
npm run dev
```
This starts Vite to compile your Tailwind CSS and Javascript in real-time.

### View the App
Open your web browser and go to:
**http://127.0.0.1:8000**

You can now register a new account or log in with the test credentials provided by the database seeder!

## Default Test User
If you ran `php artisan migrate --seed`, you can log in using:
- **Email:** [EMAIL_ADDRESS] (replace with your actual email if you edited the seeder)
- **Password:** 12345678
