<?php

declare(strict_types=1);

namespace Gelateria\Shop\Orders\Application\Services;

use Gelateria\Shop\Orders\Domain\Repositories\OrderRepository;
use Gelateria\Shop\Shared\Domain\Values\GelatoId;

final class EarningsCalculator
{
    public function __construct(private OrderRepository $repository)
    {
    }

    public function calculate(GelatoId $gelatoId): float
    {
        return $this->repository->sumTotalsByGelato($gelatoId);
    }
}