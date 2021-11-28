<?php

declare(strict_types=1);

namespace Gelateria\Shared\Kernel\Domain\Values;

use Gelateria\Shared\Kernel\Domain\Values\Traits\SupportsMembershipTests;

use Stringable;

abstract class Value implements Stringable
{
    use SupportsMembershipTests;

    public function __toString(): string
    {
        return (string) $this->value();
    }

    final public function is(mixed $other): bool
    {
        return is_object($other)
            && $other::class === static::class
            && $other == $this;
    }

    final public function isNot(mixed $other): bool
    {
        return !$this->is($other);
    }

    abstract public function value(): mixed;
}