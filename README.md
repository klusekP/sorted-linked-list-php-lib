# SortedLinkedList

A PHP library implementing a sorted linked list with full SOLID compliance and type safety.

![CI](https://github.com/yourusername/sortedlinkedlist/workflows/CI/badge.svg)

## Installation

```bash
composer require sortedlinkedlist/sortedlinkedlist
```

## Usage

### Basic Usage

```php
use SortedLinkedList\SortedLinkedListFactory;

// Create integer list
$intList = SortedLinkedListFactory::createIntList();
$intList->add(5);
$intList->add(3);
$intList->add(8);

echo implode(', ', $intList->toArray()); // Output: 3, 5, 8

// Create string list
$stringList = SortedLinkedListFactory::createStringList();
$stringList->add('Poland');
$stringList->add('Germany');
$stringList->add('France');

echo implode(', ', $stringList->toArray()); // Output: France, Germany, Poland
```

## Running Tests

### All Checks

```bash
composer check
```

### Individual Checks

```bash
# Code style check
./vendor/bin/ecs check

# Fix code style issues
./vendor/bin/ecs check --fix

# Static analysis
./vendor/bin/phpstan analyse

# Unit tests
./vendor/bin/phpunit

# Mutation testing
./vendor/bin/infection
```

### Continuous Integration

This project uses GitHub Actions for continuous integration. The CI pipeline runs on PHP 8.3 and includes:

- Code style checks (ECS)
- Static analysis (PHPStan level 9)
- Unit tests (PHPUnit)
- Mutation testing (Infection)

The CI workflow is defined in `.github/workflows/ci.yml`.
