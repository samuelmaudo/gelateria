<?php

declare(strict_types=1);

namespace Gelateria\Tests\Shop\Orders\Application\Services;

use Gelateria\Shop\Gelati\Application\Services\FlavorFinder;
use Gelateria\Shop\Gelati\Domain\Exceptions\FlavorNotFound;
use Gelateria\Shop\Gelati\Infrastructure\Repositories\DummyFlavorRepository;
use Gelateria\Shop\Orders\Application\Services\OrderCreator;
use Gelateria\Shop\Orders\Domain\Entities\Order;
use Gelateria\Shop\Orders\Domain\Repositories\OrderRepository;
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

        $finder = new FlavorFinder(new DummyFlavorRepository());
        $this->service = new OrderCreator($finder, $this->repository);
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
        $money = 1.0;
        $flavorId = 'stracciatella';
        $scoops = 1;
        $syrup = true;

        $order = $this->service->create($money, $flavorId, $scoops, $syrup);

        $this->assertInstanceOf(Order::class, $order);

        $this->assertEquals('stracciatella', $order->flavorId()->value());
        $this->assertEquals(1, $order->scoops()->value());
        $this->assertEquals(true, $order->syrup()->value());
        $this->assertEquals(1.0, $order->total()->value());
        $this->assertEquals(1.0, $order->givenMoney()->value());
        $this->assertEquals(0.0, $order->returnedMoney()->value());

        $this->assertTrue($order->scoops()->eq($scoops));
        $this->assertTrue($order->syrup()->isTrue());
        $this->assertTrue($order->total()->eq(1.0));
        $this->assertTrue($order->givenMoney()->eq($money));
        $this->assertTrue($order->returnedMoney()->eq(0.0));
    }

    public function testInsufficientMoney(): void
    {
        $money = 0.5;
        $flavorId = 'stracciatella';
        $scoops = 1;
        $syrup = true;

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Your order costs 1');

        $this->service->create($money, $flavorId, $scoops, $syrup);
    }

    public function testMissingFlavor(): void
    {
        $money = 0.5;
        $flavorId = 'vodka';
        $scoops = 1;
        $syrup = true;

        $this->expectException(FlavorNotFound::class);
        $this->expectExceptionMessage('Flavor <vodka> has not been found');

        $this->service->create($money, $flavorId, $scoops, $syrup);
    }
}