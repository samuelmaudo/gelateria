# Gelateria

## Introduction

This project is a experiment to build a CLI application with 
[Symfony Components](https://symfony.com/components) and [Doctrine ORM](https://www.doctrine-project.org/projects/orm.html). All structured with **domain-driven design** and **hexagonal architecture.**

Gelateria is an awesome console application that from a few input parameters (gelato flavor, amount of money, number of scoops, syrup check) is capable to order a gelato and show a cool message of the desired gelato.

By the way, if you do not know what a _gelato_ is, or a _gelateria,_ they are 
the Italian words for “ice cream” and “ice cream parlour”.

## Technical details

### Calculation of the order amount

#### Price list

|Flavor|Scoop Price|
|---|---|
|Vanilla|0.8|
|Pistachio|1.2|
|Stracciatella|1.0|

#### Discounts

Second scoops have a fixed discount of 0.2, and third scoops have a fixed 
discount of 0.4.

### Command to make a gelato

#### Name

```
order-gelato
```

#### Arguments

|#|Name|Type|Required|Description|Values|Default|
|---|---|---|---|---|---|---|
|1|flavor|string|true|Flavor of gelato|vanilla, pistachio, stracciatella|
|2|money|float|true|Amount of money given by the user in unit of currency||
|3|scoops|int|false|Number of scoops|1, 2, 3|1|

#### Options

|Name|Type|Required|Description|Values|Default|
|---|---|---|---|---|---|
|syrup (--syrup, -s)|bool|false|Flag indicating if the user wants to add syrup|true, false|false|

#### Validations

*   If the gelato flavor is not *vanilla*, *pistachio* or *stracciatella*, it shows the following message:
    ```
    We do not make vodka gelati
    ```

*   If the amount of money does not reach the amount of the order, a message as the following is displayed:
    ```
    Your order costs 0.8
    ```

*   If the number of scoops is not between 1 and 3, it shows a message like this:
    ```
    The number of scoops should be between 1 and 3
    ```

*   If the arguments are right, the displayed message is:
    ```
    You have ordered a pistachio gelato
    ```

*   If the number of scoops is greater than 1, it shows a message similar tot this:
    ```
    You have ordered a pistachio gelato with 2 scoops
    ```

*   If it adds syrup option, the displayed message will be:
    ```
    You have ordered a pistachio gelato with 2 scoops and syrup    
    ```

### Command to know how much money we have earned

#### Name

```
show-earnings
```

#### Arguments

|#|Name|Type|Required|Description|Values|Default|
|---|---|---|---|---|---|---|
|1|flavor|string|true|Flavor of gelato|vanilla, pistachio, stracciatella|

#### Validations

*   If the gelato flavor is not *vanilla*, *pistachio* or *stracciatella*, it shows the following message:
    ```
    We do not make vodka gelati
    ```

*   If the arguments are right, the displayed message is:
    ```
    We have earned 14.4
    ```

## Local deployment

### Run command through Docker

To make it easier to run the command, I have prepared a Docker Compose file.
If you have [Docker](https://www.docker.com/products/docker-desktop) installed,
it is as simple as placing this inside the root folder:

```shell
docker-compose run --rm console order-gelato vanilla 2.0
```

Or this:

```shell
docker-compose run --rm console show-earnings vanilla
```

_Warning:_ These commands start the database service, so do not forget to stop 
it afterwards with this:

```shell
docker-compose down
```

### Run tests through Docker

To run the test suite, place this command inside the root folder:

```shell
docker-compose run --rm tests
```

Tests are running with [PHPUnit](https://phpunit.de/), so the output will be
similar to this:

```
PHPUnit 9.5.10 by Sebastian Bergmann and contributors.

Runtime:       PHP 8.0.12
Configuration: E:\Proyectos\HackerRank\gelateria\phpunit.xml

...........................................................       59 / 59 (100%)

Time: 00:01.110, Memory: 16.00 MB

OK (59 tests, 95 assertions)
```

### The traditional way

If you prefer not to use Docker, you can use [Composer](https://getcomposer.org/) 
to install the project dependencies. And PHP to run the commands.

In addition, you will need to configure the database connection in the `.env` 
file.

Once the dependencies are installed and the database is configured, you will be 
able to run the commands:

```shell
php apps/shop/console/bin/gelateria order-gelato vanilla 2.0
```

And the test suite:

```shell
php vendor/bin/phpunit
```