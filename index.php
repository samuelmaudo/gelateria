#!/usr/bin/env php
<?php
// application.php

require __DIR__.'/vendor/autoload.php';

use GetWith\CoffeeMachine\Apps\Machine\Console\Commands\MakeDrinkCommand;
use GetWith\CoffeeMachine\Apps\Machine\Console\Commands\GetEarningsCommand;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new MakeDrinkCommand());
$application->add(new GetEarningsCommand());
$application->run();
