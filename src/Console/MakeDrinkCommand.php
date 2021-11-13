<?php

namespace GetWith\CoffeeMachine\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MakeDrinkCommand extends Command
{
    protected const PRICES = [
        'tea' => 0.4,
        'coffee' => 0.5,
        'chocolate' => 0.6,
    ];

    protected static $defaultName = 'app:order-drink';

    protected function configure(): void
    {
        $this->addArgument(
            'drink-type',
            InputArgument::REQUIRED,
            'The type of the drink. (Tea, Coffee or Chocolate)'
        );

        $this->addArgument(
            'money',
            InputArgument::REQUIRED,
            'The amount of money given by the user'
        );

        $this->addArgument(
            'sugars',
            InputArgument::OPTIONAL,
            'The number of sugars you want. (0, 1, 2)',
            0
        );

        $this->addOption(
            'extra-hot',
            'e',
            InputOption::VALUE_NONE,
            'If the user wants to make the drink extra hot'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $drinkType = strtolower($input->getArgument('drink-type'));
        $money = $input->getArgument('money');
        $sugars = $input->getArgument('sugars');
        $extraHot = $input->getOption('extra-hot');

        if (!isset(static::PRICES[$drinkType])) {
            $output->writeln('The drink type should be tea, coffee or chocolate.');
            return Command::INVALID;
        }

        $price = static::PRICES[$drinkType];
        if ($money < $price) {
            $output->writeln("The {$drinkType} costs {$price}.");
            return Command::INVALID;
        }

        if ($sugars < 0 || $sugars > 2) {
            $output->writeln('The number of sugars should be between 0 and 2.');
            return Command::INVALID;
        }

        $output->write("You have ordered a {$drinkType}");

        if ($extraHot) {
            $output->write(' extra hot');
        }
        if ($sugars > 0) {
            $output->write(" with {$sugars} sugars (stick included)");
        }
        $output->writeln('');

        return Command::SUCCESS;
    }
}
