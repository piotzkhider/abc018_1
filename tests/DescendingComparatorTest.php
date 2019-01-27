<?php

namespace Tests;

use Acme\DescendingComparator;
use Acme\Score;
use PHPUnit\Framework\TestCase;

class DescendingComparatorTest extends TestCase
{
    /**
     * @dataProvider compareDataProvider
     */
    public function testCompare(Score $a, Score $b, int $expected)
    {
        $SUT = new DescendingComparator();

        $result = $SUT->compare($a, $b);

        $this->assertEquals($expected ,$result);
    }

    public function compareDataProvider()
    {
        return [
            '後者が大きい' => [new Score(12), new Score(18), 1],
            '前者が大きい' => [new Score(20), new Score(10), -1],
            '同じ' => [new Score(10), new Score(10), 0],
        ];
    }
}
