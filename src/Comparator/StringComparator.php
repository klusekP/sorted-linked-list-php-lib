<?php

declare(strict_types=1);

namespace SortedLinkedList\Comparator;

/**
 * @implements ComparatorInterface<string>
 */
class StringComparator implements ComparatorInterface
{
    public function compare(mixed $a, mixed $b): int
    {
        return strcmp((string) $a, (string) $b);
    }
}
