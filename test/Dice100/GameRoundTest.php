<?php

namespace liba19\Dice100;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class GameRound.
 */
class GameRoundTest extends TestCase
{
    /**
     * Construct object and verify it. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $gameRound = new GameRound();
        $this->assertInstanceOf("\liba19\Dice100\GameRound", $gameRound);
    }



    /**
     * Set current player and verify that the right value has been set
     */
    public function testSetCurrentPlayer()
    {
        $gameRound = new GameRound();
        $currentPlayer = "Dator";

        $gameRound->setCurrentPlayer($currentPlayer);
        $res = $gameRound->getCurrentPlayer();

        $this->assertEquals($currentPlayer, $res);
    }


    /**
     * Roll dices and see if the outcome is between 1 and 6
     */
    public function testRoll()
    {
        $gameRound = new GameRound();
        $gameRound->roll();
        $valuesDiceRolls = $gameRound->getValuesDiceRolls();
        $lastRoll = end($valuesDiceRolls);

        foreach ($lastRoll as $key => $value) {
            $this->assertLessThanOrEqual(6, $value);
            $this->assertGreaterThanOrEqual(1, $value);
        }
    }



    /**
     * Check that the method canContinue() returns false or true
     * if the last roll contain number 1 or not
     */
    public function testCanContinue()
    {
        $gameRound = new GameRound();
        $gameRound->roll();
        $valuesDiceRolls = $gameRound->getValuesDiceRolls();
        $lastRoll = end($valuesDiceRolls);
        $canContinue = $gameRound->canContinue();

        if (in_array(1, $lastRoll)) {
            $exp = false;
            $this->assertEquals($exp, $canContinue);
        } else {
            $exp = false;
            $this->assertEquals($exp, $canContinue);
        }
    }
}
