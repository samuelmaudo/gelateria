<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Apps\Machine\Console\Tests\Commands;

use GetWith\CoffeeMachine\Apps\Machine\Console\Commands\GetEarningsCommand;
use GetWith\CoffeeMachine\Apps\Machine\Console\Tests\Shared\IntegrationTestCase;
use GetWith\CoffeeMachine\Machine\Drinks\Domain\Repositories\DrinkRepository;
use GetWith\CoffeeMachine\Machine\Orders\Domain\Entities\Order;
use GetWith\CoffeeMachine\Machine\Orders\Domain\Repositories\OrderRepository;
use GetWith\CoffeeMachine\Machine\Shared\Domain\Values\DrinkId;

use Ramsey\Uuid\Uuid as RamseyUuid;
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
        $this->seedOrders($drinkType, $orders);

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

    protected function seedOrders(string $drinkType, int $orders)
    {
        /** @var DrinkRepository $drinkRepository */
        $drinkRepository = $this->container->get(DrinkRepository::class);

        $drink = $drinkRepository->find(new DrinkId($drinkType));

        /** @var OrderRepository $orderRepository */
        $orderRepository = $this->container->get(OrderRepository::class);

        $sugars = 0;
        $extraHot = false;
        $total = $drink->price()->value();
        $givenMoney = 1.0;
        $returnedMoney = $givenMoney - $total;

        for ($i = 0; $i < $orders; $i++) {
            $orderRepository->save(Order::fromPrimitives(
                RamseyUuid::uuid4()->toString(),
                $drinkType,
                $sugars,
                $extraHot,
                $total,
                $givenMoney,
                $returnedMoney,
            ));
        }
    }
}
