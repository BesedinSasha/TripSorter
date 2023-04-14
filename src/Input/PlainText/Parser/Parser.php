<?php

namespace TripSorter\Input\PlainText\Parser;

use TripSorter\Model\AbstractBoardingCard;

interface Parser
{
    public function supports(array $tokens): bool;

    public function parse(array &$tokens): AbstractBoardingCard;
}
