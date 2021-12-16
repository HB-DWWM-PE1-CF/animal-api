How to (re)create THIS repository from scratch
==============================================

## Create project

Open a terminal in your directory project.

```shell
# Create a new symfony project using 5.4 (LTS) with php8 inside a directory called animal-api-recreate.
symfony new --full --version=5.4 --php=8.0 animal-api-recreate
# Move inside animal-api-recreate.
cd animal-api-recreate
```

## Set php version for the project

Create a new file `.php-version` with this code inside:
```
8.0
```
It will tell to Symfony CLI to use php 8.0 for this project.

## Create `.env.local`

Create the file `.env.local` and configure your info for database connection. Take a look at `.env` file, where you can
find `DATABASE_URL`.

More info about environment files here: [https://symfony.com/doc/current/configuration.html#configuration-based-on-environment-variables](https://symfony.com/doc/current/configuration.html#configuration-based-on-environment-variables).

## Install & configure api dependencies.

Install [API Platform](https://api-platform.com/docs/core/getting-started/) and some small other deps.

```shell
symfony composer require api
```

If you want to customize some global config for your API, you can do it inside `config/apackages/api_platform.yaml`. To
know what you can add/set inside this file, take a look at [this documentation](https://api-platform.com/docs/core/configuration/).

## Create your entities.

Now, you can add your entities to the project. To do that, you can use this command to create and edit entities:

```shell
symfony console make:entity
# or
symfony console make:entity YourEntity
```

Take time to read what will be printed in the terminal, if you answer the questions, Symfony will generate your entity.
To ease the process, first create all your entities WITHOUT association/relation, only with basic properties. In a
second time, you can add associations.

## Update database.

After you finished the creation or edition of your entities, you have to update your database to match your entities:
```shell
symfony console make:migration
```
This command compare what is already in your database and the current state of your entities, then it will generate a
file migration located in `migrations/` directory.

After your migration file have been created, you need to update the database itself with this command:
```shell
symfony console doctrine:migration:migrate # short d:m:m
```

Each time you update some fields in your entities, you need to run those two commands.

## Remove some API actions/operations

On your entity, you can list actions you want to have:

```php
use ApiPlatform\Core\Annotation\ApiResource;

#[ApiResource(
    collectionOperations: ['get'],
    itemOperations: ['get'],
)]
```

In this example, only GET actions for item and collection are kept. See [Operation docs](https://api-platform.com/docs/core/operations/)
for more info.

## Add filters to collection

You can add filters on collection action to make queries on data. Put the attribute on your entity.

```php
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

// This attribute allow to search in string same as LIKE in SQL (partial) on name field.
#[ApiFilter(SearchFilter::class, properties: ['name' => 'partial'])]
// This attribute allow to sort data by name and/or id.
#[ApiFilter(OrderFilter::class, properties: ['name', 'id'])]
```

For more examples, take a look at [Filter docs](https://api-platform.com/docs/core/filters/).

## Generate fixtures

Using the [AliceBundle](https://github.com/theofidry/AliceBundle) to integrate [Faker](https://github.com/fzaninotto/Faker)
and [Alice](https://github.com/nelmio/alice) libraries into our project.

### Install 

```shell
symfony composer require hautelook/alice-bundle
```

After install, a new directory `fixtures/` will be automatically created. Your will write your fixtures inside.

For more example, take look at this repository `fixtures/` directory and the docs like bellow:
- [Basic YAML fixtures](https://github.com/nelmio/alice/blob/master/doc/complete-reference.md#creating-fixtures)
- [Optional data & unique constraint](https://github.com/nelmio/alice/blob/master/doc/complete-reference.md#optional-data)
- [List of formatters](https://github.com/fzaninotto/Faker#formatters) (functions you can use to generate fake data)
- [Reference another fixture](https://github.com/nelmio/alice/blob/master/doc/relations-handling.md)
- [Extensions list for Faker](https://github.com/fzaninotto/Faker#third-party-libraries-extendingbased-on-faker)

Once you finished your fixtures, use this command to populate your database with it.

```shell
symfony console hautelook:fixtures:load --purge-with-truncate
```
