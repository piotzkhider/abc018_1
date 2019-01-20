<?php

namespace Acme;

use ArrayIterator;
use IteratorAggregate;

class Scores implements IteratorAggregate
{
    /**
     * @var Score[]
     */
    private $values = [];

    /**
     * Scores constructor.
     *
     * @param Score[] $values
     */
    public function __construct(array $values = [])
    {
        $this->values = $values;
    }

    /**
     * @param Score $score
     *
     * @return Scores
     */
    public function add(Score $score): Scores
    {
        $this->values[] = $score;

        return $this;
    }

    /**
     * @param ComparatorInterface $comparator
     *
     * @return Scores
     */
    public function sorted(ComparatorInterface $comparator): Scores
    {
        $copy = $this->copy();

        $copy->sort($comparator);

        return $copy;
    }

    /**
     * @param Score $score
     *
     * @return false|int
     */
    public function indexOf(Score $score)
    {
        return array_search($score, $this->values, true);
    }

    /**
     * @param ComparatorInterface $comparator
     *
     * @return void
     */
    private function sort(ComparatorInterface $comparator): void
    {
        usort($this->values, function (Score $a, Score $b) use ($comparator) {
            return $comparator->compare($a, $b);
        });
    }

    /**
     * @return Scores
     */
    private function copy(): Scores
    {
        $values = $this->values;

        return new self($values);
    }

    /**
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->values);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->values;
    }
}
