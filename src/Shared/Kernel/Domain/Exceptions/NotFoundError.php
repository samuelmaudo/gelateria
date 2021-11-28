<?php

declare(strict_types=1);

namespace Gelateria\Shared\Kernel\Domain\Exceptions;

/**
 * @template T
 */
abstract class NotFoundError extends DomainError
{
    /**
     * @param  T  $key
     */
    public function __construct(protected mixed $key)
    {
        parent::__construct();
    }

    /**
     * @return T
     */
    final public function key(): mixed
    {
        return $this->key;
    }
}