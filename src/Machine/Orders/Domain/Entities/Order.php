<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Machine\Orders\Domain\Entities;

use GetWith\CoffeeMachine\Machine\Orders\Domain\Values\OrderExtraHot;
use GetWith\CoffeeMachine\Machine\Orders\Domain\Values\OrderGivenMoney;
use GetWith\CoffeeMachine\Machine\Orders\Domain\Values\OrderReturnedMoney;
use GetWith\CoffeeMachine\Machine\Orders\Domain\Values\OrderSugars;
use GetWith\CoffeeMachine\Machine\Orders\Domain\Values\OrderTotal;
use GetWith\CoffeeMachine\Machine\Shared\Domain\Values\DrinkId;
use GetWith\CoffeeMachine\Machine\Shared\Domain\Values\OrderId;
use GetWith\CoffeeMachine\Shared\Kernel\Domain\Entities\Entity;

final class Order extends Entity
{
    public function __construct(
        private OrderId $id,
        private DrinkId $drink,
        private OrderSugars $sugars,
        private OrderExtraHot $extraHot,
        private OrderTotal $total,
        private OrderGivenMoney $givenMoney,
        private OrderReturnedMoney $returnedMoney
    ) {
    }

    public function id(): OrderId
    {
        return $this->id;
    }

    public function drink(): DrinkId
    {
        return $this->drink;
    }

    public function sugars(): OrderSugars
    {
        return $this->sugars;
    }

    public function extraHot(): OrderExtraHot
    {
        return $this->extraHot;
    }

    public function total(): OrderTotal
    {
        return $this->total;
    }

    public function givenMoney(): OrderGivenMoney
    {
        return $this->givenMoney;
    }

    public function returnedMoney(): OrderReturnedMoney
    {
        return $this->returnedMoney;
    }

    public static function fromPrimitives(
        string $id,
        string $drink,
        int|string $sugars,
        bool|string $extraHot,
        float|int|string $total,
        float|int|string $givenMoney,
        float|int|string $returnedMoney
    ): self {
        return new self(
            new OrderId($id),
            new DrinkId($drink),
            new OrderSugars($sugars),
            new OrderExtraHot($extraHot),
            new OrderTotal($total),
            new OrderGivenMoney($givenMoney),
            new OrderReturnedMoney($returnedMoney)
        );
    }

    public function toPrimitives(): array
    {
        return [
            'id' => $this->id->value(),
            'drink' => $this->drink->value(),
            'sugars' => $this->sugars->value(),
            'extraHot' => $this->extraHot->value(),
            'total' => $this->total->value(),
            'givenMoney' => $this->givenMoney->value(),
            'returnedMoney' => $this->returnedMoney->value(),
        ];
    }
}