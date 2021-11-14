<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Machine\Drinks\Infrastructure\Repositories;

use GetWith\CoffeeMachine\Machine\Drinks\Domain\Entities\Drink;
use GetWith\CoffeeMachine\Machine\Drinks\Domain\Repositories\DrinkRepository;
use GetWith\CoffeeMachine\Machine\Shared\Domain\Values\DrinkId;

final class DummyDrinkRepository implements DrinkRepository
{
    private const DRINKS = [
        ['tea', 0.4],
        ['coffee', 0.5],
        ['chocolate', 0.6]
    ];

    private static bool $booted = False;

    /** @var array<string, Drink> */
    private static array $drinks = [];

    public function __construct()
    {
        if (!self::$booted) {
            self::boot();
        }
    }

    private function boot(): void
    {
        foreach (self::DRINKS as $primitives) {
            $key = $primitives[0];
            self::$drinks[$key] = Drink::fromPrimitives(...$primitives);
        }
    }

    public function find(DrinkId $drinkId): ?Drink
    {
        $key = $drinkId->value();

        return self::$drinks[$key] ?? null;
    }
}