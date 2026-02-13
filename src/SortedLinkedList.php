<?php

declare(strict_types=1);

namespace SortedLinkedList;

use SortedLinkedList\Comparator\ComparatorInterface;
use SortedLinkedList\Iterator\ListIterator;
use SortedLinkedList\Validation\TypeValidatorInterface;

/**
 * @template T of int|string
 * @implements SortedListInterface<T>
 */
class SortedLinkedList implements SortedListInterface
{
    /**
     * @var Node<T>|null
     */
    private ?Node $head = null;

    /**
     * @var TypeValidatorInterface<T>
     */
    private TypeValidatorInterface $validator;

    /**
     * @var ComparatorInterface<T>
     */
    private ComparatorInterface $comparator;

    /**
     * @param TypeValidatorInterface<T> $validator
     * @param ComparatorInterface<T> $comparator
     */
    public function __construct(TypeValidatorInterface $validator, ComparatorInterface $comparator)
    {
        $this->validator = $validator;
        $this->comparator = $comparator;
    }

    public function add(mixed $value): void
    {
        $this->validator->validate($value);

        $newNode = new Node($value);

        if ($this->head === null) {
            $this->head = $newNode;

            return;
        }

        if ($this->comparator->compare($value, $this->head->value) < 0) {
            $newNode->next = $this->head;
            $this->head = $newNode;

            return;
        }

        $current = $this->head;
        while ($current->next !== null
               && $this->comparator->compare($value, $current->next->value) >= 0) {
            $current = $current->next;
        }

        $newNode->next = $current->next;
        $current->next = $newNode;
    }

    public function remove(mixed $value): bool
    {
        $this->validator->validate($value);

        if ($this->head === null) {
            return false;
        }

        if ($this->head->value === $value) {
            $this->head = $this->head->next;

            return true;
        }

        $current = $this->head;
        while ($current->next !== null) {
            if ($current->next->value === $value) {
                $current->next = $current->next->next;

                return true;
            }
            $current = $current->next;
        }

        return false;
    }

    public function contains(mixed $value): bool
    {
        $this->validator->validate($value);

        $current = $this->head;
        while ($current !== null) {
            if ($current->value === $value) {
                return true;
            }
            if ($this->comparator->compare($current->value, $value) > 0) {
                return false;
            }
            $current = $current->next;
        }

        return false;
    }

    public function toArray(): array
    {
        $result = [];
        $current = $this->head;
        while ($current !== null) {
            $result[] = $current->value;
            $current = $current->next;
        }

        return $result;
    }

    public function first(): mixed
    {
        return $this->head?->value;
    }

    public function last(): mixed
    {
        if ($this->head === null) {
            return null;
        }

        $current = $this->head;
        while ($current->next !== null) {
            $current = $current->next;
        }

        return $current->value;
    }

    public function isEmpty(): bool
    {
        return $this->head === null;
    }

    public function count(): int
    {
        $count = 0;
        $current = $this->head;
        while ($current !== null) {
            ++$count;
            $current = $current->next;
        }

        return $count;
    }

    public function clear(): void
    {
        $this->head = null;
    }

    /**
     * @return ListIterator<T>
     */
    public function getIterator(): \Iterator
    {
        return new ListIterator($this->head);
    }
}
