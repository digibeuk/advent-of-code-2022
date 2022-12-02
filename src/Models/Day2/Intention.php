<?php
declare(strict_types=1);

namespace Martinb\AdventOfCode2022\Models\Day2;

enum Intention
{
    case WIN;
    case DRAW;
    case LOSE;

    public static function fromSymbol(string $symbol): self
    {
        // X means you need to lose, Y means you need to end the round in a draw, and Z means you need to win.
        if ('X' === $symbol) {
            return self::LOSE;
        }

        if ('Y' === $symbol) {
            return self::DRAW;
        }

        return self::WIN;
    }
}
