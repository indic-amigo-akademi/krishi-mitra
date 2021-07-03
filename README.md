# Krishi Mitra

A Laravel Portal for agro based goods

## Steps

-   Clone the repo

```bash
git clone https://github.com/indic-amigo-akademi/krishi-mitra
```

-   Go to the folder application using cd command on your cmd or terminal

```bash
cd krishi-mitra
```

-   Install composer and node modules

```bash
npm install
composer install
```

-   Create a database named 'krishi'

-   Copy the text under Env heading given in the watsapp docs and create a .env file in your repo folder and paste the contents there.

-   By default, the username is root and you can leave the password field empty. (This is for Xampp)

-   Serve the project over port 5000 using following command

```bash
php artisan serve
```

-   After every merge and pull, run the following commands note all data will be lost

```bash
composer dump-autoload
php artisan migrate:fresh --seed
```
