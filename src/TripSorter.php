<?php

namespace TripSorter;

use TripSorter\Model\AbstractBoardingCard;

class TripSorter
{
    /**
     * @param AbstractBoardingCard[] $boardingCards
     * @return array
     */
    public function sort(array $boardingCards): array
    {
        // data preparing
        $from = [];
        $to = [];

        foreach ($boardingCards as $boardingCard) {
            $from[(string)$boardingCard->from()] = $boardingCard;
            $to[(string)$boardingCard->to()] = $boardingCard;
        }

        $endsCounter = 0;

        // Detect broken chain
        foreach ($boardingCards as $boardingCard) {
            if (!array_key_exists((string)$boardingCard->to(), $from)) {
                $endsCounter++;
            }

            if ($endsCounter > 1) {
                throw new \LogicException('Broken chain');
            }
        }

        $begin = null;

        foreach ($boardingCards as $boardingCard) {
            if (!array_key_exists((string)$boardingCard->from(), $to)) {
                $begin = $boardingCard;
            }
        }

        if ($begin === null) {
            throw new \LogicException('Could not found start point');
        }

        return $this->addChains($begin, $from);
    }

    private function addChains(AbstractBoardingCard $prevChain, array &$from): array
    {
        $sorted[] = $prevChain;

        $nextChain = $from[$prevChain->to()->name()] ?? null;

        if ($nextChain === null) {
            return $sorted;
        }

        return array_merge($sorted, $this->addChains($nextChain, $from));
    }
}
