<?php

declare(strict_types=1);

namespace SortedLinkedList;

/**
 * @template T of int|string
 */
interface SortedListInterface extends \Countable
{
    /**
     * @param T $value
     */
    public function add(mixed $value): void;

    /**
     * @param T $value
     */
    public function remove(mixed $value): bool;

    /**
     * @param T $value
     */
    public function contains(mixed $value): bool;

    /**
     * @return array<int, T>
     */
    public function toArray(): array;

    /**
     * @return T|null
     */
    public function first(): mixed;

    /**
     * @return T|null
     */
    public function last(): mixed;

    public function isEmpty(): bool;

    public function clear(): void;

    /**
     * @return \Iterator<int, T>
     */
    public function getIterator(): \Iterator;
}
