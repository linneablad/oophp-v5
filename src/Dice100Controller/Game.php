<?php
namespace liba19\Dice100Controller;

/**
 * The game Dice 100
 */
class Game extends GameRound
{

    /**
     *
     * @var int $pointsPlayer1   Total points for Player1
     * @var int $pointsComputer  Total points for Computer
     */

    private $pointsPlayer1;
    private $pointsComputer;



     /**
     * Constructor to initiate a new game with a new game round.
     *
     *
     * @param int    $dices               Number of dices to use in DiceHand, defaults to three.
     * @param int    $sides               Number of sides the dices should have, defaults to 6.
     * @param int    $startPointsPlayer1  Startpoints for Spelare1, defaults to 0.
     * @param int    $startPointsComputer Startpoints for Dator, defaults to 0.
     * @param string $currentPlayer       The current player, defaults to Dator
     * @param string $previousPlayer      The previous player, defaults to Spelare1
     */
    public function __construct(int $dices = 3, int $sides = 6, int $startPointsPlayer1 = 0, int $startPointsComputer = 0, string $currentPlayer = "Dator", string $previousPlayer = "Spelare1")
    {
        parent::__construct($dices, $sides);
        $this->pointsPlayer1 = $startPointsPlayer1;
        $this->pointsComputer = $startPointsComputer;
        $this->setCurrentPlayer($currentPlayer);
        $this->setPreviousPlayer($previousPlayer);
    }



    /**
     * Initiate a new GameRound
     *
     * @param string $currentPlayer   The current player
     * @param string $previousPlayer  The previous player
     *
     * @return void.
     */
    public function newGameRound(string $currentPlayer, string $previousPlayer)
    {
        parent::__construct();
        $this->setCurrentPlayer($currentPlayer);
        $this->setPreviousPlayer($previousPlayer);
    }



    /**
     * Get total points for Player1
     *
     * @return int containing the points
     */
    public function getPointsPlayer1() : int
    {
        return $this->pointsPlayer1;
    }



    /**
     * Get total points for Computer
     *
     * @return int containing the points
     */
    public function getPointsComputer() : int
    {
        return $this->pointsComputer;
    }



    /**
     * Save points from current game round
     *
     * @param string $currentPlayer  The current player
     *
     * @return void.
     */
    public function savePoints(string $currentPlayer)
    {
        $sumCurrentGameRound = $this->sumCurrentGameRound();

        if ($currentPlayer === "Spelare1") {
            $this->pointsPlayer1 += $sumCurrentGameRound;
        } elseif ($currentPlayer === "Dator") {
            $this->pointsComputer += $sumCurrentGameRound;
        }
    }



    /**
     * Roll the dices for computer and check if the results contains number 1,
     * if it doesn't make a choice to continue roll or not.
     *
     * @param int $min  Value of the lowest number of the dices, defaults to 1.
     *
     * @return void
    */
    public function rollComputer($min = 1)
    {
        $this->roll($min);
        $canContinue = $this->canContinue();

        while ($canContinue === true) {
            $sumLastDiceRoll = $this->sumLastDiceRoll();

            if ($sumLastDiceRoll > 10 || $this->pointsComputer > 80) {
                $canContinue = false;
                $this->savePoints("Dator");
            } else {
                $this->roll();
                $canContinue = $this->canContinue();
            }
        }
    }



    /**
     * Check if total points has reached 100
     *
     * @return bool depending on if total points has reached 100
    */
    public function checkGameStatus() : bool
    {
        if ($this->pointsPlayer1 >= 100 || $this->pointsComputer >= 100) {
            return true;
        } else {
            return false;
        }
    }
}
