<?php

namespace Acme;

class DescendingComparator implements ComparatorInterface
{
    /**
     * @param Score $a
     * @param Score $b
     *
     * @return int
     */
    public function compare(Score $a, Score $b): int
    {
        return $b->value() <=> $a->value();
    }
}
