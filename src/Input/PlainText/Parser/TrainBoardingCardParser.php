<?php

namespace TripSorter\Input\PlainText\Parser;

use TripSorter\Model\AbstractBoardingCard;
use TripSorter\Model\Point;
use TripSorter\Model\TrainBoardingCard;

class TrainBoardingCardParser implements Parser
{
    private const TRAIN_BASE_PATTERN = '/^Take\s+train\s+(\w+)\s+from\s+([\w\s-]+)\s+to\s+([\w\s-]+)$/';
    private const TRAIN_SEAT_PATTERN = '/^Sit\s+in\s+seat\s+(\w+)$/';

    public function supports(array $tokens): bool
    {
        return isset($tokens[0], $tokens[1]) && preg_match(self::TRAIN_BASE_PATTERN, trim($tokens[0]));
    }

    public function parse(array &$tokens): AbstractBoardingCard
    {
        $token = array_shift($tokens);
        preg_match_all(self::TRAIN_BASE_PATTERN, trim($token), $trainBaseInfo);

        $token = array_shift($tokens);
        preg_match_all(self::TRAIN_SEAT_PATTERN, trim($token), $trainSeatInfo);

        return new TrainBoardingCard(new Point($trainBaseInfo[2][0]), new Point($trainBaseInfo[3][0]), $trainBaseInfo[1][0], $trainSeatInfo[1][0]);
    }
}
