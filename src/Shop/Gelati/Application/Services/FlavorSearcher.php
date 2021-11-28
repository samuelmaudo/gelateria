<?php

declare(strict_types=1);

namespace Gelateria\Shop\Gelati\Application\Services;

use Gelateria\Shop\Gelati\Domain\Collections\Flavors;
use Gelateria\Shop\Gelati\Domain\Repositories\FlavorRepository;

final class FlavorSearcher
{
    public function __construct(private FlavorRepository $repository)
    {
    }

    public function search(): Flavors
    {
        return $this->repository->search();
    }
}