<?php

namespace TripSorter\Input\PlainText\Parser;

use TripSorter\Model\AbstractBoardingCard;
use TripSorter\Model\BusBoardingCard;
use TripSorter\Model\Point;

class BusBoardingCardParser implements Parser
{
    private const BUS_BASE_PATTERN = '/^Take the airport bus from ([\w\s-]+) to ([\w\s-]+)$/';
    private const BUS_SEAT_PATTERN = '/^Sit\s+in\s+seat\s+(\w+)$/';

    public function supports(array $tokens): bool
    {
        return isset($tokens[0], $tokens[1]) && preg_match(self::BUS_BASE_PATTERN, trim($tokens[0]));
    }

    public function parse(array &$tokens): AbstractBoardingCard
    {
        $token = array_shift($tokens);
        preg_match_all(self::BUS_BASE_PATTERN, trim($token), $busBaseInfo);

        $token = array_shift($tokens);
        preg_match_all(self::BUS_SEAT_PATTERN, trim($token), $busSeatInfo);

        return new BusBoardingCard(new Point($busBaseInfo[1][0]), new Point($busBaseInfo[2][0]), $busSeatInfo[1][0] ?? null);
    }
}
