<?php

declare(strict_types=1);

namespace Gelateria\Shop\Gelati\Infrastructure\Repositories;

use Gelateria\Shop\Gelati\Domain\Collections\Gelati;
use Gelateria\Shop\Gelati\Domain\Entities\Gelato;
use Gelateria\Shop\Gelati\Domain\Repositories\GelatoRepository;
use Gelateria\Shop\Shared\Domain\Values\GelatoId;

final class DummyGelatoRepository implements GelatoRepository
{
    private const GELATI = [
        ['vanilla', 0.4],
        ['pistachio', 0.5],
        ['stracciatella', 0.6]
    ];

    private static bool $booted = False;

    /** @var array<string, Gelato> */
    private static array $gelati = [];

    public function __construct()
    {
        if (!self::$booted) {
            self::boot();
        }
    }

    private function boot(): void
    {
        foreach (self::GELATI as $primitives) {
            $key = $primitives[0];
            self::$gelati[$key] = Gelato::fromPrimitives(...$primitives);
        }
    }

    public function find(GelatoId $id): ?Gelato
    {
        $key = $id->value();

        return self::$gelati[$key] ?? null;
    }

    public function search(): Gelati
    {
        return new Gelati(self::$gelati);
    }
}