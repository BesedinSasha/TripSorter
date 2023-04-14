<?php

namespace TripSorter\Tests\Unit\Output\PlainText;

use PHPUnit\Framework\TestCase;
use TripSorter\Model\BusBoardingCard;
use TripSorter\Model\FlightBoardingCard;
use TripSorter\Model\Point;
use TripSorter\Model\TrainBoardingCard;
use TripSorter\Output\PlainText\Formatter\BusBoardingCardFormatter;
use TripSorter\Output\PlainText\Formatter\FlightBoardingCardFormatter;
use TripSorter\Output\PlainText\Formatter\TrainBoardingCardFormatter;
use TripSorter\Output\PlainText\PlainTextOutput;

class PlainTextOutputTest extends TestCase
{
    public function testFormat(): void
    {
        $output = new PlainTextOutput(
            new TrainBoardingCardFormatter(),
            new BusBoardingCardFormatter(),
            new FlightBoardingCardFormatter()
        );

        $train1 = new TrainBoardingCard(new Point('A'), new Point('B'), 'A1', '42T');
        $bus1 = new BusBoardingCard(new Point('B'), new Point('C'));
        $flight1 = new FlightBoardingCard(
            new Point('C'),
            new Point('D'),
            'F123',
            'G42',
            '42F',
            'drop at ticket counter 34'
        );

        $formattedStr = $output->format($train1, $bus1, $flight1);

        $this->assertEquals(
            'Take train A1 from A to B. Sit in seat 42T.' .
            ' Take the airport bus from B to C. No seat assignment.' .
            ' From C, take flight F123 to D. Gate G42, seat 42F. Baggage drop at ticket counter 34.' .
            ' You have arrived at your final destination.',
            $formattedStr
        );
    }
}
