<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Tests\Machine\Orders\Application\Services;

use GetWith\CoffeeMachine\Machine\Orders\Application\Services\EarningsCalculator;
use GetWith\CoffeeMachine\Machine\Orders\Domain\Entities\Order;
use GetWith\CoffeeMachine\Machine\Orders\Domain\Repositories\OrderRepository;
use GetWith\CoffeeMachine\Machine\Orders\Infrastructure\Repositories\DummyOrderRepository;
use GetWith\CoffeeMachine\Machine\Shared\Domain\Values\DrinkId;
use GetWith\CoffeeMachine\Machine\Shared\Domain\Values\OrderId;

use TypeError;

use PHPUnit\Framework\TestCase;

class EarningsCalculatorTest extends TestCase
{
    protected ?EarningsCalculator $service;
    protected ?OrderRepository $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = new DummyOrderRepository();
        $this->service = new EarningsCalculator($this->repository);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        $this->service = null;
        $this->repository = null;
    }

    public function testExistingDrink(): void
    {
        $drinkId = new DrinkId('coffee');
        $result = $this->service->calculate($drinkId);

        $this->assertEquals(0, $result);
    }

    public function testMissingDrink(): void
    {
        $drinkId = new DrinkId('vodka');
        $result = $this->service->calculate($drinkId);

        $this->assertEquals(0, $result);
    }

    public function testInvalidKey(): void
    {
        $this->expectException(TypeError::class);

        $this->service->calculate('coffee');
    }

    public function testResults(): void
    {
        for ($i = 0; $i < 3; $i++) {
            $this->repository->save(Order::fromPrimitives(
                id: OrderId::random()->value(),
                drinkId: 'tea',
                sugars: 0,
                extraHot: false,
                total: 0.4,
                givenMoney: 0.5,
                returnedMoney: 0.1
            ));
        }

        $drinkId = new DrinkId('tea');
        $result = $this->service->calculate($drinkId);

        $this->assertEquals(1.2, $result);
    }
}