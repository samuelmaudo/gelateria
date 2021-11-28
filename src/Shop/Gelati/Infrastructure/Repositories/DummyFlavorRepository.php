<?php

declare(strict_types=1);

namespace Gelateria\Shop\Gelati\Infrastructure\Repositories;

use Gelateria\Shop\Gelati\Domain\Collections\Flavors;
use Gelateria\Shop\Gelati\Domain\Entities\Flavor;
use Gelateria\Shop\Gelati\Domain\Repositories\FlavorRepository;
use Gelateria\Shop\Shared\Domain\Values\FlavorId;

final class DummyFlavorRepository implements FlavorRepository
{
    private const FLAVORS = [
        ['vanilla', 0.8],
        ['pistachio', 1.2],
        ['stracciatella', 1.0]
    ];

    private static bool $booted = False;

    /** @var array<string, Flavor> */
    private static array $gelati = [];

    public function __construct()
    {
        if (!self::$booted) {
            self::boot();
        }
    }

    private function boot(): void
    {
        foreach (self::FLAVORS as $primitives) {
            $key = $primitives[0];
            self::$gelati[$key] = Flavor::fromPrimitives(...$primitives);
        }
    }

    public function find(FlavorId $id): ?Flavor
    {
        $key = $id->value();

        return self::$gelati[$key] ?? null;
    }

    public function search(): Flavors
    {
        return new Flavors(self::$gelati);
    }
}