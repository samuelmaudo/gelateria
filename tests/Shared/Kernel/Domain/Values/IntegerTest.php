<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Tests\Shared\Kernel\Domain\Values;

use GetWith\CoffeeMachine\Shared\Kernel\Domain\Values\Integer as AbstractInteger;

use InvalidArgumentException;
use TypeError;

use PHPUnit\Framework\TestCase;

class Integer extends AbstractInteger
{
}

class IntegerTest extends TestCase
{
    public function testIntegers(): void
    {
        $this->assertEquals(1, (new Integer(1))->value());
        $this->assertEquals(0, (new Integer(0))->value());
    }

    public function testValidStrings(): void
    {
        $this->assertEquals(1, (new Integer('1'))->value());
        $this->assertEquals(0, (new Integer('0'))->value());
    }

    public function testInvalidStrings(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Integer('foo');
    }

    public function testBooleans(): void
    {
        $this->expectException(TypeError::class);

        new Integer(true);
    }

    public function testFloats(): void
    {
        $this->expectException(TypeError::class);

        new Integer(1.0);
    }

    public function testOtherValues(): void
    {
        $this->expectException(TypeError::class);

        new Integer([]);
    }

    public function testConversionToString(): void
    {
        $this->assertEquals('1', (string) (new Integer(1)));
        $this->assertEquals('0', (string) (new Integer(0)));
    }
}
