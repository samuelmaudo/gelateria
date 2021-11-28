<?php

declare(strict_types=1);

namespace Gelateria\Shop\Gelati\Domain\Entities;

use Gelateria\Shop\Gelati\Domain\Values\GelatoPrice;
use Gelateria\Shop\Shared\Domain\Values\GelatoId;
use Gelateria\Shared\Kernel\Domain\Entities\Entity;

final class Gelato extends Entity
{
    public function __construct(
        private GelatoId $id,
        private GelatoPrice $price
    ) {
    }

    public function id(): GelatoId
    {
        return $this->id;
    }

    public function price(): GelatoPrice
    {
        return $this->price;
    }

    public static function fromPrimitives(
        string $id,
        float|int|string $price
    ): self {
        return new self(
            new GelatoId($id),
            new GelatoPrice($price)
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