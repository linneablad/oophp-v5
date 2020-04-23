<?php
namespace liba19\Dice100Controller;

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
     * @param int $dices  Number of dices to create, defaults to three.
     * @param int $sides  Number of sides the dices should have, defaults to 6.
     */
    public function __construct(int $dices = 3, int $sides = 6)
    {
        $this->dices  = [];
        $this->values = [];

        for ($i = 0; $i < $dices; $i++) {
            $this->dices[]  = new Dice($sides);
            $this->values[] = null;
        }
    }



    /**
     * Roll all dices and save their value.
     *
     * @param int $min Value of the lowest number of the dices, defaults to 1.
     *
     * @return void.
     */
    public function roll($min = 1)
    {
        $amountDices = count($this->dices);
        $sides = $this->dices[0]->getSides();

        for ($i=0; $i < $amountDices; $i++) {
            $this->values[$i] = rand($min, $sides);
        }
        return $this->values;
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
