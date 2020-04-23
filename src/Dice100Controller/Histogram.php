<?php

namespace liba19\Dice100Controller;

/**
 * Generating histogram data.
 */
class Histogram
{
    /**
     * @var array $serie  The numbers stored in sequence.
     * @var int   $min    The lowest possible number.
     * @var int   $max    The highest possible number.
     */
    private $serie = [];
    private $min;
    private $max;



    /**
     * Get the serie.
     *
     * @return array with the serie.
     */
    public function getHistogramSerie() : array
    {
        return $this->serie;
    }



    /**
     * Get min value for the histogram.
     *
     * @return int with the min value.
     */
    public function getHistogramMin() : int
    {
        return $this->min;
    }



    /**
     * Get max value for the histogram.
     *
     * @return int with the max value.
     */
    public function getHistogramMax() : int
    {
        return $this->max;
    }



    /**
     * Return a string with a textual representation of the histogram.
     *
     * @return string representing the histogram.
     */
    public function getAsText() : string
    {
        $histogram = "";

        for ($i = $this->min; $i <= $this->max; $i++) {
            $histogram .= "\n" . $i . ": ";
            foreach ($this->serie as $valueDiceRoll) {
                if ($i === $valueDiceRoll) {
                    $histogram .= "*";
                }
            }
        }
        return $histogram;
    }



    /**
     * Inject the object to use as base for the histogram data.
     *
     * @param HistogramInterface $object The object holding the serie.
     *
     * @return void.
     */
    public function injectData(HistogramInterface $object)
    {
        $valuesDiceRolls = $object->getHistogramSerie();
        $amountDiceRolls = count($valuesDiceRolls);

        for ($i=0; $i < $amountDiceRolls; $i++) {
            array_push($this->serie, $valuesDiceRolls[$i]);
        }

        $this->min   = $object->getHistogramMin();
        $this->max   = $object->getHistogramMax();
    }
}
