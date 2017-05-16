<?php

namespace AppBundle\Util\Strategy;

class PlanningPokerVoteStrategy implements VoteStrategyInterface
{

    const VOTES = [
        '0' => 0,
        '1/2' => 50,
        '1' => 100,
        '2' => 200,
        '3' => 300,
        '5' => 500,
        '8' => 800,
        '13' => 1300,
        '20' => 2000,
        '?' => -1,
    ];

    public function getVotes(): array
    {
        return array_keys(self::VOTES);
    }

    public function getValues(): array
    {
        return array_values(self::VOTES);
    }

    public function mapToValue(string $vote): int
    {
        if (!isset(self::VOTES[$vote])) {
            throw new \InvalidArgumentException();
        }

        return self::VOTES[$vote];
    }

    /**
     * @param int $value
     * @return string|bool
     */
    public function mapToCard(int $value)
    {
        return array_search($value, self::VOTES);
    }
}
