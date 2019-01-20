<?php

namespace Acme;

interface ComparatorInterface
{
    /**
     * @param Score $a
     * @param Score $b
     *
     * @return int
     */
    public function compare(Score $a, Score $b): int;
}
