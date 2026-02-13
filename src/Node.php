<?php

declare(strict_types=1);

namespace SortedLinkedList;

/**
 * @template T
 */
class Node
{
    /**
     * @param T $value
     * @param Node<T>|null $next
     */
    public function __construct(
        public mixed $value,
        public ?self $next = null
    ) {
    }
}
