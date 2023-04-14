<?php

namespace TripSorter\Model;

abstract class AbstractBoardingCard
{
    public function __construct(private readonly Point $from, private readonly Point $to)
    {
    }

    public function from(): Point
    {
        return $this->from;
    }

    public function to(): Point
    {
        return $this->to;
    }
}
