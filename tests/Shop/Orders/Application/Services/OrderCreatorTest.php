<?php

declare(strict_types=1);

namespace Gelateria\Tests\Shop\Orders\Application\Services;

use Gelateria\Shop\Gelati\Domain\Entities\Flavor;
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
        $flavor = Flavor::fromPrimitives('stracciatella', 1.0);
        $scoops = new OrderScoops(1);
        $syrup = new OrderSyrup(true);

        $order = $this->service->create($money, $flavor, $scoops, $syrup);

        $this->assertInstanceOf(Order::class, $order);

        $this->assertEquals('stracciatella', $order->flavorId()->value());
        $this->assertEquals(1, $order->scoops()->value());
        $this->assertEquals(true, $order->syrup()->value());
        $this->assertEquals(1.0, $order->total()->value());
        $this->assertEquals(1.0, $order->givenMoney()->value());
        $this->assertEquals(0.0, $order->returnedMoney()->value());

        $this->assertTrue($order->flavorId()->is($flavor->id()));
        $this->assertTrue($order->scoops()->is($scoops));
        $this->assertTrue($order->syrup()->is($syrup));
        $this->assertTrue($order->total()->eq(1.0));
        $this->assertTrue($order->givenMoney()->is($money));
        $this->assertTrue($order->returnedMoney()->eq(0.0));
    }

    public function testInvalidOrder(): void
    {
        $money = new OrderGivenMoney(0.5);
        $flavor = Flavor::fromPrimitives('stracciatella', 1.0);
        $scoops = new OrderScoops(1);
        $syrup = new OrderSyrup(true);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Your order costs 1');

        $this->service->create($money, $flavor, $scoops, $syrup);
    }
}