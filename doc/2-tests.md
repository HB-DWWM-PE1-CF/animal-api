How to test your Symfony app
============================

By default, Symfony is configured to use [PHPUnit](https://phpunit.de/) as test engine.

## Prepare your environment

Sometime, you need to use a DB to run your tests. To prevent data lost, Symfony will create another database with
`_test` suffix.

Add new file `.env.test.local` to config env variables for test. Set at least your `DATABASE_URL` in it.

```shell
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name
```

Run those commands to setup your DB (dont forget `--env=test`):

```shell
symfony console doctrine:database:create --env=test # shortcut d:d:c
symfony console doctrine:migration:migrate --env=test # shortcut d:m:m
symfony console hautelook:fixtures:load --purge-with-truncate --env=test
```

## Run tests

Simply run:
```shell
symfony php bin/phpunit
```

If there are deprecations report in your terminal and you want to hide them, add/edit this env variable to `.env.test`:

```shell
SYMFONY_DEPRECATIONS_HELPER=disabled
```

## Examples

Take a look at [tests](tests/) directory in project root.

## Docs

- [BrowserKit](https://symfony.com/doc/current/components/browser_kit.html)
- [Panther](https://github.com/symfony/panther)
- [Testing](https://symfony.com/doc/current/testing.html)
