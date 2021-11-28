# Gelateria

Gelateria is an awesome console application that from a few input parameters (gelato flavor, amount of money, number of scoops, syrup check) is capable to order a gelato and show a cool message of the desired gelato.

## How it works

Command
```
app:order-gelato 
```

Arguments

|#|Name|Type|Required|Description|Values|Default|
|---|---|---|---|---|---|---|
|1|flavor|string|true|Flavor of gelato|vanilla, pistachio, stracciatella|
|2|money|float|true|Amount of money given by the user in unit of currency||
|3|scoops|int|false|Number of scoops|1, 2, 3|1|

Options

|Name|Type|Required|Description|Values|Default|
|---|---|---|---|---|---|
|syrup (--syrup, -s)|bool|false|Flag indicating if the user wants to add syrup|true, false|false|

List prices

|Flavor|Price|
|---|---|
|Vanilla|0.8|
|Pistachio|1.2|
|Stracciatella|1.0|

Validations
* If the gelato flavor is not *vanilla*, *pistachio* or *stracciatella*, it shows the following message:
```
The gelato flavor should be vanilla, pistachio or stracciatella.
```
* If the amount of money does not reach the price of the gelato, a message as the following is displayed:
```
The vanilla costs 0.8.
```
* If the number of scoops is not between 1 and 3, it shows a message like this:
```
The number of scoops should be between 1 and 3.
```
* If the arguments are right, the displayed message is:
```
You have ordered a pistachio gelato
```
* If the number of scoops is greater than 1, it shows a message similar tot this:
```
You have ordered a pistachio gelato with 2 scoops.
```
* If it adds syrup option, the displayed message will be:
```
You have ordered a pistachio gelato with 2 scoops and syrup    
```

## Current status

This application was implemented by a developer who is no longer in the company.

His legacy is the class `MakeGelatoCommand`. This class handle all the application logic:
* It reads input parameters
* It validates input parameters
* It shows output message

He also implemented an integration test covering all possibilities (`MakeGelatoCommandTest`)

As you can see, this class is a bit messy and we need to adapt it to our coding standards
so that we can create a Merge Request and merge it into master

## What you have to do?

We would like to have a reusable, maintainable and testable code, so we want to refactor
this `MakeGelatoCommand` following these principles:

* Clean code
* SOLID principles
* Decoupling
* Design patterns
* Error handling
* Unit testing
* TDD
* Hexagonal architecture

You don't have to implement them all, but make the code better to be more comfortable with it.

Also, if there is time, our Product Owner has asked us to implement a new feature
so that we could know how much money we have earned with each flavor of gelato.

Something like the following table would be great:

|Flavor|Money|
|---|---|
|Vanilla|15|
|Pistachio|25.75|
|Stracciatella|36|

## Project set up

Install and run the application.
```
docker/composer install
docker/build
```

Examples of the use of the application.
```
docker/console app:order-gelato vanilla 0.8 1 -s
docker/console app:order-gelato pistachio 1.2
docker/console app:order-gelato stracciatella 1 --syrup
```

Run tests
```
docker/test
```
