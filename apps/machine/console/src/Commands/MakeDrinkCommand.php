<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Apps\Machine\Console\Commands;

use GetWith\CoffeeMachine\Machine\Drinks\Application\Services\DrinkFinder;
use GetWith\CoffeeMachine\Machine\Drinks\Domain\Exceptions\DrinkNotFound;
use GetWith\CoffeeMachine\Machine\Orders\Application\Services\OrderCreator;
use GetWith\CoffeeMachine\Machine\Orders\Domain\Values\OrderExtraHot;
use GetWith\CoffeeMachine\Machine\Orders\Domain\Values\OrderGivenMoney;
use GetWith\CoffeeMachine\Machine\Orders\Domain\Values\OrderSugars;
use GetWith\CoffeeMachine\Machine\Shared\Domain\Values\DrinkId;

use InvalidArgumentException;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class MakeDrinkCommand extends Command
{
    protected static $defaultName = 'app:order-drink';

    public function __construct(
        private DrinkFinder $drinkFinder,
        private OrderCreator $orderCreator
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
        try {
            $drinkId = new DrinkId($input->getArgument('drink-type'));
            $money = new OrderGivenMoney($input->getArgument('money'));
            $sugars = new OrderSugars($input->getArgument('sugars'));
            $extraHot = new OrderExtraHot($input->getOption('extra-hot'));
        } catch (InvalidArgumentException $e) {
            $output->writeln($e->getMessage());
            return Command::INVALID;
        }

        try {
            $drink = $this->drinkFinder->find($drinkId);
        } catch (DrinkNotFound) {
            $output->writeln('The drink type should be tea, coffee or chocolate.');
            return Command::INVALID;
        }

        if ($drink->price()->gt($money)) {
            $output->writeln("The {$drinkId} costs {$drink->price()}.");
            return Command::INVALID;
        }

        try {
            $this->orderCreator->create($money, $drink, $sugars, $extraHot);
        } catch (InvalidArgumentException $e) {
            $output->writeln($e->getMessage());
            return Command::INVALID;
        }

        $output->write("You have ordered a {$drinkId}");

        if ($extraHot->isTrue()) {
            $output->write(' extra hot');
        }
        if ($sugars->gt(0)) {
            $output->write(" with {$sugars} sugars (stick included)");
        }
        $output->writeln('');

        return Command::SUCCESS;
    }
}
