<?php

namespace Janni\Dice;

/**
* Guess my number, a class supporting the game through GET, POST and SESSION.
*/
class Dicehand
{
    /**
    * @var int $number   The current secret number.
    * @var int $tries    Number of tries left.
    * @var string $res   Game result.
    * @var int $guess    The guess
    */

    private $tempSum = 0;
    private $one = false;
    private $addTemp = 0;
    private $diceArray;

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
        $this->rollDices();
    }

    /**
    * Stores temporary sum
    *
    * @return void
    */

    public function storeTemp($tempSum)
    {
        $this->tempSum = $tempSum;
        if ($this->one == true) {
            $this->tempSum = 0;
        } else {
            $this->tempSum += $this->addTemp;
        }
    }

    /**
    * Checks if the dice value is one
    *
    * @return void
    */

    public function checkForOne($dice)
    {
        if ($dice == 1) {
            $this->one = true;
        } else {
            $this->one = false;
        }
    }

    /**
    * Rolls two dices
    *
    * @return void
    */

    public function rollDices()
    {
        $roll = new Dice();
        for ($i=0; $i < 2; $i++) {
            $roll->rollDice();
            $dice = $roll->returnDice();
            $this->diceArray[] = $dice;
            $this->addTemp($dice);
            $this->checkForOne($dice);
        }
    }

    /**
    * Adds to temp value
    *
    * @return void
    */

    public function addTemp($dice)
    {
        $this->addTemp += $dice;
    }

    /**
    * Return dice array
    *
    * @return void
    */

    public function getDice()
    {
        return $this->diceArray;
    }

    /**
    * Return if dice is one
    *
    * @return boolean
    */

    public function isOne()
    {
        return $this->one;
    }

    /**
    * Return temp sum
    *
    * @return int
    */

    public function getTemp()
    {
        return $this->tempSum;
    }
}
