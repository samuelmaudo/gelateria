<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Shared\Kernel\Domain\Collections;

use GetWith\CoffeeMachine\Shared\Kernel\Domain\Exceptions\ImmutableObjectError;

use ArrayAccess;
use ArrayIterator;
use Countable;
use InvalidArgumentException;
use Iterator;
use IteratorAggregate;

/**
 * @template T
 */
abstract class Collection implements ArrayAccess, Countable, IteratorAggregate
{
    /**
     * @var array<T>
     */
    protected array $items;

    /**
     * @param  iterable<T>  $items
     */
    public function __construct(iterable $items)
    {
        $items = $this->sanitize($items);
        $this->validate($items);
        $this->items = $items;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * @return Iterator<T>
     */
    public function getIterator(): Iterator
    {
        return new ArrayIterator($this->items);
    }

    /**
     * @param  int  $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return isset($this->items[$offset]);
    }

    /**
     * @param  int  $offset
     * @return T
     */
    public function offsetGet($offset): mixed
    {
        return $this->items[$offset];
    }

    /**
     * @param  int  $offset
     * @param  T  $value
     * @return void
     *
     * @throws ImmutableObjectError
     */
    public function offsetSet($offset, $value): void
    {
        throw new ImmutableObjectError($this);
    }

    /**
     * @param  int  $offset
     * @return void
     *
     * @throws ImmutableObjectError
     */
    public function offsetUnset($offset): void
    {
        throw new ImmutableObjectError($this);
    }

    /**
     * @return class-string
     */
    abstract public function type(): string;

    /**
     * @param  iterable<T>  $items
     * @return array<T>
     */
    protected function sanitize(iterable $items): array
    {
        if (is_array($items)) {
            return $items;
        }

        return iterator_to_array($items);
    }

    /**
     * @param  array<T>  $items
     * @return void
     *
     * @throws InvalidArgumentException
     */
    protected function validate(array $items): void
    {
        $type = $this->type();

        foreach ($items as $item) {
            if (! $item instanceof $type) {
                $class = $this::class;
                throw new InvalidArgumentException(
                    "{$class} can only content instances of {$type}"
                );
            }
        }
    }
}