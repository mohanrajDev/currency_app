## Installation Documentation

- Step 1
  `git clone https://github.com/mohanrajDev/currency_app.git`

- Step 2
  `cd currency_app`

- Step 3
  `composer install `
  `npm run dev`

- Step 4
  `cp .env.example .env` 

- Step 5
  -config database deatils
  -config mail details
  ` MAIL_MAILER=smtp
    MAIL_HOST=smtp.mailtrap.io
    MAIL_PORT=2525
    MAIL_USERNAME=46800780d5c6d2
    MAIL_PASSWORD=d76d4076f6c3da
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS=katikal730@kartk5.com
    MAIL_FROM_NAME="${APP_NAME}"`

- Step 6
   `php artisan migrate --seed`

- Step 7
    `php artisan storage:link`

- Step 8
     `sudo chmod -R 777 storage bootstrap/cache`

- Step 9
    `php artisan serve`

- Step 10
  `Vist http://localhost:8000/`
  

