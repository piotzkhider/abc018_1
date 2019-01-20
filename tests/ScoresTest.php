<?php

namespace Tests;

use Acme\ComparatorInterface;
use Acme\Score;
use Acme\Scores;
use PHPUnit\Framework\TestCase;

class ScoresTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testAdd(array $values)
    {
        $SUT = new Scores();
        foreach ($values as $value) {
            $SUT->add($value);
        }

        $this->assertEquals($values, $SUT->toArray());
    }

    /**
     * @dataProvider dataProvider
     */
    public function testIndexOf(array $values)
    {
        $SUT = new Scores($values);

        foreach ($values as $index => $value) {
            $result = $SUT->indexOf($value);

            $this->assertEquals($index, $result);
        }

        $this->assertTrue(true); // valuesがemptyのとき dit not perform any assertions にならないように
    }

    public function testIndexOf_該当なし()
    {
        $SUT = new Scores();

        $this->assertFalse($SUT->indexOf(new Score(1)));
    }

    /**
     * @dataProvider dataProvider
     */
    public function testSorted(array $values)
    {
        $sort = function (Score $a, Score $b) {
            return $b->value() <=> $a->value();
        };

        $comparator = new class($sort) implements ComparatorInterface
        {
            private $sort;

            public function __construct($sort)
            {
                $this->sort = $sort;
            }

            public function compare(Score $a, Score $b): int
            {
                return ($this->sort)($a, $b);
            }
        };

        $SUT = new Scores($values);

        $result = $SUT->sorted($comparator);

        usort($values, $sort);

        $this->assertEquals($values, $result->toArray());
    }

    /**
     * @dataProvider dataProvider
     */
    public function testToArray(array $values)
    {
        $SUT = new Scores($values);

        $result = $SUT->toArray();

        $this->assertEquals($values, $result);
    }

    public function dataProvider()
    {
        return [
            [[]],
            [
                [
                    new Score(12),
                    new Score(18),
                    new Score(11),
                ],
            ],
            [
                [
                    new Score(10),
                    new Score(20),
                ],
            ],
        ];
    }
}
