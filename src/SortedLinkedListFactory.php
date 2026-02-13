<?php

declare(strict_types=1);

namespace SortedLinkedList;

use SortedLinkedList\Comparator\IntComparator;
use SortedLinkedList\Comparator\StringComparator;
use SortedLinkedList\Validation\IntValidator;
use SortedLinkedList\Validation\StringValidator;

class SortedLinkedListFactory
{
    /**
     * @return SortedLinkedList<int>
     */
    public static function createIntList(): SortedLinkedList
    {
        /** @var SortedLinkedList<int> */
        return new SortedLinkedList(new IntValidator(), new IntComparator());
    }

    /**
     * @return SortedLinkedList<string>
     */
    public static function createStringList(): SortedLinkedList
    {
        /** @var SortedLinkedList<string> */
        return new SortedLinkedList(new StringValidator(), new StringComparator());
    }
}
