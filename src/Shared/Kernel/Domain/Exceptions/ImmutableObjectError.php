<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Shared\Kernel\Domain\Exceptions;

use BadMethodCallException;
use Throwable;

class ImmutableObjectError extends BadMethodCallException
{
    public function __construct($object, Throwable $previous = null)
    {
        $class = $object::class;

        parent::__construct(
            message: "{$class} instances cannot be modified.",
            previous: $previous
        );
    }
}