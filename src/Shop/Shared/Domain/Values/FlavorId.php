<?php

declare(strict_types=1);

namespace Gelateria\Shop\Shared\Domain\Values;

use Gelateria\Shared\Kernel\Domain\Values\Text;

final class FlavorId extends Text
{
    protected function sanitize(string $value): string
    {
        return strtolower(parent::sanitize($value));
    }
}