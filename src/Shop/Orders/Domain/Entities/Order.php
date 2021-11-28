<?php

declare(strict_types=1);

namespace Gelateria\Shop\Orders\Domain\Entities;

use Gelateria\Shop\Orders\Domain\Values\OrderSyrup;
use Gelateria\Shop\Orders\Domain\Values\OrderGivenMoney;
use Gelateria\Shop\Orders\Domain\Values\OrderReturnedMoney;
use Gelateria\Shop\Orders\Domain\Values\OrderScoops;
use Gelateria\Shop\Orders\Domain\Values\OrderTotal;
use Gelateria\Shop\Shared\Domain\Values\FlavorId;
use Gelateria\Shop\Shared\Domain\Values\OrderId;
use Gelateria\Shared\Kernel\Domain\Entities\Entity;

final class Order extends Entity
{
    public function __construct(
        private OrderId $id,
        private FlavorId $flavorId,
        private OrderScoops $scoops,
        private OrderSyrup $syrup,
        private OrderTotal $total,
        private OrderGivenMoney $givenMoney,
        private OrderReturnedMoney $returnedMoney
    ) {
    }

    public function id(): OrderId
    {
        return $this->id;
    }

    public function flavorId(): FlavorId
    {
        return $this->flavorId;
    }

    public function scoops(): OrderScoops
    {
        return $this->scoops;
    }

    public function syrup(): OrderSyrup
    {
        return $this->syrup;
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
        string $flavorId,
        int|string $scoops,
        bool|string $syrup,
        float|int|string $total,
        float|int|string $givenMoney,
        float|int|string $returnedMoney
    ): self {
        return new self(
            new OrderId($id),
            new FlavorId($flavorId),
            new OrderScoops($scoops),
            new OrderSyrup($syrup),
            new OrderTotal($total),
            new OrderGivenMoney($givenMoney),
            new OrderReturnedMoney($returnedMoney)
        );
    }

    public function toPrimitives(): array
    {
        return [
            'id' => $this->id->value(),
            'flavorId' => $this->flavorId->value(),
            'scoops' => $this->scoops->value(),
            'syrup' => $this->syrup->value(),
            'total' => $this->total->value(),
            'givenMoney' => $this->givenMoney->value(),
            'returnedMoney' => $this->returnedMoney->value(),
        ];
    }
}