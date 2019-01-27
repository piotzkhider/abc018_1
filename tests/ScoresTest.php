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
     * @dataProvider indexOfDataProvider
     */
    public function testIndexOf(Score $target, int $expected)
    {
        $SUT = new Scores([
            new Score(12),
            new Score(18),
            new Score(12),
        ]);

        $result = $SUT->indexOf($target);

        $this->assertEquals($expected, $result);
    }

    public function indexOfDataProvider()
    {
        return [
            '存在するスコア' => [new Score(18), 1],
            '存在しないスコア' => [new Score(10), false],
            '重複するスコア' => [new Score(12), 0],
        ];
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
}
