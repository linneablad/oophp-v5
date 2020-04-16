<?php
namespace liba19\Dice100;

/**
 * A game round that consists of a dice hand.
 */
class GameRound
{
    /**
     * @var DiceHand $diceHand   A hand with a certain amounts of dices.
     * @var int  $valuesDiceRolls  Array consisting of results from the current game round.
     * @var string  $currentPlayer  The player for the current game round.
     */
    protected $diceHand;
    protected $valuesDiceRolls;
    protected $currentPlayer;



    /**
     * Constructor to initiate a game round.
     *
     * @param int $dices Number of dices to use in DiceHand, defaults to three.
     */
    public function __construct(int $dices = 3)
    {
        $this->diceHand = new DiceHand($dices);
        $this->valuesDiceRolls = [];
        $this->currentPlayer = "";
    }



    /**
     * Set the current player
     *
     * @param string $currentPlayer The current player
     *
     * @return void
     */
    public function setCurrentPlayer(string $currentPlayer)
    {
        $this->currentPlayer = $currentPlayer;
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
     * @return void.
     */
    public function roll()
    {
        $this->diceHand->roll();
        $valuesLastRoll =  $this->diceHand->getValues();
        array_push($this->valuesDiceRolls, $valuesLastRoll);
    }



    /**
     * Roll the dices for computer and check if the results contains number 1,
     * if it doesn't make a choice to continue roll or not
     *
     * @return void
    */
    public function rollComputer()
    {
        $this->roll();
        $canContinue = $this->canContinue();

        while ($canContinue === true) {
            $choice = rand(1, 2);

            if ($choice === 1) {
                $this->roll();
                $canContinue = $this->canContinue();
            } else {
                $canContinue = false;
                $this->savePoints("Dator");
            }
        }
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
            foreach ($this->valuesDiceRolls[$i] as $key => $value) {
                $sumCurrentGameRound += $value;
            }
        }
        return $sumCurrentGameRound;
    }
}
