<?php
declare(strict_types=1);

namespace Martinb\AdventOfCode2022\Tests;

use Martinb\AdventOfCode2022\Models\Day2\GameChoices;
use Martinb\AdventOfCode2022\Models\Day2\Intention;
use PHPUnit\Framework\TestCase;

final class Day2Part2Test extends TestCase
{
    private const WIN_SCORE = 6;
    private const DRAW_SCORE = 3;
    private const LOST_SCORE = 0;

    public function testWhichScoreComesOutAccordingToStrategyGuide(): void
    {
        $total_score = \array_reduce(
            \explode(
                \PHP_EOL,
                \file_get_contents(\sprintf('%s/../src/data/day2.txt', __DIR__)),
            ),
            function (int $carry, string $item): int {
                $moves = \explode(' ', $item);

                $opponentMove = GameChoices::fromSymbol($moves[0]);
                $myMove = $this->createMoveFromIntentionAndOpponentMove(
                    $opponentMove,
                    Intention::fromSymbol($moves[1]),
                );
                $score = $this->calculateScore(
                    $opponentMove,
                    $myMove,
                );

                return $carry + $myMove->value + $score;
            },
            0,
        );

        \var_dump('===================== total score ====================');
        \var_dump($total_score);

        // having fun
        self::assertSame(13490, $total_score);
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

    private function createMoveFromIntentionAndOpponentMove(GameChoices $opponentMove, Intention $intention): GameChoices
    {
        if (Intention::DRAW === $intention) {
            return $opponentMove;
        }

        if (GameChoices::ROCK === $opponentMove) {
            if (Intention::LOSE === $intention) {
                return GameChoices::SCISSORS;
            }

            return GameChoices::PAPER;
        }

        if (GameChoices::SCISSORS === $opponentMove) {
            if (Intention::LOSE === $intention) {
                return GameChoices::PAPER;
            }

            return GameChoices::ROCK;
        }

        if ((GameChoices::PAPER === $opponentMove) && Intention::LOSE === $intention) {
            return GameChoices::ROCK;
        }

        return GameChoices::SCISSORS;
    }
}
