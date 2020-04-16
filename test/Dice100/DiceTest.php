<?php

namespace liba19\Dice100;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DiceTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObject()
    {
        $dice = new Dice();
        $this->assertInstanceOf("\liba19\Dice100\Dice", $dice);

        $res = $dice->getSides();
        $exp = 6;
        $this->assertEquals($exp, $res);
    }



    /**
     * Construct object and verify that the object has the expected
     * properties. Use one argument.
     */
    public function testCreateObjectOneArgument()
    {
        $dice = new Dice(5);
        $this->assertInstanceOf("\liba19\Dice100\Dice", $dice);

        $res = $dice->getSides();
        $exp = 5;
        $this->assertEquals($exp, $res);
    }



    /**
     * Roll dice and see if the outcome is between 1 and 6
     */
    public function testRollInRange()
    {
        $dice = new Dice();
        $res = $dice->roll();

        $this->assertLessThanOrEqual(6, $res);
        $this->assertGreaterThanOrEqual(1, $res);
    }



    /**
     * Roll dice and get the last roll to see if it matches
     */
    public function testGetLastRoll()
    {
        $dice = new Dice();
        $res = $dice->roll();
        $lastRoll = $dice->getLastRoll();

        $this->assertEquals($res, $lastRoll);
    }
}
