<?php

declare(strict_types=1);

namespace Gelateria\Shop\Gelati\Domain\Exceptions;

use Gelateria\Shop\Shared\Domain\Values\FlavorId;
use Gelateria\Shared\Kernel\Domain\Exceptions\NotFoundError;

/**
 * @extends NotFoundError<FlavorId>
 */
final class FlavorNotFound extends NotFoundError
{
    public function errorCode(): string
    {
        return 'shop_flavor_not_found';
    }

    protected function errorMessage(): string
    {
        return "Flavor <{$this->key()}> has not been found";
    }
}