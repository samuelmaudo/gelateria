<?php

namespace GetWith\CoffeeMachine\Apps\Machine\Console\Tests\Commands;

use GetWith\CoffeeMachine\Apps\Machine\Console\Commands\GetEarningsCommand;
use GetWith\CoffeeMachine\Apps\Machine\Console\Commands\MakeDrinkCommand;
use GetWith\CoffeeMachine\Apps\Machine\Console\Tests\Shared\IntegrationTestCase;

use Symfony\Component\Console\Tester\CommandTester;

class GetEarningsCommandTest extends IntegrationTestCase
{
    /**
     * @dataProvider resultsProvider
     */
    public function testCoffeeMachineReturnsTheExpectedOutput(
        string $drinkType,
        int $orders,
        string $expectedOutput
    ): void {
        /** @var MakeDrinkCommand $command */
        $command = $this->application->find('app:order-drink');

        $commandTester = new CommandTester($command);
        for ($i = 0; $i < $orders; $i++) {
            $commandTester->execute([
                'command' => $command->getName(),

                // pass arguments to the helper
                'drink-type' => $drinkType,
                'money' => '1.0',
                'sugars' => 0,
                '--extra-hot' => false,
            ]);
        }

        /** @var GetEarningsCommand $command */
        $command = $this->application->find('app:show-earnings');

        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command' => $command->getName(),

            // pass arguments to the helper
            'drink-type' => $drinkType,
        ]);

        // the output of the command in the console
        $output = $commandTester->getDisplay();
        $this->assertSame($expectedOutput, $output);
    }

    public function resultsProvider(): array
    {
        return [
            [
                'tea', 37, 'You have earned 14.8' . PHP_EOL,
            ],
            [
                'coffee', 51, 'You have earned 25.5' . PHP_EOL,
            ],
            [
                'chocolate', 60, 'You have earned 36' . PHP_EOL,
            ],
        ];
    }
}
