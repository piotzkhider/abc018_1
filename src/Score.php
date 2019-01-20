<?php

namespace Acme;

class Score
{
    /**
     * @var int
     */
    private $value;

    /**
     * Score constructor.
     *
     * @param int $value
     */
    public function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function value(): int
    {
        return $this->value;
    }
}
