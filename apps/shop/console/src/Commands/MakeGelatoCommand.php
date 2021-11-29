<?php

declare(strict_types=1);

namespace Gelateria\Apps\Shop\Console\Commands;

use Gelateria\Shop\Gelati\Application\Services\FlavorFinder;
use Gelateria\Shop\Gelati\Domain\Exceptions\FlavorNotFound;
use Gelateria\Shop\Orders\Application\Services\OrderCreator;
use Gelateria\Shop\Orders\Domain\Values\OrderSyrup;
use Gelateria\Shop\Orders\Domain\Values\OrderGivenMoney;
use Gelateria\Shop\Orders\Domain\Values\OrderScoops;
use Gelateria\Shop\Shared\Domain\Values\FlavorId;

use InvalidArgumentException;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class MakeGelatoCommand extends Command
{
    protected static $defaultName = 'order-gelato';

    public function __construct(
        private FlavorFinder $flavorFinder,
        private OrderCreator $orderCreator
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument(
            'flavor',
            InputArgument::REQUIRED,
            'The flavor of the gelato. (Vanilla, Pistachio or Stracciatella)'
        );

        $this->addArgument(
            'money',
            InputArgument::REQUIRED,
            'The amount of money given by the user'
        );

        $this->addArgument(
            'scoops',
            InputArgument::OPTIONAL,
            'The number of scoops you want. (1, 2, 3)',
            1
        );

        $this->addOption(
            'syrup',
            's',
            InputOption::VALUE_NONE,
            'If the user wants to add syrup to the gelato'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $flavorId = new FlavorId($input->getArgument('flavor'));
            $money = new OrderGivenMoney($input->getArgument('money'));
            $scoops = new OrderScoops($input->getArgument('scoops'));
            $syrup = new OrderSyrup($input->getOption('syrup'));
        } catch (InvalidArgumentException $e) {
            $output->writeln($e->getMessage());
            return Command::INVALID;
        }

        try {
            $flavor = $this->flavorFinder->find($flavorId);
        } catch (FlavorNotFound $e) {
            $output->writeln("We do not make {$e->key()} gelati");
            return Command::INVALID;
        }

        try {
            $this->orderCreator->create($money, $flavor, $scoops, $syrup);
        } catch (InvalidArgumentException $e) {
            $output->writeln($e->getMessage());
            return Command::INVALID;
        }

        $output->write("You have ordered a {$flavorId} gelato");

        if ($scoops->gt(1)) {
            $output->write(" with {$scoops} scoops");
            if ($syrup->isTrue()) {
                $output->write(' and syrup');
            }
        } else {
            if ($syrup->isTrue()) {
                $output->write(' with syrup');
            }
        }
        $output->writeln('');

        return Command::SUCCESS;
    }
}
