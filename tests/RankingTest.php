<?php

namespace Tests;

use Acme\ComparatorInterface;
use Acme\Ranking;
use Acme\Score;
use Acme\Scores;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class RankingTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testRankOf(array $values)
    {
        $this->scores->method('sorted')
            ->with($this->comparator)
            ->willReturn(new Scores($values));

        foreach ($values as $index => $value) {
            $this->scores->method('indexOf')
                ->with($value)
                ->willReturn($index);

            $result = $this->SUT->rankOf($value);

            $this->assertEquals($index + 1, $result);
        }

        $this->assertTrue(true); // $valuesがemptyのとき dit not perform any assertions にならないように
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

    /**
     * @var Scores|MockObject
     */
    private $scores;

    /**
     * @var ComparatorInterface|MockObject
     */
    private $comparator;

    /**
     * @var Ranking
     */
    private $SUT;

    protected function setUp()
    {
        parent::setUp();

        $this->scores = $this->createMock(Scores::class);
        $this->comparator = $this->createMock(ComparatorInterface::class);

        $this->SUT = new Ranking($this->scores, $this->comparator);
    }
}
