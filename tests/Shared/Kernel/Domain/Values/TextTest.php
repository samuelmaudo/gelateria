<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Tests\Shared\Kernel\Domain\Values;

use GetWith\CoffeeMachine\Shared\Kernel\Domain\Values\Text as AbstractText;

use TypeError;

use PHPUnit\Framework\TestCase;

class Text extends AbstractText
{
}

class TextTest extends TestCase
{
    public function testTexts(): void
    {
        $this->assertEquals('', (new Text(''))->value());
        $this->assertEquals('ABC', (new Text('ABC'))->value());
    }

    public function testBooleans(): void
    {
        $this->expectException(TypeError::class);

        new Text(true);
    }

    public function testIntegers(): void
    {
        $this->expectException(TypeError::class);

        new Text(1);
    }

    public function testFloats(): void
    {
        $this->expectException(TypeError::class);

        new Text(1.0);
    }

    public function testOtherValues(): void
    {
        $this->expectException(TypeError::class);

        new Text([]);
    }
}
