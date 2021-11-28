<?php

declare(strict_types=1);

namespace Gelateria\Shared\Kernel\Domain\Values;

use InvalidArgumentException;

abstract class Boolean extends Value
{
    protected const TRUE_VALUES = [true, 1, '1', 'true', 't', 'yes', 'y', 'on'];
    protected const FALSE_VALUES = [false, 0, '0', 'false', 'f', 'no', 'n', 'off'];

    protected bool $value;

    public function __construct(bool|int|string $value)
    {
        $this->value = $this->sanitize($value);
    }

    public function __toString(): string
    {
        return ($this->value()) ? 'true' : 'false';
    }

    final public function isTrue(): bool
    {
        return $this->value;
    }

    final public function isFalse(): bool
    {
        return !$this->value;
    }

    final public function value(): bool
    {
        return $this->value;
    }

    protected function sanitize(bool|int|string $value): bool
    {
        if (in_array($value, static::TRUE_VALUES, true)) {
            return true;
        }
        if (in_array($value, static::FALSE_VALUES, true)) {
            return false;
        }
        $val = var_export($value, true);
        throw new InvalidArgumentException("{$val} is not a valid boolean");
    }
}