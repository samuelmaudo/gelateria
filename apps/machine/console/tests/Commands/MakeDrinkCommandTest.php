<?php

namespace GetWith\CoffeeMachine\Apps\Machine\Console\Tests\Commands;

use GetWith\CoffeeMachine\Apps\Machine\Console\Commands\MakeDrinkCommand;
use GetWith\CoffeeMachine\Apps\Machine\Console\Tests\Shared\IntegrationTestCase;

use Symfony\Component\Console\Tester\CommandTester;

class MakeDrinkCommandTest extends IntegrationTestCase
{
    /**
     * @dataProvider ordersProvider
     */
    public function testCoffeeMachineReturnsTheExpectedOutput(
        string $drinkType,
        string $money,
        int $sugars,
        bool $extraHot,
        string $expectedOutput
    ): void {
        /** @var MakeDrinkCommand $command */
        $command = $this->application->find('app:order-drink');

        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command' => $command->getName(),

            // pass arguments to the helper
            'drink-type' => $drinkType,
            'money' => $money,
            'sugars' => $sugars,
            '--extra-hot' => $extraHot,
        ]);

        // the output of the command in the console
        $output = $commandTester->getDisplay();
        $this->assertSame($expectedOutput, $output);
    }

    public function ordersProvider(): array
    {
        return [
            [
                'chocolate', '0.7', 1, false, 'You have ordered a chocolate with 1 sugars (stick included)' . PHP_EOL,
            ],
            [
                'tea', '0.4', 0, true, 'You have ordered a tea extra hot' . PHP_EOL,
            ],
            [
                'coffee', '2', 2, true, 'You have ordered a coffee extra hot with 2 sugars (stick included)' . PHP_EOL,
            ],
            [
                'coffee', '0.2', 2, true, 'The coffee costs 0.5.' . PHP_EOL,
            ],
            [
                'chocolate', '0.3', 2, true, 'The chocolate costs 0.6.' . PHP_EOL,
            ],
            [
                'tea', '0.1', 2, true, 'The tea costs 0.4.' . PHP_EOL,
            ],
            [
                'tea', '0.5', -1, true, 'The number of sugars should be between 0 and 2.' . PHP_EOL,
            ],
            [
                'tea', '0.5', 3, true, 'The number of sugars should be between 0 and 2.' . PHP_EOL,
            ],
        ];
    }
}
