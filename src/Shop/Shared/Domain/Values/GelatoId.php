<?php

declare(strict_types=1);

namespace Gelateria\Shop\Shared\Domain\Values;

use Gelateria\Shared\Kernel\Domain\Values\Text;

final class GelatoId extends Text
{
    protected function sanitize(string $value): string
    {
        return strtolower(parent::sanitize($value));
    }
}