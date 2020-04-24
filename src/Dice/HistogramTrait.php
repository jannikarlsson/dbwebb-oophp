<?php

namespace Janni\Dice;

/**
 * A trait implementing histogram for integers.
 */
trait HistogramTrait
{
    /**
     * @var array $serie  The numbers stored in sequence.
     */
    private $serie = [];
    private $print;

    /**
     * Get the serie.
     *
     * @return array with the serie.
     */
    public function getHistogramSerie()
    {
        return $this->serie;
    }



    /**
     * Print out the histogram, default is to print out only the numbers
     * in the serie, but when $min and $max is set then print also empty
     * values in the serie, within the range $min, $max.
     *
     * @param int $min The lowest possible integer number.
     * @param int $max The highest possible integer number.
     *
     * @return string representing the histogram.
     */
    public function printHistogram()
    {
        // $printArray[] = null;
        for ($i=1; $i<=6; $i++) {
            $dices[$i] = "{$i}: ";
        }
        foreach ($this->serie as $value) {
            $dices[$value] .= "*";
        }
        return implode("<br>", $dices);
    }
}
