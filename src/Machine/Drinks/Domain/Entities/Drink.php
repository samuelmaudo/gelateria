<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Machine\Drinks\Domain\Entities;

use GetWith\CoffeeMachine\Machine\Drinks\Domain\Values\DrinkPrice;
use GetWith\CoffeeMachine\Machine\Shared\Domain\Values\DrinkId;
use GetWith\CoffeeMachine\Shared\Kernel\Domain\Entities\Entity;

final class Drink extends Entity
{
    public function __construct(
        private DrinkId $id,
        private DrinkPrice $price
    ) {
    }

    public function id(): DrinkId
    {
        return $this->id;
    }

    public function price(): DrinkPrice
    {
        return $this->price;
    }

    public static function fromPrimitives(
        string $id,
        float|int|string $price
    ): self {
        return new self(
            new DrinkId($id),
            new DrinkPrice($price)
        );
    }

    public function toPrimitives(): array
    {
        return [
            'id' => $this->id->value(),
            'price' => $this->price->value(),
        ];
    }
}