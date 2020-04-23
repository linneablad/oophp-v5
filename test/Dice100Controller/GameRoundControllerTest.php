<?php

namespace liba19\Dice100Controller;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class GameRound.
 */
class GameRoundControllerTest extends TestCase
{
    /**
     * Construct object and verify it. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $gameRound = new GameRound();
        $this->assertInstanceOf("\liba19\Dice100Controller\GameRound", $gameRound);
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
     * Set previous player and verify that the right value has been set
     */
    public function testSetPreviousPlayer()
    {
        $gameRound = new GameRound();
        $previousPlayer = "Dator";

        $gameRound->setPreviousPlayer($previousPlayer);
        $res = $gameRound->getPreviousPlayer();

        $this->assertEquals($previousPlayer, $res);
    }



    /**
     * Test if function getHistogramMax returns value 6
     */
    public function testGetHistogramMax()
    {
        $gameRound = new GameRound();

        $res = $gameRound->getHistogramMax();
        $exp = 6;

        $this->assertEquals($exp, $res);
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

        foreach ($lastRoll as $value) {
            $this->assertLessThanOrEqual(6, $value);
            $this->assertGreaterThanOrEqual(1, $value);
        }
    }



    /**
     * Check that the method canContinue() returns false
     * when the last roll contains number 1
     */
    public function testCanNotContinue()
    {
        $gameRound = new GameRound(3, 1);
        $gameRound->roll();

        $res = $gameRound->canContinue();
        $exp = false;
        $this->assertEquals($exp, $res);
    }



    /**
     * Check that the method canContinue() returns true
     * when the last roll does not contain number 1
     */
    public function testCanContinue()
    {
        $gameRound = new GameRound();
        $gameRound->roll(2);

        $res = $gameRound->canContinue();
        $exp = true;
        $this->assertEquals($exp, $res);
    }



    /**
     * Check that the method sumLastDiceRoll() returns
     * the correct sum
     */
    public function testSumLastDiceRoll()
    {
        $gameRound = new GameRound(3, 1);
        $gameRound->roll();

        $res = $gameRound->sumLastDiceRoll();
        $exp = 3;

        $this->assertEquals($exp, $res);
    }
}
