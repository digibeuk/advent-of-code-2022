<?php
declare(strict_types=1);

namespace Martinb\AdventOfCode2022\Tests;

use PHPUnit\Framework\TestCase;

final class Day1Test extends TestCase
{
    public function testWhichElfHasMostCaloriesWillReturnCorrectElf(): void
    {
        $elves = [];
        $elf_number = 1;

        foreach (
            \preg_split(
                "#\n\s*\n#Ui",
                \file_get_contents(\sprintf('%s/../src/data/day1.txt', __DIR__)),
            ) as $content
        ) {
            $elves[$elf_number] = [
                'sum_of_calories' => \array_sum(
                    \array_map(
                        static fn (string $calories): int => (int) $calories,
                        \explode(\PHP_EOL, $content),
                    ),
                ),
            ];

            $elf_number++;
        }

        //sort the elves on number of calories carried
        \uasort($elves, static function (array $a, array $b): int {
            return $b['sum_of_calories'] <=> $a['sum_of_calories'];
        });

        $top_three = \array_slice($elves, 0, 3);

        \var_dump('===================== top 3 ====================');
        \var_dump($top_three);

        $top_three_no_of_calories = \array_reduce($top_three, static function ($carry, $item): int {
            return $carry + $item['sum_of_calories'];
        }, 0);

        \var_dump('===================== sum of calories ====================');
        \var_dump($top_three_no_of_calories);

        // having fun
        self::assertTrue(true);
    }
}
