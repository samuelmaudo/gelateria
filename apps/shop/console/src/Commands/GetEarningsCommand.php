<?php

declare(strict_types=1);

namespace Gelateria\Apps\Shop\Console\Commands;

use Gelateria\Shop\Gelati\Application\Services\GelatoFinder;
use Gelateria\Shop\Gelati\Domain\Exceptions\GelatoNotFound;
use Gelateria\Shop\Orders\Application\Services\EarningsCalculator;
use Gelateria\Shop\Shared\Domain\Values\GelatoId;

use InvalidArgumentException;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class GetEarningsCommand extends Command
{
    protected static $defaultName = 'app:show-earnings';

    public function __construct(
        private GelatoFinder $gelatoFinder,
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
            $gelatoId = new GelatoId($input->getArgument('flavor'));
        } catch (InvalidArgumentException $e) {
            $output->writeln($e->getMessage());
            return Command::INVALID;
        }

        try {
            $this->gelatoFinder->find($gelatoId);
        } catch (GelatoNotFound) {
            $output->writeln('The gelato flavor should be vanilla, pistachio or stracciatella.');
            return Command::INVALID;
        }

        $earnings = $this->earningsCalculator->calculate($gelatoId);
        $output->writeln("You have earned {$earnings}");
        return Command::SUCCESS;
    }
}
