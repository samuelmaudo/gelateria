<?php

namespace GetWith\CoffeeMachine\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetEarningsCommand extends Command
{
    protected const EARNINGS = [
        'tea' => 15,
        'coffee' => 25.75,
        'chocolate' => 36,
    ];

    protected static $defaultName = 'app:show-earnings';

    protected function configure(): void
    {
        $this->addArgument(
            'drink-type',
            InputArgument::REQUIRED,
            'The type of the drink. (Tea, Coffee or Chocolate)'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $drinkType = strtolower($input->getArgument('drink-type'));

        if (!isset(static::EARNINGS[$drinkType])) {
            $output->writeln('The drink type should be tea, coffee or chocolate.');
            return Command::INVALID;
        }

        $earnings = static::EARNINGS[$drinkType];
        $output->writeln("You have earned {$earnings}");
        return Command::SUCCESS;
    }
}
