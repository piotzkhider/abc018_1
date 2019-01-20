<?php

namespace Acme;

use UnexpectedValueException;

class Ranking
{
    /**
     * @var Scores
     */
    private $scores;

    /**
     * @var ComparatorInterface
     */
    private $comparator;

    /**
     * @var Scores
     */
    private $ranked;

    /**
     * Ranking constructor.
     *
     * @param Scores|Score[]      $scores
     * @param ComparatorInterface $comparator
     */
    public function __construct(Scores $scores, ComparatorInterface $comparator)
    {
        $this->scores = $scores;
        $this->comparator = $comparator;
    }

    /**
     * @return Scores
     */
    private function ranked(): Scores
    {
        if (! isset($this->ranked)) {
            $this->ranked = $this->scores->sorted($this->comparator);
        }

        return $this->ranked;
    }

    /**
     * @param Score $score
     *
     * @return int
     */
    public function rankOf(Score $score): int
    {
        if (false !== $index = $this->ranked()->indexOf($score)) {
            return $index + 1;
        }

        throw new UnexpectedValueException();
    }
}
