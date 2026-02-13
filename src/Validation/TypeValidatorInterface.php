<?php

declare(strict_types=1);

namespace SortedLinkedList\Validation;

use SortedLinkedList\Enum\Type;

/**
 * @template T of int|string
 */
interface TypeValidatorInterface
{
    /**
     * @param T $value
     */
    public function validate(mixed $value): void;

    public function getSupportedType(): Type;
}
