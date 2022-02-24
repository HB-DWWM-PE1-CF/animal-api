How to install THIS repository on your machine
==============================================

## Download the repository

```shell
# Clone the repository on your machine.
git clone https://github.com/HB-DWWM-PE1-CF/animal-api.git
# Move your working directory into animal-api.
cd animal-api
```

## Check your PHP version

```shell
symfony local:php:list
```

You should get a table like bellow.
```shell
┌─────────┬─────────────────────────────┬─────────┬─────────┬─────────────┬─────────┬─────────┐
│ Version │          Directory          │ PHP CLI │ PHP FPM │   PHP CGI   │ Server  │ System? │
├─────────┼─────────────────────────────┼─────────┼─────────┼─────────────┼─────────┼─────────┤
│ 5.6.40  │ C:\tools\php-bin\php-5.6.40 │ php.exe │         │ php-cgi.exe │ PHP CGI │         │
│ 7.1.33  │ C:\tools\php-bin\php-7.1.33 │ php.exe │         │ php-cgi.exe │ PHP CGI │         │  
│ 7.2.34  │ C:\tools\php-bin\php-7.2.34 │ php.exe │         │ php-cgi.exe │ PHP CGI │         │
│ 7.4.10  │ C:\tools\php-bin\php-7.4.10 │ php.exe │         │ php-cgi.exe │ PHP CGI │         │
│ 8.0.6   │ C:\tools\php-bin\php-8.0.5  │ php.exe │         │ php-cgi.exe │ PHP CGI │ *       │
│ 8.1.0   │ C:\tools\php-bin\php-8.1.0  │ php.exe │         │ php-cgi.exe │ PHP CGI │         │
└─────────┴─────────────────────────────┴─────────┴─────────┴─────────────┴─────────┴─────────┘
```
To check that you used the right version, look at your `Version` column, the version used will be highlighted and
should be 8.x.

If not, it must be because php8 is not installed on your machine.

## Init steps

You need to do these steps only on the first time you install the projet on a machine.

- Create the file `.env.local` and configure your info for database connection. Take a look at `.env` file, where you can
find `DATABASE_URL`.

```shell
# Install PHP deps (create vendor directory).
symfony composer install
# Create database if not exist (an error will be throw if exist).
symfony console doctrine:database:create # shortcut d:d:c
```

## Configure JWT

### Requirements

To log in via JWT, you need to create an SSL keys pair. You need OpenSSL installed on your computer.
- Windows: [https://slproweb.com/products/Win32OpenSSL.html](https://slproweb.com/products/Win32OpenSSL.html)
- Linux (Debian based): apt-get install openssl

### Generate

This command will generate new keys pair based on .env config.

```shell
symfony console lexik:jwt:generate-keypair
```

## Reset database with data

You may have to use those commands multiple time during developping.

```shell
# Apply migration to create tables in database.
symfony console doctrine:migration:migrate # shortcut d:m:m
# Populate the database with fake data.
symfony console hautelook:fixtures:load --purge-with-truncate
```

## Start the app

```shell
symfony serve
```

In case you got an error telling you the server is already running, stop it with:

```shell
symfony server:stop
```
