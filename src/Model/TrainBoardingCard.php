<?php

namespace TripSorter\Model;

class TrainBoardingCard extends AbstractBoardingCard
{
    public function __construct(Point $from, Point $to, private readonly string $number, private ?string $seat = null)
    {
        parent::__construct($from, $to);
    }

    public function number(): string
    {
        return $this->number;
    }

    public function seat(): ?string
    {
        return $this->seat;
    }

    public function withSeat(?string $seat): void
    {
        $this->seat = $seat;
    }
}
