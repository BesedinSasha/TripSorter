<?php

namespace TripSorter\Output\PlainText\Formatter;

use TripSorter\Model\AbstractBoardingCard;
use TripSorter\Model\BusBoardingCard;

class BusBoardingCardFormatter implements Formatter
{
    private const TEMPLATE = 'Take the airport bus from {from} to {to}. {seat}';

    public function supports(AbstractBoardingCard $boardingCard): bool
    {
        return $boardingCard instanceof BusBoardingCard;
    }

    public function format(AbstractBoardingCard|BusBoardingCard $boardingCard): string
    {
        $seat = $boardingCard->seat() ? 'Sit in seat ' . $boardingCard->seat() : 'No seat assignment';

        return strtr(
            self::TEMPLATE,
            [
                '{from}' => $boardingCard->from()->name(),
                '{to}' => $boardingCard->to()->name(),
                '{seat}' => $seat
            ]
        );
    }
}
