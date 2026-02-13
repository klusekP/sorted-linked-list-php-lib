<?php

declare(strict_types=1);

namespace SortedLinkedList\Validation;

use InvalidArgumentException;
use SortedLinkedList\Enum\Type;

/**
 * @implements TypeValidatorInterface<int>
 */
class IntValidator implements TypeValidatorInterface
{
    public function validate(mixed $value): void
    {
        if (! is_int($value)) {
            throw new InvalidArgumentException(sprintf('Value must be int, %s given', gettype($value)));
        }
    }

    public function getSupportedType(): Type
    {
        return Type::INT;
    }
}
