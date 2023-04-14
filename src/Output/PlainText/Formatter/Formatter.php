<?php

namespace TripSorter\Output\PlainText\Formatter;

use TripSorter\Model\AbstractBoardingCard;

interface Formatter
{
    public function supports(AbstractBoardingCard $boardingCard): bool;
    public function format(AbstractBoardingCard $boardingCard): string;
}
