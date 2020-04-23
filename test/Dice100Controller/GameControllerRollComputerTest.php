<?php

namespace liba19\Dice100Controller;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for method rollComputer() in class Game.
 */
class GameControllerRollComputerTest extends TestCase
{
    /**
     * Roll dices for computer and check that no points were saved
     * when the dice rolls contains number 1
     */
    public function testRollComputerContainsNumber1()
    {
        $game = new Game(3, 1);
        $game->rollComputer();

        $res = $game->getPointsComputer();
        $exp = 0;
        $this->assertEquals($exp, $res);
    }



    /**
     * Roll dices for computer and check that no points were saved
     * when the sum of last dice roll is below 10
     */
    public function testRollComputerSumBelow10()
    {
        $game = new Game(3, 2);
        $game->rollComputer(2);

        $res = $game->getPointsComputer();
        $exp = 0;
        $this->assertEquals($exp, $res);
    }



    /**
     * Roll dices for computer and check that points were saved
     * when the sum of last dice roll is over 10
     */
    public function testRollComputerSumOver10()
    {
        $game = new Game(3, 6);
        $game->rollComputer(6);

        $res = $game->getPointsComputer();
        $exp = 10;
        $this->assertGreaterThan($exp, $res);
    }
}
