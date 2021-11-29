<?php

declare(strict_types=1);

namespace Gelateria\Apps\Shop\Console\Tests\Commands;

use Gelateria\Apps\Shop\Console\Commands\GetEarningsCommand;
use Gelateria\Apps\Shop\Console\Tests\Shared\IntegrationTestCase;
use Gelateria\Shop\Gelati\Domain\Repositories\FlavorRepository;
use Gelateria\Shop\Orders\Domain\Entities\Order;
use Gelateria\Shop\Orders\Domain\Repositories\OrderRepository;
use Gelateria\Shop\Shared\Domain\Values\FlavorId;

use Ramsey\Uuid\Uuid as RamseyUuid;
use Symfony\Component\Console\Tester\CommandTester;

class GetEarningsCommandTest extends IntegrationTestCase
{
    /**
     * @dataProvider resultsProvider
     */
    public function testGelateriaReturnsTheExpectedOutput(
        string $flavor,
        int $orders,
        string $expectedOutput
    ): void {
        $this->seedOrders($flavor, $orders);

        /** @var GetEarningsCommand $command */
        $command = $this->application->find('show-earnings');

        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command' => $command->getName(),

            // pass arguments to the helper
            'flavor' => $flavor,
        ]);

        // the output of the command in the console
        $output = $commandTester->getDisplay();
        $this->assertSame($expectedOutput, $output);
    }

    public function resultsProvider(): array
    {
        return [
            [
                'vodka', 0, 'We do not make vodka gelati' . PHP_EOL,
            ],
            [
                'vanilla', 18, 'We have earned 14.4' . PHP_EOL,
            ],
            [
                'pistachio', 21, 'We have earned 25.2' . PHP_EOL,
            ],
            [
                'stracciatella', 36, 'We have earned 36' . PHP_EOL,
            ],
        ];
    }

    protected function seedOrders(string $flavorId, int $orders)
    {
        /** @var FlavorRepository $flavorRepository */
        $flavorRepository = $this->container->get(FlavorRepository::class);

        $flavor = $flavorRepository->find(new FlavorId($flavorId));

        if (null === $flavor) {
            return;
        }

        /** @var OrderRepository $orderRepository */
        $orderRepository = $this->container->get(OrderRepository::class);

        $scoops = 1;
        $syrup = false;
        $total = $flavor->price()->value();
        $givenMoney = 1.0;
        $returnedMoney = $givenMoney - $total;

        for ($i = 0; $i < $orders; $i++) {
            $orderRepository->save(Order::fromPrimitives(
                RamseyUuid::uuid4()->toString(),
                $flavorId,
                $scoops,
                $syrup,
                $total,
                $givenMoney,
                $returnedMoney,
            ));
        }
    }
}
