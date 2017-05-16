<?php

namespace AppBundle\Util\Strategy;

interface VoteStrategyInterface
{
    /**
     * @return string[]
     */
    public function getVotes(): array;

    public function mapToValue(string $vote): int;

    public function getValues(): array;

    /**
     * @param int $value
     * @return string|bool
     */
    public function mapToCard(int $value);
}
