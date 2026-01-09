# PO CAN Travel Backend

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Description

**PO CAN Travel** is a backend application for a bus ticket booking system built using **Laravel 10**. This application provides authentication features (register & login), ticket searching, booking, payment confirmation flow, and ticket management using **Eloquent ORM** with proper request validation.

This project was developed as a **Backend Intern Test Case – CAN Creative**.

## Main Features

### User Features

* Search bus tickets by route and date
* Book bus tickets
* Upload payment proof
* View booking history
* View ticket details after admin payment confirmation

### Admin Features

* View all bookings
* Update payment status (pending / confirmed / rejected)
* Confirm tickets after valid payment

### System Features

* User authentication (Register & Login)
* Role-based access (User & Admin)
* Request validation on every endpoint
* RESTful API architecture
* Database migrations & Eloquent ORM

## Tech Stack

* PHP 8.1+
* Laravel 10
* MySQL / MariaDB
* Laravel Breeze (Authentication)



## Installation & Running the Application

Follow the steps below to run the application locally:

### 1. Clone Repository

```bash
git clone https://github.com/username/po-can-travel-backend.git
cd po-can-travel-backend
```

### 2. Install Dependencies

Make sure **Composer** is installed.

```bash
composer install
```

### 3. Copy Environment File

```bash
cp .env.example .env
```

### 4. Configure Database

Update database configuration in `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=po_can_travel
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Run Migrations & Seeder

```bash
php artisan migrate
```
```bash
php artisan db:seed
````



### 7. Create Storage Symlink

This step is required to make uploaded files (e.g. payment proof) accessible publicly.

```bash
php artisan storage:link
```




### 8. Install Frontend Dependencies

This project uses **Tailwind CSS**, so Node.js and NPM are required.

```bash
npm install
```

### 9. Run Frontend Assets

```bash
npm run dev
```

### 10. Run Development Server

```bash
php artisan serve
```

The application will be accessible at:

```
http://127.0.0.1:8000
```


## Author

**L Nasrullah Hidayat Sani**
Informatics Engineering Student
