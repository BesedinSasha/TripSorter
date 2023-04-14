<?php

namespace TripSorter\Tests\Functional;

use PHPUnit\Framework\TestCase;
use TripSorter\Input\PlainText\Parser\BusBoardingCardParser;
use TripSorter\Input\PlainText\Parser\FlightBoardingCardParser;
use TripSorter\Input\PlainText\Parser\TrainBoardingCardParser;
use TripSorter\Input\PlainText\PlaintTextInput;
use TripSorter\Output\PlainText\Formatter\BusBoardingCardFormatter;
use TripSorter\Output\PlainText\Formatter\FlightBoardingCardFormatter;
use TripSorter\Output\PlainText\Formatter\TrainBoardingCardFormatter;
use TripSorter\Output\PlainText\PlainTextOutput;
use TripSorter\TripSorter;

class TripSorterTest extends TestCase
{
    public function testPlainText(): void
    {
        $inputString = ' From Gerona Airport, take flight SK455 to Stockholm. Gate 45B, seat 3A. Baggage drop at ticket counter 344.' .
            'Take train 78A from Madrid to Barcelona. Sit in seat 45B.' .
            ' From Stockholm, take flight SK22 to New York JFK. Gate 22, seat 7B. Baggage will we automatically transferred from your last leg.' .
            ' Take the airport bus from Barcelona to Gerona Airport. No seat assignment';

        $expectedString = 'Take train 78A from Madrid to Barcelona. Sit in seat 45B.' .
            ' Take the airport bus from Barcelona to Gerona Airport. No seat assignment.' .
            ' From Gerona Airport, take flight SK455 to Stockholm. Gate 45B, seat 3A. Baggage drop at ticket counter 344.' .
            ' From Stockholm, take flight SK22 to New York JFK. Gate 22, seat 7B. Baggage will we automatically transferred from your last leg.' .
            ' You have arrived at your final destination.';

        $plainTextInput = new PlaintTextInput(
            new TrainBoardingCardParser(),
            new BusBoardingCardParser(),
            new FlightBoardingCardParser()
        );

        $list = $plainTextInput->parse($inputString);

        $tripSorter = new TripSorter();

        $sortedList = $tripSorter->sort($list);

        $plainTextOutput = new PlainTextOutput(new TrainBoardingCardFormatter(), new BusBoardingCardFormatter(), new FlightBoardingCardFormatter());

        $formattedOutput = $plainTextOutput->format(...$sortedList);

        $this->assertEquals($expectedString, $formattedOutput);
    }
}
