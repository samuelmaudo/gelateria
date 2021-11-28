<?php

declare(strict_types=1);

namespace Gelateria\Tests\Shared\Kernel\Domain\Values;

use Gelateria\Shared\Kernel\Domain\Values\Boolean as AbstractBoolean;

use InvalidArgumentException;
use TypeError;

use PHPUnit\Framework\TestCase;

class Boolean extends AbstractBoolean
{
}

class BooleanTest extends TestCase
{
    public function testBooleans(): void
    {
        $this->assertTrue((new Boolean(true))->value());
        $this->assertFalse((new Boolean(false))->value());
    }

    public function testValidIntegers(): void
    {
        $this->assertTrue((new Boolean(1))->value());
        $this->assertFalse((new Boolean(0))->value());
    }

    public function testInvalidIntegers(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Boolean(10);
    }

    public function testValidStrings(): void
    {
        $this->assertTrue((new Boolean('on'))->value());
        $this->assertFalse((new Boolean('off'))->value());
    }

    public function testInvalidStrings(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Boolean('foo');
    }

    public function testOtherValues(): void
    {
        $this->expectException(TypeError::class);

        new Boolean([]);
    }

    public function testConversionToString(): void
    {
        $this->assertEquals('true', (string) (new Boolean(true)));
        $this->assertEquals('false', (string) (new Boolean(false)));
    }
}
