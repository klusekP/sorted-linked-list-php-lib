<?php

declare(strict_types=1);

namespace SortedLinkedList\Comparator;

/**
 * @template T of int|string
 */
interface ComparatorInterface
{
    /**
     * @param T $a
     * @param T $b
     */
    public function compare(mixed $a, mixed $b): int;
}
