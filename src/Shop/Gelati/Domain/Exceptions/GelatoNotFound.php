<?php

declare(strict_types=1);

namespace Gelateria\Shop\Gelati\Domain\Exceptions;

use Gelateria\Shop\Shared\Domain\Values\GelatoId;
use Gelateria\Shared\Kernel\Domain\Exceptions\NotFoundError;

/**
 * @extends NotFoundError<GelatoId>
 */
final class GelatoNotFound extends NotFoundError
{
    public function errorCode(): string
    {
        return 'shop_gelato_not_found';
    }

    protected function errorMessage(): string
    {
        return "Gelato <{$this->key()}> has not been found";
    }
}