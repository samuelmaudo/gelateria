<?php

declare(strict_types=1);

namespace Gelateria\Shared\Kernel\Domain\Entities;

abstract class Entity
{
    public function identity(): mixed
    {
        return $this->id();
    }

    final public function is(mixed $other): bool
    {
        return is_object($other)
            && $other::class === static::class
            && $other->identity() == $this->identity();
    }

    final public function isNot(mixed $other): bool
    {
        return !$this->is($other);
    }
}