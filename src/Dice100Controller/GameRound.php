<?php
namespace liba19\Dice100Controller;

/**
 * A game round that consists of a dice hand.
 */
class GameRound implements HistogramInterface
{
    use HistogramTrait;
    /**
     * @var DiceHand $diceHand         A hand with a certain amounts of dices.
     * @var int      $valuesDiceRolls  Array consisting of results from the current game round.
     * @var string   $currentPlayer    The player for the current game round.
     * @var string   $previousPlayer   The player of the previous game round.
     */
    private $diceHand;
    protected $valuesDiceRolls;
    protected $currentPlayer;
    protected $previousPlayer;



    /**
     * Constructor to initiate a game round.
     *
     * @param int $dices  Number of dices to use in DiceHand, defaults to three.
     * @param int $sides  Number of sides the dices should have, defaults to 6.
     */
    public function __construct(int $dices = 3, int $sides = 6)
    {
        $this->diceHand = new DiceHand($dices, $sides);
        $this->valuesDiceRolls = [];
        $this->currentPlayer = "";
        $this->previousPlayer = "";
        $this->serie = [];
    }



    /**
     * Set the current player
     *
     * @param string $currentPlayer  The current player
     *
     * @return void
     */
    public function setCurrentPlayer(string $currentPlayer)
    {
        $this->currentPlayer = $currentPlayer;
    }



    /**
     * Set the previousPlayer player in order to show the last dice-rolls
     *
     * @param string $previousPlayer  The previousPlayer
     *
     * @return void
     */
    public function setPreviousPlayer(string $previousPlayer)
    {
        $this->previousPlayer = $previousPlayer;
    }



    /**
     * Get the player of the current game round.
     *
     * @return string as the current player
     */
    public function getCurrentPlayer() : string
    {
        return $this->currentPlayer;
    }



    /**
     * Get the player of the previous game round.
     *
     * @return string as the previous player
     */
    public function getPreviousPlayer() : string
    {
        return $this->previousPlayer;
    }



    /**
     * Get max value for the histogram.
     *
     * @return int with the max value.
     */
    public function getHistogramMax() : int
    {
        return 6;
    }



    /**
     * Get values of all rolls from the current game round.
     *
     * @return array with values of the rolls.
     */
    public function getValuesDiceRolls() : array
    {
        return $this->valuesDiceRolls;
    }



    /**
     * Roll all dices and save their value.
     *
     * @param int $min  Value of the lowest number of the dices, defaults to 1.
     *
     * @return void.
     */
    public function roll($start = 1)
    {
        $valuesLastRoll = $this->diceHand->roll($start);
        $amountDices = $this->diceHand->getAmountOfDices();

        for ($i=0; $i < $amountDices; $i++) {
            array_push($this->serie, $valuesLastRoll[$i]);
        }
        array_push($this->valuesDiceRolls, $valuesLastRoll);
    }



    /**
     * Check if the last dice-roll contains number 1
     *
     * @return bool which depends on if the array contains number 1.
     */
    public function canContinue() : bool
    {
        $last = end($this->valuesDiceRolls);
        $canContinue = in_array(1, $last) ? false : true;

        return $canContinue;
    }



    /**
     * Sum points from current game round
     *
     * @return int containing the sum
     */
    public function sumCurrentGameRound() : int
    {
        $sumCurrentGameRound = null;
        $amountDiceRolls = count($this->valuesDiceRolls);

        for ($i=0; $i < $amountDiceRolls; $i++) {
            foreach ($this->valuesDiceRolls[$i] as $value) {
                $sumCurrentGameRound += $value;
            }
        }
        return $sumCurrentGameRound;
    }



    /**
     * Sum points from last dice roll
     *
     * @return int containing the sum
     */
    public function sumLastDiceRoll() : int
    {
        $sumLastDiceRoll = null;
        $lastRoll = $this->diceHand->getValues();

        foreach ($lastRoll as $value) {
            $sumLastDiceRoll += $value;
        }
        return $sumLastDiceRoll;
    }
}
