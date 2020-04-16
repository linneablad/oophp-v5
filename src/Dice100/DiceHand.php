<?php
namespace liba19\Dice100;

/**
 * A dicehand, consisting of dices.
 */
class DiceHand
{
    /**
     * @var Dice $dices   Array consisting of dices.
     * @var int  $values  Array consisting of last roll of the dices.
     */
    private $dices;
    private $values;



    /**
     * Constructor to initiate the dicehand with a number of dices.
     *
     * @param int $dices Number of dices to create, defaults to three.
     */
    public function __construct(int $dices = 3)
    {
        $this->dices  = [];
        $this->values = [];

        for ($i = 0; $i < $dices; $i++) {
            $this->dices[]  = new Dice();
            $this->values[] = null;
        }
    }



    /**
     * Roll all dices and save their value.
     *
     * @return void.
     */
    public function roll()
    {
        $amountSides = count($this->dices);

        for ($i=0; $i < $amountSides; $i++) {
            $this->values[$i] = rand(1, 6);
        }
    }



    /**
     * Get values of dices from last roll.
     *
     * @return array with values of the last roll.
     */
    public function getValues() : array
    {
        return $this->values;
    }



    /**
     * Get amount of dices.
     *
     * @return int as the amount of dices.
     */
    public function getAmountOfDices() : int
    {
        return count($this->dices);
    }
}
