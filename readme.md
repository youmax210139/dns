# Dns tools

Built by Inertia.js and Laravel

## Installation

Clone the repo locally:

```sh
git clone https://github.com/inertiajs/pingcrm.git pingcrm
cd dns
```

Install PHP dependencies:

```sh
composer install
```

Install NPM dependencies:

```sh
yarn install
```

Build assets:

```sh
yarn run dev
```

Setup configuration:

```sh
cp .env.example .env
```

Generate application key:

```sh
php artisan key:generate
```

Create an Mysql database.

```sh
CREATE DATABASE `dns` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
```

Run database migrations:

```sh
php artisan migrate --seed
```

Run the dev server (the output will give the address):

```sh
php artisan serve
```

You're ready to go! Visit Dns Tools Site in your browser, and login with:

-   **Username:** admin@gmail.com
-   **Password:** 123456

## Running tests

To run theDns Tools tests, run:

```
phpunit
```
