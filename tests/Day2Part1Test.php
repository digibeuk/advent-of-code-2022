<?php
declare(strict_types=1);

namespace Martinb\AdventOfCode2022\Tests;

use Martinb\AdventOfCode2022\Models\Day2\GameChoices;
use PHPUnit\Framework\TestCase;

final class Day2Part1Test extends TestCase
{
    private const WIN_SCORE = 6;
    private const DRAW_SCORE = 3;
    private const LOST_SCORE = 0;

    public function testWhichScoreComesOutAccordingToStrategyGuide(): void
    {
        // Your total score is the sum of your scores for each round. The score for a single round is the score for the
        // shape you selected (1 for Rock, 2 for Paper, and 3 for Scissors) plus the score for the outcome of the round
        // (0 if you lost, 3 if the round was a draw, and 6 if you won).

        $total_score = \array_reduce(
            \explode(
                \PHP_EOL,
                \file_get_contents(\sprintf('%s/../src/data/day2.txt', __DIR__)),
            ),
            function (int $carry, string $item): int {
                $moves = \explode(' ', $item);

                $my_choice = GameChoices::fromSymbol($moves[1]);
                $score = $this->calculateScore(
                    GameChoices::fromSymbol($moves[0]),
                    $my_choice,
                );

                return $carry + $my_choice->value + $score;
            },
            0,
        );

        \var_dump('===================== total score ====================');
        \var_dump($total_score);

        // having fun
        self::assertSame(17189, $total_score);
    }

    private function calculateScore(GameChoices $opponentMove, GameChoices $myMove): int
    {
        if ($opponentMove === $myMove) {
            return self::DRAW_SCORE;
        }

        if (GameChoices::ROCK === $opponentMove) {
            if (GameChoices::PAPER === $myMove) {
                return self::WIN_SCORE;
            }

            return self::LOST_SCORE;
        }

        if (GameChoices::SCISSORS === $opponentMove) {
            if (GameChoices::ROCK === $myMove) {
                return self::WIN_SCORE;
            }

            return self::LOST_SCORE;
        }

        if ((GameChoices::PAPER === $opponentMove) && GameChoices::SCISSORS === $myMove) {
            return self::WIN_SCORE;
        }

        return self::LOST_SCORE;
    }
}
