<?php

use Acme\DescendingComparator;
use Acme\Ranking;
use Acme\Score;

$input = file('php://stdin', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$scores = array_map(function ($score) {
    return new Score($score);
}, $input);

$ranking = new Ranking($scores, new DescendingComparator());

foreach ($scores as $score) {
    echo $ranking->rankOf($score), PHP_EOL;
}
