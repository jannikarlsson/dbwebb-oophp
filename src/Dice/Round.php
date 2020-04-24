<?php

namespace Janni\Dice;

/**
* Guess my number, a class supporting the game through GET, POST and SESSION.
*/
class Round
{
    /**
    * @var int $number   The current secret number.
    * @var int $tries    Number of tries left.
    * @var string $res   Game result.
    * @var int $guess    The guess
    */

    private $active;

    /**
    * Constructor to initiate the object with current game settings,
    * if available. Randomize the current number if no value is sent in.
    *
    * @param int $number The current secret number, default -1 to initiate
    *                    the number from start.
    * @param int $tries  Number of tries a guess has been made,
    *                    default 6.
    */


    public function __construct()
    {
    }

    /**
    * Switches player
    *
    * @return void
    */

    public function switchActive($active)
    {
        if ($active == "You") {
            $this->active = "Computer";
        } elseif ($active == "Computer") {
            $this->active = "You";
        }
    }

    /**
    * Returns active player
    *
    * @return string
    */

    public function returnActive()
    {
        return $this->active;
    }

    /**
    * Save sum
    *
    * @return void
    */

    public function save($active, $tempSum, $youSum, $compSum)
    {
        $this->youSum = $youSum;
        $this->compSum = $compSum;
        if ($active == "You") {
            $this->youSum += $tempSum;
        } else {
            $this->compSum += $tempSum;
        }
    }

    /**
    * Return youSum
    *
    * @return void
    */

    public function getYouSum()
    {
        return $this->youSum;
    }

    /**
    * Return compSum
    *
    * @return void
    */

    public function getCompSum()
    {
        return $this->compSum;
    }

    /**
    * Decide computer's action
    *
    * @return
    */

    public function compAction($tempSum, $youSum, $compSum)
    {
        if ($compSum + $tempSum >= 100) {
            $action = 1;
        } elseif ($youSum > $compSum + $tempSum) {
            $action = 2;
        } elseif ($tempSum > 30) {
            $action = 1;
        } else {
            $action = 2;
        }

        return $action;
    }
}
