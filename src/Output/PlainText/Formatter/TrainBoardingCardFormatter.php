<?php

namespace TripSorter\Output\PlainText\Formatter;

use TripSorter\Model\AbstractBoardingCard;
use TripSorter\Model\TrainBoardingCard;

class TrainBoardingCardFormatter implements Formatter
{
    private const TEMPLATE = 'Take train {number} from {from} to {to}. Sit in seat {seat}';

    public function supports(AbstractBoardingCard $boardingCard): bool
    {
        return $boardingCard instanceof TrainBoardingCard;
    }

    public function format(AbstractBoardingCard|TrainBoardingCard $boardingCard): string
    {
        return strtr(
            self::TEMPLATE,
            [
                '{number}' => $boardingCard->number(),
                '{from}' => $boardingCard->from()->name(),
                '{to}' => $boardingCard->to()->name(),
                '{seat}' => $boardingCard->seat()
            ]
        );
    }
}
