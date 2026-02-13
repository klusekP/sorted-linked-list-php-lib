<?php

declare(strict_types=1);

namespace SortedLinkedList\Validation;

use InvalidArgumentException;
use SortedLinkedList\Enum\Type;

/**
 * @implements TypeValidatorInterface<string>
 */
class StringValidator implements TypeValidatorInterface
{
    public function validate(mixed $value): void
    {
        if (! is_string($value)) {
            throw new InvalidArgumentException(sprintf('Value must be string, %s given', gettype($value)));
        }
    }

    public function getSupportedType(): Type
    {
        return Type::STRING;
    }
}
