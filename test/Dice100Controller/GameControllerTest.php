<?php

namespace liba19\Dice100Controller;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Game.
 */
class GameControllerTest extends TestCase
{
    /**
     * Construct object and verify it. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $game = new Game();
        $this->assertInstanceOf("\liba19\Dice100Controller\Game", $game);
    }



    /**
     * Get points for player1
     */
    public function testGetPointsPlayer1()
    {
        $game = new Game();
        $res = $game->getPointsPlayer1();
        $exp = 0;
        $this->assertEquals($exp, $res);
    }



    /**
     * Get points for computer
     */
    public function testGetPointsComputer()
    {
        $game = new Game();
        $res = $game->getPointsComputer();
        $exp = 0;
        $this->assertEquals($exp, $res);
    }



    /**
     * Check if the method returns true if pointsComputer is over 100
     */
    public function testGameStatusPointsComputerOver100()
    {
        $game = new Game(3, 6, 0, 101);
        $res = $game->checkGameStatus();
        $exp = true;
        $this->assertEquals($exp, $res);
    }



    /**
     * Check if the method returns true if pointsPlayer1 is over 100
     */
    public function testGameStatusPointsPlayer1Over100()
    {
        $game = new Game(3, 6, 101, 0);
        $res = $game->checkGameStatus();
        $exp = true;
        $this->assertEquals($exp, $res);
    }



    /**
     * Check if the method returns false if
     * pointsComputer and pointsPlayer1 is below 100
     */
    public function testGameStatusPointsBelow100()
    {
        $game = new Game();
        $res = $game->checkGameStatus();
        $exp = false;
        $this->assertEquals($exp, $res);
    }



    /**
     * Save points for computer (points is 0 from the beginning) from the game round
     * and validate that the correct points were saved
     */
    public function testSavePointsComputer()
    {
        $game = new Game();
        $game->roll();

        $totalPoints = $game->sumCurrentGameRound();
        $game->savePoints("Dator");
        $savedPointsComputer = $game->getPointsComputer();

        $this->assertEquals($totalPoints, $savedPointsComputer);
    }



    /**
     * Save points for player1 (points is 0 from the beginning) from the game round
     * and validate that the correct points were saved
     */
    public function testSavePointsPlayer1()
    {
        $game = new Game();
        $game->roll();

        $totalPoints = $game->sumCurrentGameRound();
        $game->savePoints("Spelare1");
        $savedPointsPlayer1 = $game->getPointsPlayer1();

        $this->assertEquals($totalPoints, $savedPointsPlayer1);
    }
}
