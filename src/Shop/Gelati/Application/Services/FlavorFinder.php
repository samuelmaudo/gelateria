<?php

declare(strict_types=1);

namespace Gelateria\Shop\Gelati\Application\Services;

use Gelateria\Shop\Gelati\Domain\Entities\Flavor;
use Gelateria\Shop\Gelati\Domain\Exceptions\FlavorNotFound;
use Gelateria\Shop\Gelati\Domain\Repositories\FlavorRepository;
use Gelateria\Shop\Shared\Domain\Values\FlavorId;

final class FlavorFinder
{
    public function __construct(private FlavorRepository $repository)
    {
    }

    public function find(string $id): Flavor
    {
        $flavor = $this->repository->find(new FlavorId($id));

        if (is_null($flavor)) {
            throw new FlavorNotFound($id);
        }

        return $flavor;
    }
}