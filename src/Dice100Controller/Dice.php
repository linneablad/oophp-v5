<?php
namespace liba19\Dice100Controller;

/**
 * A dice with a number of different sides
 */
class Dice
{
    /**
     * @var int  $dice      A dice with a number of sides.
     * @var int  $lastRoll  Value of the last roll.
     */
    private $dice;
    private $lastRoll;



    /**
     * Constructor to initiate a dice.
     *
     * @param int $sides Number of sides the dice will have
     */
    public function __construct(int $sides = 6)
    {
        $this->dice  = $sides;
    }



    /**
     * Roll the dice.
     *
     * @return int as the result of the dice roll
     */
    public function roll() : int
    {
        return $this->lastRoll = rand(1, $this->dice);
    }



    /**
     * Return the last roll.
     *
     * @return int as the result of the last dice roll
     */
    public function getLastRoll() : int
    {
        return $this->lastRoll;
    }



    /**
     * Return the amount of sides of the dice.
     *
     * @return int as the amount of sides
     */
    public function getSides() : int
    {
        return $this->dice;
    }
}
