<?php

declare(strict_types=1);

namespace Gelateria\Shared\Kernel\Domain\Values;

abstract class Text extends Value
{
    protected string $value;

    public function __construct(string $value)
    {
        $value = $this->sanitize($value);
        $this->validate($value);
        $this->value = $value;
    }

    final public function value(): string
    {
        return $this->value;
    }

    protected function sanitize(string $value): string
    {
        return $value;
    }

    protected function validate(string $value): void
    {
    }
}