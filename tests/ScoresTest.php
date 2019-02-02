<?php

namespace Tests;

use Acme\DescendingComparator;
use Acme\Score;
use Acme\Scores;
use ArrayIterator;
use MultipleIterator;
use PHPUnit\Framework\TestCase;

class ScoresTest extends TestCase
{
    public function testAdd()
    {
        $values = [
            new Score(1),
            new Score(2),
        ];

        $SUT = new Scores();
        foreach ($values as $value) {
            $SUT->add($value);
        }

        $this->assertEquals($values, $SUT->toArray());
    }

    /**
     * @dataProvider indexOfDataProvider
     */
    public function testIndexOf(Score $target, $expected)
    {
        $SUT = new Scores([
            new Score(12),
            new Score(18),
            new Score(12),
        ]);

        $result = $SUT->indexOf($target);

        $this->assertSame($expected, $result);
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
     * @dataProvider sortedDataProvider
     */
    public function testSorted(array $values, array $expected)
    {
        $SUT = new Scores($values);

        $result = $SUT->sorted(new DescendingComparator());

        $this->assertArrayEquals($expected, $result->toArray());
    }

    public function sortedDataProvider()
    {
        return [
            '空' => [[], []],
            '重複なし' => [[new Score(1), new Score(2), new Score(3)], [new Score(3), new Score(2), new Score(1)]],
            '重複あり' => [[new Score(1), new Score(2), new Score(1)], [new Score(2), new Score(1), new Score(1)]],
        ];
    }

    public function testToArray()
    {
        $values = [
            new Score(1),
            new Score(2),
        ];

        $SUT = new Scores($values);

        $result = $SUT->toArray();

        $this->assertArrayEquals($values, $result);
    }

    private function assertArrayEquals(array $expected, array $actual)
    {
        $multi = new MultipleIterator(MultipleIterator::MIT_NEED_ALL | MultipleIterator::MIT_KEYS_ASSOC);
        $multi->attachIterator(new ArrayIterator($expected), 'expected');
        $multi->attachIterator(new ArrayIterator($actual), 'actual');

        foreach ($multi as $value) {
            $this->assertTrue($value['actual']->equals($value['expected']));
        }

        // 空配列のとき did not perform any assertions にならないよう
        $this->assertTrue(true);
    }
}
