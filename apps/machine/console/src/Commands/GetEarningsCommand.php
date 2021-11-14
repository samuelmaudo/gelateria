<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Apps\Machine\Console\Commands;

use GetWith\CoffeeMachine\Machine\Drinks\Application\Services\DrinkFinder;
use GetWith\CoffeeMachine\Machine\Drinks\Domain\Exceptions\DrinkNotFound;
use GetWith\CoffeeMachine\Machine\Orders\Application\Services\EarningsCalculator;
use GetWith\CoffeeMachine\Machine\Shared\Domain\Values\DrinkId;

use InvalidArgumentException;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class GetEarningsCommand extends Command
{
    protected static $defaultName = 'app:show-earnings';

    public function __construct(
        private DrinkFinder $drinkFinder,
        private EarningsCalculator $earningsCalculator
    ) {
        parent::__construct();
    }

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
        try {
            $drinkId = new DrinkId($input->getArgument('drink-type'));
        } catch (InvalidArgumentException $e) {
            $output->writeln($e->getMessage());
            return Command::INVALID;
        }

        try {
            $this->drinkFinder->find($drinkId);
        } catch (DrinkNotFound) {
            $output->writeln('The drink type should be tea, coffee or chocolate.');
            return Command::INVALID;
        }

        $earnings = $this->earningsCalculator->calculate($drinkId);
        $output->writeln("You have earned {$earnings}");
        return Command::SUCCESS;
    }
}
