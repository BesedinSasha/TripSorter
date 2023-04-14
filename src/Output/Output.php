<?php

namespace TripSorter\Output;

use TripSorter\Model\AbstractBoardingCard;

interface Output
{
    public function format(AbstractBoardingCard ...$boardingCards): string;
}
