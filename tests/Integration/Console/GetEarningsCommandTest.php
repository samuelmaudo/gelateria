<?php

namespace GetWith\CoffeeMachine\Tests\Integration\Console;

use GetWith\CoffeeMachine\Console\GetEarningsCommand;
use GetWith\CoffeeMachine\Tests\Integration\IntegrationTestCase;

use Symfony\Component\Console\Tester\CommandTester;

class GetEarningsCommandTest extends IntegrationTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->application->add(new GetEarningsCommand());
    }

    /**
     * @dataProvider resultsProvider
     * @param  string  $drinkType
     * @param  string  $expectedOutput
     */
    public function testCoffeeMachineReturnsTheExpectedOutput(
        string $drinkType,
        string $expectedOutput
    ): void {
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
                'tea', 'You have earned £15' . PHP_EOL,
            ],
            [
                'coffee', 'You have earned £25.75' . PHP_EOL,
            ],
            [
                'chocolate', 'You have earned £36' . PHP_EOL,
            ],
        ];
    }
}
