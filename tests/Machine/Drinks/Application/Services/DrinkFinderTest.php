<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Tests\Machine\Drinks\Application\Services;

use GetWith\CoffeeMachine\Machine\Drinks\Application\Services\DrinkFinder;
use GetWith\CoffeeMachine\Machine\Drinks\Domain\Exceptions\DrinkNotFound;
use GetWith\CoffeeMachine\Machine\Drinks\Domain\Repositories\DrinkRepository;
use GetWith\CoffeeMachine\Machine\Drinks\Infrastructure\Repositories\DummyDrinkRepository;
use GetWith\CoffeeMachine\Machine\Shared\Domain\Values\DrinkId;

use TypeError;

use PHPUnit\Framework\TestCase;

class DrinkFinderTest extends TestCase
{
    protected ?DrinkFinder $service;
    protected ?DrinkRepository $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = new DummyDrinkRepository();
        $this->service = new DrinkFinder($this->repository);
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
        $drink = $this->service->find($drinkId);

        $this->assertTrue($drinkId->is($drink->id()));
    }

    public function testMissingDrink(): void
    {
        $this->expectException(DrinkNotFound::class);

        $drinkId = new DrinkId('vodka');
        $this->service->find($drinkId);
    }

    public function testInvalidKey(): void
    {
        $this->expectException(TypeError::class);

        $this->service->find('coffee');
    }
}
