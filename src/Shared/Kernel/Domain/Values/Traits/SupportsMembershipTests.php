<?php

declare(strict_types=1);

namespace Gelateria\Shared\Kernel\Domain\Values\Traits;

trait SupportsMembershipTests
{
    final public function in(iterable $other): bool
    {
        foreach ($other as $item) {
            if ($this->is($item)) {
                return true;
            }
        }

        return false;
    }

    final public function notIn(iterable $other): bool
    {
        return !$this->in($other);
    }
}