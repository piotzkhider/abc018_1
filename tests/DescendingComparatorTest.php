<?php

namespace Tests;

use Acme\DescendingComparator;
use Acme\Score;
use PHPUnit\Framework\TestCase;

class DescendingComparatorTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testCompare(Score $a, Score $b)
    {
        $sort = function (Score $a, Score $b) {
            return $b->value() <=> $a->value();
        };

        $SUT = new DescendingComparator();

        $result = $SUT->compare($a, $b);

        $this->assertEquals($sort($a, $b), $result);
    }

    public function dataProvider()
    {
        return [
            [
                new Score(12),
                new Score(18),
            ],
            [
                new Score(10),
                new Score(20),
            ],
        ];
    }
}
