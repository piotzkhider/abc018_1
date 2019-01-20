<?php

namespace Acme;

use UnexpectedValueException;

class Ranking
{
    /**
     * @var array|Score[]
     */
    private $scores;

    /**
     * @var ComparatorInterface
     */
    private $comparator;

    /**
     * @var array|Score[]
     */
    private $ranked;

    /**
     * Ranking constructor.
     *
     * @param array|Score[]       $scores
     * @param ComparatorInterface $comparator
     */
    public function __construct(array $scores, ComparatorInterface $comparator)
    {
        $this->scores = $scores;
        $this->comparator = $comparator;
    }

    /**
     * @return array|Score[]
     */
    private function ranked(): array
    {
        if (! isset($this->ranked)) {
            $this->ranked = $this->scores;

            usort($this->ranked, function (Score $a, Score $b) {
                return $this->comparator->compare($a, $b);
            });
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
        if (false !== $key = array_search($score, $this->ranked(), true)) {
            return $key + 1;
        }

        throw new UnexpectedValueException();
    }
}
