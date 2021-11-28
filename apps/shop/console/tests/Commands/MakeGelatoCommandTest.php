<?php

declare(strict_types=1);

namespace Gelateria\Apps\Shop\Console\Tests\Commands;

use Gelateria\Apps\Shop\Console\Commands\MakeGelatoCommand;
use Gelateria\Apps\Shop\Console\Tests\Shared\IntegrationTestCase;

use Symfony\Component\Console\Tester\CommandTester;

class MakeGelatoCommandTest extends IntegrationTestCase
{
    /**
     * @dataProvider ordersProvider
     */
    public function testGelateriaReturnsTheExpectedOutput(
        string $flavor,
        string $money,
        int $scoops,
        bool $syrup,
        string $expectedOutput
    ): void {
        /** @var MakeGelatoCommand $command */
        $command = $this->application->find('app:order-gelato');

        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command' => $command->getName(),

            // pass arguments to the helper
            'flavor' => $flavor,
            'money' => $money,
            'scoops' => $scoops,
            '--syrup' => $syrup,
        ]);

        // the output of the command in the console
        $output = $commandTester->getDisplay();
        $this->assertSame($expectedOutput, $output);
    }

    public function ordersProvider(): array
    {
        return [
            [
                'stracciatella', '0.7', 1, false, 'You have ordered a stracciatella gelato' . PHP_EOL,
            ],
            [
                'vanilla', '0.4', 1, true, 'You have ordered a vanilla gelato with syrup' . PHP_EOL,
            ],
            [
                'pistachio', '2', 2, true, 'You have ordered a pistachio gelato with 2 scoops and syrup' . PHP_EOL,
            ],
            [
                'pistachio', '0.2', 2, true, 'The pistachio costs 0.5.' . PHP_EOL,
            ],
            [
                'stracciatella', '0.3', 2, true, 'The stracciatella costs 0.6.' . PHP_EOL,
            ],
            [
                'vanilla', '0.1', 2, true, 'The vanilla costs 0.4.' . PHP_EOL,
            ],
            [
                'vanilla', '0.5', -1, true, 'The number of scoops should be between 1 and 3.' . PHP_EOL,
            ],
            [
                'vanilla', '0.5', 4, true, 'The number of scoops should be between 1 and 3.' . PHP_EOL,
            ],
        ];
    }
}
