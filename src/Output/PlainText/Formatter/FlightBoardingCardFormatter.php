<?php

namespace TripSorter\Output\PlainText\Formatter;

use TripSorter\Model\AbstractBoardingCard;
use TripSorter\Model\FlightBoardingCard;

class FlightBoardingCardFormatter implements Formatter
{
    private const TEMPLATE = 'From {from}, take flight {number} to {to}. Gate {gate}, seat {seat}. Baggage {baggage}';

    public function supports(AbstractBoardingCard $boardingCard): bool
    {
        return $boardingCard instanceof FlightBoardingCard;
    }

    public function format(AbstractBoardingCard|FlightBoardingCard $boardingCard): string
    {
        return strtr(
            self::TEMPLATE,
            [
                '{from}' => $boardingCard->from()->name(),
                '{to}' => $boardingCard->to()->name(),
                '{number}' => $boardingCard->number(),
                '{gate}' => $boardingCard->gate(),
                '{seat}' => $boardingCard->seat(),
                '{baggage}' => $boardingCard->baggage()
            ]
        );
    }
}
