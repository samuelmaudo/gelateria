<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Shared\Domain\Values;

abstract class Text extends Value
{
    public function __construct(protected string $value)
    {
    }

    public function value(): string
    {
        return $this->value;
    }
}