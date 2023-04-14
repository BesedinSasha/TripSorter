<?php

namespace TripSorter\Input\PlainText;

use TripSorter\Input\Input;
use TripSorter\Input\PlainText\Parser\Parser;
use TripSorter\Model\AbstractBoardingCard;

class PlaintTextInput implements Input
{
    private array $parsers;

    public function __construct(Parser ...$parsers)
    {
        $this->parsers = $parsers;
    }

    /**
     * @param string $text
     * @return AbstractBoardingCard[]
     */
    public function parse(string $text): array
    {
        $tokens = explode('.', $text);

        if ($tokens === []) {
            return [];
        }

        $list = [];

        while (count($tokens)) {
            $parser = $this->getParser($tokens);

            if ($parser) {
                $list[] = $parser->parse($tokens);
            } else {
                array_shift($tokens);
            }
        }

        return $list;
    }

    private function getParser(array $tokens): ?Parser
    {
        foreach ($this->parsers as $parser) {
            if ($parser->supports($tokens)) {
                return $parser;
            }
        }

        return null;
    }
}
