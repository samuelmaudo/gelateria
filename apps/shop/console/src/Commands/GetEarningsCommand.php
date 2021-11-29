<?php

declare(strict_types=1);

namespace Gelateria\Apps\Shop\Console\Commands;

use Gelateria\Shop\Gelati\Domain\Exceptions\FlavorNotFound;
use Gelateria\Shop\Orders\Application\Services\EarningsCalculator;

use InvalidArgumentException;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class GetEarningsCommand extends Command
{
    protected static $defaultName = 'show-earnings';

    public function __construct(private EarningsCalculator $earningsCalculator)
    {
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
        $flavorId = $input->getArgument('flavor');

        try {
            $earnings = $this->earningsCalculator->calculate($flavorId);
        } catch (FlavorNotFound $e) {
            $output->writeln("We do not make {$e->key()} gelati");
            return Command::INVALID;
        } catch (InvalidArgumentException $e) {
            $output->writeln($e->getMessage());
            return Command::INVALID;
        }

        $output->writeln("We have earned {$earnings}");
        return Command::SUCCESS;
    }
}
