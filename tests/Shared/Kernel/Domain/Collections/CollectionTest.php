<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Tests\Shared\Kernel\Domain\Collections;

use BadMethodCallException;
use GetWith\CoffeeMachine\Shared\Kernel\Domain\Collections\Collection;
use GetWith\CoffeeMachine\Shared\Kernel\Domain\Values\Text as AbstractText;

use InvalidArgumentException;

use PHPUnit\Framework\TestCase;

class Text extends AbstractText
{
}

/**
 * @extends Collection<Text>
 */
class TextCollection extends Collection
{
    public function type(): string
    {
        return Text::class;
    }
}

class CollectionTest extends TestCase
{
    protected Text $a;
    protected Text $b;
    protected Text $c;

    /** @var Text[] */
    protected array $items;

    protected TextCollection $coll;

    public function setUp(): void
    {
        parent::setUp();

        $this->a = new Text('a');
        $this->b = new Text('b');
        $this->c = new Text('c');

        $this->items = [$this->a, $this->b, $this->c];

        $this->coll = new TextCollection($this->items);
    }

    public function testCollections(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new TextCollection(['a', 'b', 'c']);
    }

    public function testCount(): void
    {
        $this->assertCount(3, $this->coll);
    }

    public function testIteration(): void
    {
        $this->assertEquals($this->items, iterator_to_array($this->coll));
    }

    public function testArrayAccess(): void
    {
        $this->assertTrue(isset($this->coll[0]));
        $this->assertTrue($this->a->is($this->coll[0]));
        $this->assertTrue(isset($this->coll[1]));
        $this->assertTrue($this->b->is($this->coll[1]));
        $this->assertTrue(isset($this->coll[2]));
        $this->assertTrue($this->c->is($this->coll[2]));
        $this->assertFalse(isset($this->coll[3]));
    }

    public function testImmutability(): void
    {
        $this->expectException(BadMethodCallException::class);

        unset($this->coll[2]);
    }
}
