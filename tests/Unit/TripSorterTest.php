<?php

namespace TripSorter\Tests\Unit;

use PHPUnit\Framework\TestCase;
use TripSorter\Model\Point;
use TripSorter\Model\TrainBoardingCard;
use TripSorter\TripSorter;

class TripSorterTest extends TestCase
{
    public function testSuccessSort(): void
    {
        $pointA = new Point('A');
        $pointB = new Point('B');
        $pointC = new Point('C');
        $pointD = new Point('D');
        $pointE = new Point('E');
        $pointF = new Point('F');

        $train1 = new TrainBoardingCard($pointA, $pointB, '1');
        $train2 = new TrainBoardingCard($pointB, $pointC, '2');
        $train3 = new TrainBoardingCard($pointC, $pointD, '3');
        $train4 = new TrainBoardingCard($pointD, $pointE, '4');
        $train5 = new TrainBoardingCard($pointE, $pointF, '5');

        $sorter = new TripSorter();

        $sorted = $sorter->sort([$train2, $train1, $train3, $train5, $train4]);

        $this->assertEquals($train1, $sorted[0]);
        $this->assertEquals($train2, $sorted[1]);
        $this->assertEquals($train3, $sorted[2]);
        $this->assertEquals($train4, $sorted[3]);
        $this->assertEquals($train5, $sorted[4]);
    }

    public function testSortWithBrokenChain(): void
    {
        $pointA = new Point('A');
        $pointB = new Point('B');
        $pointC = new Point('C');
        $pointD = new Point('D');

        $train1 = new TrainBoardingCard($pointA, $pointB, '1');
        $train2 = new TrainBoardingCard($pointC, $pointD, '2');

        $this->expectException(\LogicException::class);

        $sorter = new TripSorter();

        $sorter->sort([$train2, $train1]);

    }
}
