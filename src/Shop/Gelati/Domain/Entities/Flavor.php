<?php

declare(strict_types=1);

namespace Gelateria\Shop\Gelati\Domain\Entities;

use Gelateria\Shop\Gelati\Domain\Values\FlavorPrice;
use Gelateria\Shop\Shared\Domain\Values\FlavorId;
use Gelateria\Shared\Kernel\Domain\Entities\Entity;

final class Flavor extends Entity
{
    public function __construct(
        private FlavorId $id,
        private FlavorPrice $price
    ) {
    }

    public function id(): FlavorId
    {
        return $this->id;
    }

    public function price(): FlavorPrice
    {
        return $this->price;
    }

    public static function fromPrimitives(
        string $id,
        float|int|string $price
    ): self {
        return new self(
            new FlavorId($id),
            new FlavorPrice($price)
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