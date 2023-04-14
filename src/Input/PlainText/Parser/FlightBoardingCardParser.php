<?php

namespace TripSorter\Input\PlainText\Parser;

use TripSorter\Model\AbstractBoardingCard;
use TripSorter\Model\FlightBoardingCard;
use TripSorter\Model\Point;

class FlightBoardingCardParser implements Parser
{
    private const FLIGHT_BASE_PATTERN = '/^From\s+([\w\s-]+),\s+take\s+flight\s+(\w+)\s+to\s+([\w\s-]+)$/';
    private const FLIGHT_SEAT_PATTERN = '/^Gate\s+(\w+),\s+seat\s+(\w+)$/';
    private const FLIGHT_BAGGAGE_PATTERN = '/^Baggage\s+(.+)$/';
    public function supports(array $tokens): bool
    {
        return isset($tokens[0], $tokens[1], $tokens[2]) && preg_match(self::FLIGHT_BASE_PATTERN, trim($tokens[0]));
    }

    public function parse(array &$tokens): AbstractBoardingCard
    {
        $token = array_shift($tokens);
        preg_match_all(self::FLIGHT_BASE_PATTERN, trim($token), $flightBaseInfo);

        $token = array_shift($tokens);
        preg_match_all(self::FLIGHT_SEAT_PATTERN, trim($token), $flightSeatInfo);

        $token = array_shift($tokens);
        preg_match_all(self::FLIGHT_BAGGAGE_PATTERN, trim($token), $flightBaggageInfo);

        return new FlightBoardingCard(new Point($flightBaseInfo[1][0]), new Point($flightBaseInfo[3][0]), $flightBaseInfo[2][0], $flightSeatInfo[1][0], $flightSeatInfo[2][0], $flightBaggageInfo[1][0]);
    }

}
