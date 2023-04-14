<?php

namespace TripSorter\Output\PlainText;

use TripSorter\Model\AbstractBoardingCard;
use TripSorter\Output\Output;
use TripSorter\Output\PlainText\Formatter\Formatter;

class PlainTextOutput implements Output
{
    private const DESTINATION_MSG = 'You have arrived at your final destination.';
    private array $formatters;
    public function __construct(Formatter ...$formatters)
    {
        $this->formatters = $formatters;
    }

    public function format(AbstractBoardingCard ...$list): string
    {
        $outputLines = [];

        foreach ($list as $boardingCard) {
            $formatter = $this->getFormatter($boardingCard);

            if ($formatter) {
                $outputLines[] = $formatter->format($boardingCard);
            }
        }

        $outputLines[] = self::DESTINATION_MSG;

        return implode('. ', $outputLines);
    }

    private function getFormatter(AbstractBoardingCard $boardingCard): ?Formatter
    {
        foreach ($this->formatters as $formatter) {
            if ($formatter->supports($boardingCard)) {
                return $formatter;
            }
        }

        return null;
    }
}
