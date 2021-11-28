<?php

declare(strict_types=1);

namespace Gelateria\Shop\Gelati\Application\Services;

use Gelateria\Shop\Gelati\Domain\Collections\Gelati;
use Gelateria\Shop\Gelati\Domain\Repositories\GelatoRepository;

final class GelatoSearcher
{
    public function __construct(private GelatoRepository $repository)
    {
    }

    public function search(): Gelati
    {
        return $this->repository->search();
    }
}