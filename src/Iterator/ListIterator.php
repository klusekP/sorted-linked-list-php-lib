<?php

declare(strict_types=1);

namespace SortedLinkedList\Iterator;

use SortedLinkedList\Node;

/**
 * @template T of int|string
 *
 * @implements \Iterator<int, T>
 */
class ListIterator implements \Iterator
{
    /**
     * @var Node<T>|null
     */
    private ?Node $current;

    private int $position = 0;

    /**
     * @param Node<T>|null $head
     */
    public function __construct(?Node $head)
    {
        $this->current = $head;
    }

    /**
     * @return T|null
     */
    public function current(): mixed
    {
        return $this->current?->value;
    }

    public function key(): int
    {
        return $this->position;
    }

    public function next(): void
    {
        $this->current = $this->current?->next;
        ++$this->position;
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function valid(): bool
    {
        return $this->current !== null;
    }
}
