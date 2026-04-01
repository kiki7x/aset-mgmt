# Aset Management System

<p align="center">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</p>

<p align="center">
    <a href="https://github.com/laravel/framework/actions">
        <img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status">
    </a>
    <a href="https://packagist.org/packages/laravel/framework">
        <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads">
    </a>
    <a href="https://packagist.org/packages/laravel/framework">
        <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version">
    </a>
    <a href="https://packagist.org/packages/laravel/framework">
        <img src="https://img.shields.io/packagist/l/laravel/framework" alt="License">
    </a>
</p>

---

## About the Project

The **Aset Management System** is a web-based application built using the Laravel framework. It is designed to help organizations manage their assets efficiently, providing features such as asset tracking, categorization, and reporting.

---

## Features

- Asset registration and categorization
- Asset tracking and history
- User management and roles
- Reporting and analytics
- Notifications for asset maintenance

---

## Getting Started

Follow these steps to set up the project on your local machine.

### Prerequisites

Ensure you have the following installed:

- PHP >= 8.1
- Composer
- MySQL or any other supported database
- Node.js and npm (for frontend assets)

### Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/aset_mgmt.git
   cd aset_mgmt
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Install JavaScript dependencies:
   ```bash
   npm install
   ```

4. Copy the `.env.example` file to `.env`:
   ```bash
   cp .env.example .env
   ```

5. Generate the application key:
   ```bash
   php artisan key:generate
   ```

6. Configure your database in the `.env` file:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_user
   DB_PASSWORD=your_database_password
   ```

7. Run database migrations:
   ```bash
   php artisan migrate
   ```

Visit `http://localhost:8000` in your browser to access the application.

---

### Contributors projects


[![Contributors](https://contrib.rocks/image?repo=kiki7x/aset_mgmt)](https://github.com/kiki7x/aset_mgmt/graphs/contributors)

---

## License

This project is open source and available under the [MIT License](LICENSE).
