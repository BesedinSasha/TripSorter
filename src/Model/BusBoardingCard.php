<?php

namespace TripSorter\Model;

class BusBoardingCard extends AbstractBoardingCard
{
    public function __construct(Point $from, Point $to, private readonly ?string $seat = null)
    {
        parent::__construct($from, $to);
    }

    public function seat(): ?string
    {
        return $this->seat;
    }
}
