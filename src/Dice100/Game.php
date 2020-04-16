<?php
namespace liba19\Dice100;

/**
 * The game Dice 100
 */
class Game extends GameRound
{
    /**
     *
     * @var int $pointsPlayer1   Total points for Player1
     * @var int  $pointsComputer  Total points for Computer
     */

    private $pointsPlayer1;
    private $pointsComputer;



     /**
     * Constructor to initiate a new game with a new game round.
     *
     */
    public function __construct(int $startPointsPlayer1 = 0, int $startPointsComputer = 0, string $currentPlayer = "Dator")
    {
        parent::__construct();
        $this->pointsPlayer1 = $startPointsPlayer1;
        $this->pointsComputer = $startPointsComputer;
        $this->setCurrentPlayer($currentPlayer);
    }



    /**
     * Initiate a new GameRound
     *
     * @param string $currentPlayer The current player
     *
     * @return void.
     */
    public function newGameRound(string $currentPlayer)
    {
        parent::__construct();
        $this->setCurrentPlayer($currentPlayer);
    }



    /**
     * Save points from current game round
     *
     * @param string $currentPlayer The current player
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
