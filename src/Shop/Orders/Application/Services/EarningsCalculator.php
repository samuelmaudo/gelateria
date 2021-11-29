<?php

declare(strict_types=1);

namespace Gelateria\Shop\Orders\Application\Services;

use Gelateria\Shop\Gelati\Application\Services\FlavorFinder;
use Gelateria\Shop\Orders\Domain\Repositories\OrderRepository;

final class EarningsCalculator
{
    public function __construct(
        private FlavorFinder $flavorFinder,
        private OrderRepository $repository
    ) {
    }

    public function calculate(string $id): float
    {
        $flavor = $this->flavorFinder->find($id);

        return $this->repository->sumTotalsByFlavor($flavor->id());
    }
}