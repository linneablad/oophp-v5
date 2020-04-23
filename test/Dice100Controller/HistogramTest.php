<?php

namespace liba19\Dice100Controller;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Histogram.
 */
class HistogramTest extends TestCase
{
    /**
     * Construct object and verify it. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $histogram = new Histogram();
        $this->assertInstanceOf("\liba19\Dice100Controller\Histogram", $histogram);
    }



    /**
     * Verify that the result of function getAsText() is of type string
     */
    public function testGetAsText()
    {
        $gameRound = new GameRound();
        $gameRound->roll();

        $histogram = new Histogram();
        $histogram->injectData($gameRound);

        $res = $histogram->getAsText();

        $this->assertIsString($res);
    }



    /**
     * Inject data and verify that the right value for $serie has been set
     */
    public function testInjectDataSerie()
    {
        $gameRound = new GameRound();
        $gameRound->roll();

        $histogram = new Histogram();
        $histogram->injectData($gameRound);

        $res = $histogram->getHistogramSerie();
        $exp = $gameRound->getHistogramSerie();
        $this->assertEquals($exp, $res);
    }



    /**
     * Inject data and verify that the right value for $min has been set
     */
    public function testInjectDataMin()
    {
        $gameRound = new GameRound();
        $gameRound->roll();

        $histogram = new Histogram();
        $histogram->injectData($gameRound);

        $res = $histogram->getHistogramMin();
        $exp = $gameRound->getHistogramMin();
        $this->assertEquals($exp, $res);
    }



    /**
     * Inject data and verify that the right value for $max has been set
     */
    public function testInjectDataMax()
    {
        $gameRound = new GameRound();
        $gameRound->roll();

        $histogram = new Histogram();
        $histogram->injectData($gameRound);

        $res = $histogram->getHistogramMax();
        $exp = $gameRound->getHistogramMax();
        $this->assertEquals($exp, $res);
    }
}
