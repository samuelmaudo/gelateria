<?php

declare(strict_types=1);

namespace Gelateria\Tests\Shop\Orders\Application\Services;

use Gelateria\Shop\Gelati\Domain\Entities\Gelato;
use Gelateria\Shop\Orders\Application\Services\OrderCreator;
use Gelateria\Shop\Orders\Domain\Entities\Order;
use Gelateria\Shop\Orders\Domain\Repositories\OrderRepository;
use Gelateria\Shop\Orders\Domain\Values\OrderSyrup;
use Gelateria\Shop\Orders\Domain\Values\OrderGivenMoney;
use Gelateria\Shop\Orders\Domain\Values\OrderScoops;
use Gelateria\Shop\Orders\Infrastructure\Repositories\DummyOrderRepository;

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
        $gelato = Gelato::fromPrimitives('stracciatella', 0.6);
        $scoops = new OrderScoops(1);
        $syrup = new OrderSyrup(true);

        $order = $this->service->create($money, $gelato, $scoops, $syrup);

        $this->assertInstanceOf(Order::class, $order);

        $this->assertEquals('stracciatella', $order->gelatoId()->value());
        $this->assertEquals(1, $order->scoops()->value());
        $this->assertEquals(true, $order->syrup()->value());
        $this->assertEquals(0.6, $order->total()->value());
        $this->assertEquals(1.0, $order->givenMoney()->value());
        $this->assertEquals(0.4, $order->returnedMoney()->value());

        $this->assertTrue($order->gelatoId()->is($gelato->id()));
        $this->assertTrue($order->scoops()->is($scoops));
        $this->assertTrue($order->syrup()->is($syrup));
        $this->assertTrue($order->total()->eq(0.6));
        $this->assertTrue($order->givenMoney()->is($money));
        $this->assertTrue($order->returnedMoney()->eq(0.4));
    }

    public function testInvalidOrder(): void
    {
        $money = new OrderGivenMoney(0.5);
        $gelato = Gelato::fromPrimitives('stracciatella', 0.6);
        $scoops = new OrderScoops(1);
        $syrup = new OrderSyrup(true);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The stracciatella costs 0.6');

        $this->service->create($money, $gelato, $scoops, $syrup);
    }
}