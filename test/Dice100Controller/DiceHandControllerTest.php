<?php

namespace liba19\Dice100Controller;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DiceHand.
 */
class DiceHandControllerTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $diceHand = new DiceHand();
        $this->assertInstanceOf("\liba19\Dice100Controller\DiceHand", $diceHand);

        $res = $diceHand->getAmountOfDices();
        $exp = 3;
        $this->assertEquals($exp, $res);
    }



    /**
     * Construct object and verify that the object has the expected
     * properties. Use one arguments.
     */
    public function testCreateObjectOneArgument()
    {
        $diceHand = new DiceHand(5);
        $this->assertInstanceOf("\liba19\Dice100Controller\DiceHand", $diceHand);

        $res = $diceHand->getAmountOfDices();
        $exp = 5;
        $this->assertEquals($exp, $res);
    }



    /**
     * Roll dices and check that three dices were used
     */
    public function testRollAmountOfDices()
    {
        $diceHand = new DiceHand(3);
        $diceHand->roll();
        $values = $diceHand->getValues();

        $res = count($values);
        $exp = 3;
        $this->assertEquals($exp, $res);
    }
}
