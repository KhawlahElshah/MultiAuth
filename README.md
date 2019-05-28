# Laravel MultiAuth

The app is build using [Laravel framework](http://laravel.com/docs), to implement users authentication using both (session and tokens).
Token authentication system used: [JWT token](https://jwt.io/introduction/)

## Setting up

Follow these steps to set up the project.

```
git clone https://github.com/KhawlahElshah/MultiAuth.git
cd MultiAuth
composer install
cp .env.example .env
```

Change the values of the `.env` file as necessary.

## Testing

First run the development server using.

```
php artisan serv
```

Now you can execute the tests by running the following command.

```
./vendor/bin/phpunit
```
