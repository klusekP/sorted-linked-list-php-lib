<?php

declare(strict_types=1);

namespace SortedLinkedList\Tests;

use PHPUnit\Framework\TestCase;
use SortedLinkedList\Comparator\IntComparator;
use SortedLinkedList\Comparator\StringComparator;
use SortedLinkedList\SortedLinkedList;
use SortedLinkedList\SortedLinkedListFactory;
use SortedLinkedList\Validation\IntValidator;
use SortedLinkedList\Validation\StringValidator;

class SortedLinkedListTest extends TestCase
{
    public function testEmptyList(): void
    {
        $list = SortedLinkedListFactory::createIntList();

        $this->assertTrue($list->isEmpty());
        $this->assertEquals(0, $list->count());
        $this->assertNull($list->first());
        $this->assertNull($list->last());
        $this->assertEquals([], $list->toArray());
    }

    public function testAddIntegers(): void
    {
        $list = SortedLinkedListFactory::createIntList();

        $list->add(5);
        $list->add(3);
        $list->add(8);
        $list->add(1);

        $this->assertEquals([1, 3, 5, 8], $list->toArray());
        $this->assertEquals(1, $list->first());
        $this->assertEquals(8, $list->last());
        $this->assertEquals(4, $list->count());
    }

    public function testAddIntegersPreservesSortOrder(): void
    {
        $list = SortedLinkedListFactory::createIntList();

        $list->add(100);
        $list->add(-5);
        $list->add(0);
        $list->add(42);
        $list->add(-100);

        $this->assertEquals([-100, -5, 0, 42, 100], $list->toArray());
    }

    public function testAddStrings(): void
    {
        $list = SortedLinkedListFactory::createStringList();

        $list->add('Poland');
        $list->add('Germany');
        $list->add('France');

        $this->assertEquals(['France', 'Germany', 'Poland'], $list->toArray());
        $this->assertEquals('France', $list->first());
        $this->assertEquals('Poland', $list->last());
    }

    public function testAddEuropeanCountries(): void
    {
        $list = SortedLinkedListFactory::createStringList();

        $list->add('Italy');
        $list->add('Spain');
        $list->add('Poland');
        $list->add('Germany');
        $list->add('France');
        $list->add('Portugal');

        $this->assertEquals(['France', 'Germany', 'Italy', 'Poland', 'Portugal', 'Spain'], $list->toArray());
    }

    public function testStringSortingWithAccents(): void
    {
        $list = SortedLinkedListFactory::createStringList();

        $list->add('Latvia');
        $list->add('Austria');
        $list->add('Saint Helena');

        $result = $list->toArray();
        $this->assertContains('Austria', $result);
        $this->assertContains('Latvia', $result);
        $this->assertContains('Saint Helena', $result);
    }

    public function testCannotMixTypes(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $list = SortedLinkedListFactory::createIntList();
        $list->add(1);
        /* @phpstan-ignore-next-line */
        $list->add('Poland');
    }

    public function testInvalidTypeFloat(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $list = SortedLinkedListFactory::createIntList();
        /* @phpstan-ignore-next-line */
        $list->add(1.5);
    }

    public function testInvalidTypeArray(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $list = SortedLinkedListFactory::createStringList();
        /* @phpstan-ignore-next-line */
        $list->add(['Poland']);
    }

    public function testInvalidTypeObject(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $list = SortedLinkedListFactory::createIntList();
        /* @phpstan-ignore-next-line */
        $list->add(new \stdClass());
    }

    public function testRemove(): void
    {
        $list = SortedLinkedListFactory::createIntList();

        $list->add(1);
        $list->add(2);
        $list->add(3);

        $this->assertTrue($list->remove(2));
        $this->assertEquals([1, 3], $list->toArray());

        $this->assertFalse($list->remove(5));
        $this->assertEquals([1, 3], $list->toArray());
    }

    public function testRemoveFromHead(): void
    {
        $list = SortedLinkedListFactory::createIntList();

        $list->add(1);
        $list->add(2);
        $list->add(3);

        $this->assertTrue($list->remove(1));
        $this->assertEquals([2, 3], $list->toArray());
    }

    public function testRemoveFromTail(): void
    {
        $list = SortedLinkedListFactory::createIntList();

        $list->add(1);
        $list->add(2);
        $list->add(3);

        $this->assertTrue($list->remove(3));
        $this->assertEquals([1, 2], $list->toArray());
    }

    public function testRemoveOnlyElement(): void
    {
        $list = SortedLinkedListFactory::createStringList();

        $list->add('Poland');
        $this->assertTrue($list->remove('Poland'));
        $this->assertTrue($list->isEmpty());
    }

    public function testContains(): void
    {
        $list = SortedLinkedListFactory::createIntList();

        $list->add(1);
        $list->add(3);
        $list->add(5);

        $this->assertTrue($list->contains(3));
        $this->assertFalse($list->contains(2));
        $this->assertFalse($list->contains(4));
    }

    public function testContainsEarlyExit(): void
    {
        $list = SortedLinkedListFactory::createIntList();

        $list->add(1);
        $list->add(3);
        $list->add(5);
        $list->add(7);
        $list->add(9);
        $this->assertFalse($list->contains(6));
        $this->assertFalse($list->contains(10));
    }

    public function testClear(): void
    {
        $list = SortedLinkedListFactory::createIntList();

        $list->add(1);
        $list->add(2);
        $list->clear();

        $this->assertTrue($list->isEmpty());
        $this->assertEquals(0, $list->count());
        $this->assertNull($list->first());
        $this->assertNull($list->last());
    }

    public function testIterator(): void
    {
        $list = SortedLinkedListFactory::createIntList();

        $list->add(3);
        $list->add(1);
        $list->add(2);

        $result = [];
        foreach ($list->getIterator() as $value) {
            $result[] = $value;
        }

        $this->assertEquals([1, 2, 3], $result);
    }

    public function testIteratorWithEuropeanCountries(): void
    {
        $list = SortedLinkedListFactory::createStringList();

        $list->add('Sweden');
        $list->add('Norway');
        $list->add('Denmark');
        $list->add('Finland');

        $result = [];
        foreach ($list->getIterator() as $country) {
            $result[] = $country;
        }

        $this->assertEquals(['Denmark', 'Finland', 'Norway', 'Sweden'], $result);
    }

    public function testIteratorMultiplePasses(): void
    {
        $list = SortedLinkedListFactory::createStringList();

        $list->add('Hungary');
        $list->add('Austria');
        $list->add('Czech Republic');

        $first = [];
        foreach ($list->getIterator() as $value) {
            $first[] = $value;
        }

        $second = [];
        foreach ($list->getIterator() as $value) {
            $second[] = $value;
        }

        $this->assertEquals(['Austria', 'Czech Republic', 'Hungary'], $first);
        $this->assertEquals(['Austria', 'Czech Republic', 'Hungary'], $second);
    }

    public function testIteratorEmptyList(): void
    {
        $list = SortedLinkedListFactory::createIntList();

        $result = [];
        foreach ($list->getIterator() as $value) {
            $result[] = $value;
        }

        $this->assertEquals([], $result);
    }

    public function testCount(): void
    {
        $list = SortedLinkedListFactory::createStringList();

        $this->assertEquals(0, $list->count());

        $list->add('Poland');
        $this->assertEquals(1, $list->count());

        $list->add('Germany');
        $list->add('France');
        $this->assertEquals(3, $list->count());
    }

    public function testFirstAndLast(): void
    {
        $list = SortedLinkedListFactory::createIntList();

        $this->assertNull($list->first());
        $this->assertNull($list->last());

        $list->add(5);
        $this->assertEquals(5, $list->first());
        $this->assertEquals(5, $list->last());

        $list->add(3);
        $list->add(7);
        $this->assertEquals(3, $list->first());
        $this->assertEquals(7, $list->last());
    }

    public function testDependencyInjection(): void
    {
        $list = new SortedLinkedList(new IntValidator(), new IntComparator());

        $list->add(3);
        $list->add(1);

        $this->assertEquals([1, 3], $list->toArray());
    }

    public function testDependencyInjectionWithStrings(): void
    {
        $list = new SortedLinkedList(new StringValidator(), new StringComparator());

        $list->add('Poland');
        $list->add('Spain');

        $this->assertEquals(['Poland', 'Spain'], $list->toArray());
    }

    public function testAddDuplicateValues(): void
    {
        $list = SortedLinkedListFactory::createIntList();

        $list->add(5);
        $list->add(5);
        $list->add(5);

        $this->assertEquals([5, 5, 5], $list->toArray());
        $this->assertEquals(3, $list->count());
    }

    public function testToArrayReturnsCopy(): void
    {
        $list = SortedLinkedListFactory::createIntList();

        $list->add(1);
        $list->add(2);

        $array = $list->toArray();
        $array[] = 3;

        $this->assertEquals([1, 2], $list->toArray());
    }

    public function testAddToEmptyList(): void
    {
        $list = SortedLinkedListFactory::createIntList();
        $list->add(5);
        $this->assertEquals([5], $list->toArray());
    }

    public function testAddSmallerValueToHead(): void
    {
        $list = SortedLinkedListFactory::createIntList();
        $list->add(5);
        $list->add(3);
        $this->assertEquals([3, 5], $list->toArray());
    }

    public function testAddEqualValue(): void
    {
        $list = SortedLinkedListFactory::createIntList();
        $list->add(5);
        $list->add(5);
        $this->assertEquals([5, 5], $list->toArray());
    }

    public function testAddToEndOfList(): void
    {
        $list = SortedLinkedListFactory::createIntList();
        $list->add(1);
        $list->add(2);
        $list->add(3);
        $this->assertEquals([1, 2, 3], $list->toArray());
    }

    public function testAddToMiddleOfList(): void
    {
        $list = SortedLinkedListFactory::createIntList();
        $list->add(1);
        $list->add(3);
        $list->add(2);
        $this->assertEquals([1, 2, 3], $list->toArray());
    }

    public function testRemoveFromEmptyList(): void
    {
        $list = SortedLinkedListFactory::createIntList();
        $this->assertFalse($list->remove(5));
    }

    public function testRemoveFromMiddleOfList(): void
    {
        $list = SortedLinkedListFactory::createIntList();
        $list->add(1);
        $list->add(2);
        $list->add(3);
        $this->assertTrue($list->remove(2));
        $this->assertEquals([1, 3], $list->toArray());
    }

    public function testContainsEarlyExitOptimization(): void
    {
        $list = SortedLinkedListFactory::createIntList();
        $list->add(1);
        $list->add(2);
        $list->add(3);
        $this->assertFalse($list->contains(5));
    }

    public function testIteratorCurrentWhenEmpty(): void
    {
        $list = SortedLinkedListFactory::createIntList();
        $iterator = $list->getIterator();
        $this->assertNull($iterator->current());
    }

    public function testIteratorPositionAfterMultipleIterations(): void
    {
        $list = SortedLinkedListFactory::createIntList();
        $list->add(1);
        $list->add(2);

        $iterator = $list->getIterator();
        $this->assertEquals(0, $iterator->key());
        $iterator->next();
        $this->assertEquals(1, $iterator->key());
    }

    public function testIteratorValidAfterLastElement(): void
    {
        $list = SortedLinkedListFactory::createIntList();
        $list->add(1);

        $iterator = $list->getIterator();
        $iterator->next();
        $this->assertFalse($iterator->valid());
    }

    public function testStringComparatorCastsToString(): void
    {
        $comparator = new StringComparator();
        $this->assertSame(0, $comparator->compare('test', 'test'));
        $this->assertLessThan(0, $comparator->compare('a', 'b'));
        $this->assertGreaterThan(0, $comparator->compare('b', 'a'));
    }

    public function testIntComparator(): void
    {
        $comparator = new IntComparator();
        $this->assertSame(0, $comparator->compare(5, 5));
        $this->assertLessThan(0, $comparator->compare(1, 2));
        $this->assertGreaterThan(0, $comparator->compare(2, 1));
    }

    public function testRemoveWithInvalidTypeThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $list = SortedLinkedListFactory::createIntList();
        $list->add(1);
        /* @phpstan-ignore-next-line */
        $list->remove('invalid');
    }

    public function testContainsWithInvalidTypeThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $list = SortedLinkedListFactory::createIntList();
        $list->add(1);
        /* @phpstan-ignore-next-line */
        $list->contains('invalid');
    }

    public function testIteratorRewindResetsPosition(): void
    {
        $list = SortedLinkedListFactory::createIntList();
        $list->add(1);
        $list->add(2);

        $iterator = $list->getIterator();
        $iterator->next();
        $iterator->next();
        $iterator->rewind();
        $this->assertEquals(0, $iterator->key());
    }

    public function testIteratorNextOnEmptyList(): void
    {
        $list = SortedLinkedListFactory::createIntList();
        $iterator = $list->getIterator();
        $iterator->next();
        $this->assertNull($iterator->current());
    }

    public function testInsertAtExactBoundarySmallerThanHead(): void
    {
        $list = SortedLinkedListFactory::createIntList();
        $list->add(10);
        $list->add(5);
        $this->assertEquals([5, 10], $list->toArray());
    }

    public function testInsertEqualToExisting(): void
    {
        $list = SortedLinkedListFactory::createIntList();
        $list->add(5);
        $list->add(5);
        $list->add(5);
        $this->assertEquals([5, 5, 5], $list->toArray());
    }

    public function testInsertBetweenElements(): void
    {
        $list = SortedLinkedListFactory::createIntList();
        $list->add(1);
        $list->add(3);
        $list->add(2);
        $this->assertEquals([1, 2, 3], $list->toArray());
    }

    public function testContainsFindsValue(): void
    {
        $list = SortedLinkedListFactory::createIntList();
        $list->add(1);
        $list->add(2);
        $list->add(3);
        $this->assertTrue($list->contains(2));
    }

    public function testContainsNotFoundAfterPassingValue(): void
    {
        $list = SortedLinkedListFactory::createIntList();
        $list->add(10);
        $list->add(20);
        $list->add(30);
        $this->assertFalse($list->contains(15));
    }

    public function testStringComparisonRequiresCast(): void
    {
        $comparator = new StringComparator();
        $result1 = $comparator->compare('123', '456');
        /** @phpstan-ignore-next-line */
        $result2 = $comparator->compare(123, 456);
        $this->assertSame($result1, $result2);
    }

    public function testStringComparisonWithNumericStrings(): void
    {
        $comparator = new StringComparator();
        $this->assertLessThan(0, $comparator->compare('10', '2'));
        $this->assertGreaterThan(0, $comparator->compare('2', '10'));
    }

    public function testInsertEqualToHeadDoesNotChangeHead(): void
    {
        $list = SortedLinkedListFactory::createIntList();
        $list->add(5);
        $list->add(5);
        $this->assertEquals(5, $list->first());
    }

    public function testContainsFindsValueAfterEqualComparison(): void
    {
        $list = SortedLinkedListFactory::createIntList();
        $list->add(3);
        $list->add(5);
        $list->add(7);
        $this->assertTrue($list->contains(5));
    }

    public function testContainsFindsLastElement(): void
    {
        $list = SortedLinkedListFactory::createIntList();
        $list->add(1);
        $list->add(2);
        $list->add(3);
        $this->assertTrue($list->contains(3));
    }

    public function testContainsFindsMiddleElement(): void
    {
        $list = SortedLinkedListFactory::createIntList();
        $list->add(10);
        $list->add(20);
        $list->add(30);
        $list->add(40);
        $list->add(50);
        $this->assertTrue($list->contains(30));
    }

    public function testInsertMultipleEqualValues(): void
    {
        $list = SortedLinkedListFactory::createIntList();
        $list->add(10);
        $list->add(20);
        $list->add(20);
        $list->add(20);
        $list->add(30);
        $this->assertEquals([10, 20, 20, 20, 30], $list->toArray());
    }

    public function testContainsWithMultipleEqualValuesFindsAll(): void
    {
        $list = SortedLinkedListFactory::createIntList();
        $list->add(5);
        $list->add(5);
        $this->assertTrue($list->contains(5));
    }

    public function testMutantLessThanAtHead(): void
    {
        $list = SortedLinkedListFactory::createIntList();
        $list->add(10);
        $list->add(5);
        $list->add(5);
        $this->assertEquals([5, 5, 10], $list->toArray());
    }

    public function testMutantGreaterThanOrEqualInLoop(): void
    {
        $list = SortedLinkedListFactory::createIntList();
        $list->add(10);
        $list->add(20);
        $list->add(15);
        $list->add(15);
        $this->assertEquals([10, 15, 15, 20], $list->toArray());
    }

    public function testMutantGreaterThanInContainsEarlyExit(): void
    {
        $list = SortedLinkedListFactory::createIntList();
        $list->add(10);
        $list->add(20);
        $list->add(20);
        $list->add(30);
        $this->assertTrue($list->contains(20));
    }

    public function testInsertEqualToHeadMaintainsOrder(): void
    {
        $list = SortedLinkedListFactory::createIntList();
        $list->add(5);
        $list->add(3);
        $list->add(5);
        $this->assertEquals([3, 5, 5], $list->toArray());
    }

    public function testContainsReturnsFalseWhenValueGreaterThanAll(): void
    {
        $list = SortedLinkedListFactory::createIntList();
        $list->add(1);
        $list->add(2);
        $list->add(3);
        $this->assertFalse($list->contains(4));
    }

    public function testContainsWithDuplicatesFindsCorrectPosition(): void
    {
        $list = SortedLinkedListFactory::createIntList();
        $list->add(1);
        $list->add(2);
        $list->add(2);
        $list->add(2);
        $list->add(3);
        $this->assertTrue($list->contains(2));
    }

    public function testContainsWithValueEqualToFirstElement(): void
    {
        $list = SortedLinkedListFactory::createIntList();
        $list->add(5);
        $list->add(10);
        $list->add(15);
        $this->assertTrue($list->contains(5));
    }

    public function testContainsEarlyExitDoesNotAffectFoundValue(): void
    {
        $list = SortedLinkedListFactory::createIntList();
        $list->add(1);
        $list->add(2);
        $list->add(3);
        $list->add(4);
        $list->add(5);
        $this->assertTrue($list->contains(3));
    }
}
