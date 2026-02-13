<?php

declare(strict_types=1);

namespace SortedLinkedList\Comparator;

/**
 * @implements ComparatorInterface<int>
 */
class IntComparator implements ComparatorInterface
{
    public function compare(mixed $a, mixed $b): int
    {
        return $a <=> $b;
    }
}
