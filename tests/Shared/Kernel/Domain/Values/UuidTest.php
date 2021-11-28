<?php

declare(strict_types=1);

namespace Gelateria\Tests\Shared\Kernel\Domain\Values;

use Gelateria\Shared\Kernel\Domain\Values\Uuid as AbstractUuid;

use InvalidArgumentException;
use TypeError;

use PHPUnit\Framework\TestCase;

class Uuid extends AbstractUuid
{
}

class UuidTest extends TestCase
{
    public function testValidUuids(): void
    {
        $this->assertEquals(
            '123e4567-e89b-12d3-a456-426614174000',
            (new Uuid('123e4567-e89b-12d3-a456-426614174000'))->value()
        );
        $this->assertEquals(
            '{123e4567-e89b-12d3-a456-426652340000}',
            (new Uuid('{123e4567-e89b-12d3-a456-426652340000}'))->value()
        );
        $this->assertEquals(
            'urn:uuid:123e4567-e89b-12d3-a456-426655440000',
            (new Uuid('urn:uuid:123e4567-e89b-12d3-a456-426655440000'))->value()
        );
    }

    public function testInvalidUuids(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Uuid('ABC');
    }

    public function testOtherValues(): void
    {
        $this->expectException(TypeError::class);

        new Uuid(null);
    }
}
