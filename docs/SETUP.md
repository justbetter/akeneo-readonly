# Setup

## Application Setup

1. Create the environment file
```shell
cp .env.example .env
```
2. Fill in the values staring with `APP_` and `DATABASE_`
3. Generate an app key `php artisan key:generate`

## Horizon

Laravel Horizon is used for processing tasks in the background. 
View the Laravel Horizon documentation to learn how to set this up.

## Cron

Setup your cron to call `php artisan schedule:run` every minute.

For example: `* * * * * php8.0 /var/www/readonly/artisan schedule:run`

## Akeneo Setup
In your `.env` fill in the `AKENEO_` fields.

Run the setup command: `php artisan setup`.
This will retrieve all attributes and products

## Akeneo Events

In order to keep the product data up to date we use Akeneo's Event API.
In your Akeneo connection click on Even Subscription and set the URL to:

`<readonly_url>/api/laravel-akeneo/webhook`

When you press the test button the response should be `204 no content`
