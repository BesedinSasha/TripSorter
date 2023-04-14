<?php

namespace TripSorter\Tests\Unit\Input\PlainText;

use PHPUnit\Framework\TestCase;
use TripSorter\Input\PlainText\Parser\BusBoardingCardParser;
use TripSorter\Input\PlainText\Parser\FlightBoardingCardParser;
use TripSorter\Input\PlainText\Parser\TrainBoardingCardParser;
use TripSorter\Input\PlainText\PlaintTextInput;
use TripSorter\Model\BusBoardingCard;
use TripSorter\Model\FlightBoardingCard;
use TripSorter\Model\TrainBoardingCard;

class PlainTextInputTest extends TestCase
{
    public function testCreateList(): void
    {
        $formatter = new PlaintTextInput(new BusBoardingCardParser(), new TrainBoardingCardParser(), new FlightBoardingCardParser());

        $list = $formatter->parse('Take train 78A from Madrid to Barcelona. Sit in seat 45B.' .
            ' Take the airport bus from Barcelona to Gerona Airport. No seat assignment.' .
            ' From Gerona Airport, take flight SK455 to Stockholm. Gate 45B, seat 3A. Baggage drop at ticket counter 344.' .
            ' From Stockholm, take flight SK22 to New York JFK. Gate 22, seat 7B. Baggage will we automatically transferred from your last leg.');

        $this->assertArrayHasKey(0, $list);
        $train1 = $list[0];
        $this->assertInstanceOf(TrainBoardingCard::class, $train1);
        $this->assertEquals('78A', $train1->number());
        $this->assertEquals('Madrid', $train1->from()->name());
        $this->assertEquals('Barcelona', $train1->to()->name());

        $this->assertArrayHasKey(1, $list);
        $bus1 = $list[1];
        $this->assertInstanceOf(BusBoardingCard::class, $bus1);
        $this->assertEquals('Barcelona', $bus1->from()->name());
        $this->assertEquals('Gerona Airport', $bus1->to()->name());

        $this->assertArrayHasKey(2, $list);
        $flight1 = $list[2];
        $this->assertInstanceOf(FlightBoardingCard::class, $flight1);
        $this->assertEquals('Gerona Airport', $flight1->from()->name());
        $this->assertEquals('Stockholm', $flight1->to()->name());
        $this->assertEquals('SK455', $flight1->number());
        $this->assertEquals('45B', $flight1->gate());
        $this->assertEquals('3A', $flight1->seat());
        $this->assertEquals('drop at ticket counter 344', $flight1->baggage());

        $this->assertArrayHasKey(3, $list);
        $flight2 = $list[3];
        $this->assertInstanceOf(FlightBoardingCard::class, $flight2);
        $this->assertEquals('Stockholm', $flight2->from()->name());
        $this->assertEquals('New York JFK', $flight2->to()->name());
        $this->assertEquals('SK22', $flight2->number());
        $this->assertEquals('22', $flight2->gate());
        $this->assertEquals('7B', $flight2->seat());
        $this->assertEquals('will we automatically transferred from your last leg', $flight2->baggage());
    }
}
