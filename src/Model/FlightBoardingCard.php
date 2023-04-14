<?php

namespace TripSorter\Model;

class FlightBoardingCard extends AbstractBoardingCard
{
    public function __construct(Point $from, Point $to, private readonly string $number, private readonly string $gate, private readonly string $seat, private readonly ?string $baggage = null)
    {
        parent::__construct($from, $to);
    }

    public function number(): string
    {
        return $this->number;
    }

    public function gate(): string
    {
        return $this->gate;
    }

    public function seat(): string
    {
        return $this->seat;
    }

    public function baggage(): ?string
    {
        return $this->baggage;
    }

}
