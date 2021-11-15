<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Tests\Machine\Drinks\Application\Services;

use GetWith\CoffeeMachine\Machine\Drinks\Application\Services\DrinkSearcher;
use GetWith\CoffeeMachine\Machine\Drinks\Domain\Collections\Drinks;
use GetWith\CoffeeMachine\Machine\Drinks\Domain\Entities\Drink;
use GetWith\CoffeeMachine\Machine\Drinks\Domain\Repositories\DrinkRepository;
use GetWith\CoffeeMachine\Machine\Drinks\Infrastructure\Repositories\DummyDrinkRepository;

use PHPUnit\Framework\TestCase;

class DrinkSearcherTest extends TestCase
{
    protected ?DrinkSearcher $service;
    protected ?DrinkRepository $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = new DummyDrinkRepository();
        $this->service = new DrinkSearcher($this->repository);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        $this->service = null;
        $this->repository = null;
    }

    public function testResults(): void
    {
        $drinks = $this->service->search();

        $this->assertInstanceOf(Drinks::class, $drinks);
        $this->assertContainsOnlyInstancesOf(Drink::class, $drinks);

        $expected = ['tea', 'coffee', 'chocolate'];

        $actual = [];
        foreach ($drinks as $drink) {
            $actual[] = $drink->id()->value();
        }

        $this->assertSameSize($expected, $actual);
        $this->assertEmpty(array_diff($expected, $actual));
    }
}
