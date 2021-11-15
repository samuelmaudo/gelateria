<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Tests\Machine\Orders\Application\Services;

use GetWith\CoffeeMachine\Machine\Drinks\Domain\Entities\Drink;
use GetWith\CoffeeMachine\Machine\Orders\Application\Services\OrderCreator;
use GetWith\CoffeeMachine\Machine\Orders\Domain\Entities\Order;
use GetWith\CoffeeMachine\Machine\Orders\Domain\Repositories\OrderRepository;
use GetWith\CoffeeMachine\Machine\Orders\Domain\Values\OrderExtraHot;
use GetWith\CoffeeMachine\Machine\Orders\Domain\Values\OrderGivenMoney;
use GetWith\CoffeeMachine\Machine\Orders\Domain\Values\OrderSugars;
use GetWith\CoffeeMachine\Machine\Orders\Infrastructure\Repositories\DummyOrderRepository;

use InvalidArgumentException;

use PHPUnit\Framework\TestCase;

class OrderCreatorTest extends TestCase
{
    protected ?OrderCreator $service;
    protected ?OrderRepository $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = new DummyOrderRepository();
        $this->service = new OrderCreator($this->repository);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        $this->repository->reset();

        $this->service = null;
        $this->repository = null;
    }

    public function testValidOrder(): void
    {
        $money = new OrderGivenMoney(1.0);
        $drink = Drink::fromPrimitives('chocolate', 0.6);
        $sugars = new OrderSugars(0);
        $extraHot = new OrderExtraHot(true);

        $order = $this->service->create($money, $drink, $sugars, $extraHot);

        $this->assertInstanceOf(Order::class, $order);

        $this->assertEquals('chocolate', $order->drinkId()->value());
        $this->assertEquals(0, $order->sugars()->value());
        $this->assertEquals(true, $order->extraHot()->value());
        $this->assertEquals(0.6, $order->total()->value());
        $this->assertEquals(1.0, $order->givenMoney()->value());
        $this->assertEquals(0.4, $order->returnedMoney()->value());

        $this->assertTrue($order->drinkId()->is($drink->id()));
        $this->assertTrue($order->sugars()->is($sugars));
        $this->assertTrue($order->extraHot()->is($extraHot));
        $this->assertTrue($order->total()->eq(0.6));
        $this->assertTrue($order->givenMoney()->is($money));
        $this->assertTrue($order->returnedMoney()->eq(0.4));
    }

    public function testInvalidOrder(): void
    {
        $money = new OrderGivenMoney(0.5);
        $drink = Drink::fromPrimitives('chocolate', 0.6);
        $sugars = new OrderSugars(0);
        $extraHot = new OrderExtraHot(true);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The chocolate costs 0.6');

        $this->service->create($money, $drink, $sugars, $extraHot);
    }
}