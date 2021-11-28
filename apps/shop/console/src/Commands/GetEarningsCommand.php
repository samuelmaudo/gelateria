<?php

declare(strict_types=1);

namespace Gelateria\Apps\Shop\Console\Commands;

use Gelateria\Shop\Gelati\Application\Services\FlavorFinder;
use Gelateria\Shop\Gelati\Domain\Exceptions\FlavorNotFound;
use Gelateria\Shop\Orders\Application\Services\EarningsCalculator;
use Gelateria\Shop\Shared\Domain\Values\FlavorId;

use InvalidArgumentException;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class GetEarningsCommand extends Command
{
    protected static $defaultName = 'app:show-earnings';

    public function __construct(
        private FlavorFinder $flavorFinder,
        private EarningsCalculator $earningsCalculator
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
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $flavorId = new FlavorId($input->getArgument('flavor'));
        } catch (InvalidArgumentException $e) {
            $output->writeln($e->getMessage());
            return Command::INVALID;
        }

        try {
            $this->flavorFinder->find($flavorId);
        } catch (FlavorNotFound) {
            $output->writeln('The gelato flavor should be vanilla, pistachio or stracciatella.');
            return Command::INVALID;
        }

        $earnings = $this->earningsCalculator->calculate($flavorId);
        $output->writeln("You have earned {$earnings}");
        return Command::SUCCESS;
    }
}
