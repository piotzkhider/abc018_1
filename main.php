<?php

require_once 'vendor/autoload.php';

use Acme\DescendingComparator;
use Acme\Ranking;
use Acme\Score;
use Acme\Scores;

$inputs = file('php://stdin', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$scores = new Scores();
foreach ($inputs as $input) {
    $scores->add(new Score($input));
}

$ranking = new Ranking($scores, new DescendingComparator());

foreach ($scores as $score) {
    echo $ranking->rankOf($score), PHP_EOL;
}
