<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Project

YamaPlus is a company that deals in items such as clothing and products for home and life. This system was created to support the company's digital transformation and manage data effectively.

The system includes the following main features:

Sales Document Management
The system allows you to save sales documents with ease. This ensures that all sales records are kept in a centralized location, making it easy to access and manage.

Employee Management
The employee management feature allows you to manage all employee information in one place. This includes personal information, job responsibilities, and work schedules.

Customer Management
The customer management feature helps you to manage customer information, including contact details and purchasing history. This allows you to provide better customer service and build long-lasting relationships.

Revenue Management
The revenue management feature provides you with an overview of your company's revenue, including sales and expenses. This helps you make informed business decisions and plan for future growth.

Data Entry and Contract Drafting Support
The system provides support in data entry and contract drafting, making it easier for you to keep track of all necessary information. This helps to minimize errors and ensures that all contracts are properly documented.

Overall, YamaPlus provides a comprehensive solution for managing the day-to-day operations of your business. With its range of features, you can streamline your processes and make data-driven decisions to drive growth and success.

## Technology in used:

-   [Laravel](https://laravel.com/docs/9.x) => Version 9
-   PHP => Version 8
-   Bootstrap 5
-   Database => Mysql
-   Laravel-filemanager => Version 2.5

## Setup and Run Source

-   composer update
-   cp .env.example .env
-   php artisan key:generate
-   Config Database in file .env
-   If you use a local database (Skip the 2 statements below if you use an existing database on the server)
    -   php artisan migrate
    -   php artisan migrate --seed
-   php artisan serve (Run Source Code on localhost)
