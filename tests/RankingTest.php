<?php

namespace Tests;

use Acme\ComparatorInterface;
use Acme\Ranking;
use Acme\Score;
use Acme\Scores;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

class RankingTest extends TestCase
{
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

    public function testRankOf()
    {
        $score = new Score(rand());

        $sorted = $this->createMock(Scores::class);
        $sorted->expects($this->once())
            ->method('indexOf')
            ->with($score)
            ->willReturn(1);

        $this->scores->expects($this->once())
            ->method('sorted')
            ->with($this->comparator)
            ->willReturn($sorted);

        $result = $this->SUT->rankOf($score);

        $this->assertEquals(2, $result);
    }

    public function testRankOf_該当スコアなし()
    {
        $score = new Score(rand());

        $sorted = $this->createMock(Scores::class);
        $sorted->expects($this->once())
            ->method('indexOf')
            ->with($score)
            ->willReturn(false);

        $this->scores->expects($this->once())
            ->method('sorted')
            ->with($this->comparator)
            ->willReturn($sorted);

        $this->expectException(UnexpectedValueException::class);

        $this->SUT->rankOf($score);
    }


    protected function setUp()
    {
        parent::setUp();

        $this->scores = $this->createMock(Scores::class);
        $this->comparator = $this->createMock(ComparatorInterface::class);

        $this->SUT = new Ranking($this->scores, $this->comparator);
    }
}
