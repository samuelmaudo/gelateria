<?php

declare(strict_types=1);

namespace Gelateria\Tests\Shared\Kernel\Domain\Values;

use Gelateria\Shared\Kernel\Domain\Values\Decimal as AbstractDecimal;

use InvalidArgumentException;
use TypeError;

use PHPUnit\Framework\TestCase;

class Decimal extends AbstractDecimal
{
}

class DecimalTest extends TestCase
{
    public function testDecimals(): void
    {
        $this->assertEquals(1.0, (new Decimal(1.0))->value());
        $this->assertEquals(0.1, (new Decimal(0.1))->value());
    }

    public function testIntegers(): void
    {
        $this->assertEquals(1.0, (new Decimal(1))->value());
        $this->assertEquals(0.0, (new Decimal(0))->value());
    }

    public function testValidStrings(): void
    {
        $this->assertEquals(1.0, (new Decimal('1.0'))->value());
        $this->assertEquals(0.1, (new Decimal('0.1'))->value());
    }

    public function testInvalidStrings(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Decimal('foo');
    }

    public function testBooleans(): void
    {
        $this->expectException(TypeError::class);

        new Decimal(true);
    }

    public function testOtherValues(): void
    {
        $this->expectException(TypeError::class);

        new Decimal([]);
    }

    public function testConversionToString(): void
    {
        $this->assertEquals('1', (string) (new Decimal(1.0)));
        $this->assertEquals('0.1', (string) (new Decimal(0.1)));
    }
}
