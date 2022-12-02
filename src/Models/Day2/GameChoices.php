<?php
declare(strict_types=1);

namespace Martinb\AdventOfCode2022\Models\Day2;

enum GameChoices: int
{
    case ROCK = 1;
    case PAPER = 2;
    case SCISSORS = 3;

    public static function fromSymbol(string $symbol): self
    {
        if ('A' === $symbol || 'X' === $symbol) {
            return self::ROCK;
        }

        if ('B' === $symbol || 'Y' === $symbol) {
            return self::PAPER;
        }

        return self::SCISSORS;
    }
}
