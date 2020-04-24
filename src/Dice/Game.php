<?php

namespace Janni\Dice;

/**
* Guess my number, a class supporting the game through GET, POST and SESSION.
*/
class Game
{
    /**
    * @var int $number   The current secret number.
    * @var int $tries    Number of tries left.
    * @var string $res   Game result.
    * @var int $guess    The guess
    */

    public $active;
    public $diceArray;
    private $tempSum = 0;
    private $youSum = 0;
    private $compSum = 0;
    private $one = false;
    public $histogram;

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
        $this->rollTwo();
        $this->activePlayer();
        $this->histogram = new DiceHistogram();
    }

    /**
    * Checks which player will start playing
    *
    * @return void
    */
    public function activePlayer()
    {
        if ($this->diceArray[0] > $this->diceArray[1]) {
            $this->active = "You";
        } else {
            $this->active = "Computer";
        }
    }

    /**
    * Rolls the dices
    *
    * @return void
    */
    public function rollTwo()
    {
        $same = true;
        while ($same == true) {
            $dice = new Dice();
            for ($i=0; $i<2; $i++) {
                $dice->rollDice();
                $this->diceArray[] = $dice->returnDice();
            }
            if ($this->diceArray[0] != $this->diceArray[1]) {
                $same = false;
            }
        }
    }

    /**
    * Starts new round
    *
    * @return string
    */

    public function newRound()
    {
        $this->diceArray = null;
        $this->one = false;
        $this->round = new Round();
    }

    /**
    * Switches active player
    *
    * @return string
    */

    public function switchActive()
    {
        $this->round->switchActive($this->active);
        $this->active = $this->round->returnActive();
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
    * Returns dice array
    *
    * @return array
    */

    public function returnDiceArray()
    {
        return $this->diceArray;
    }

    /**
    * Returns temporary value
    *
    * @return array
    */

    public function getTemp()
    {
        return $this->tempSum;
    }

    /**
    * Saves the value in round
    *
    * @return array
    */

    public function save()
    {
        $this->round->save($this->active, $this->tempSum, $this->youSum, $this->compSum);
        $this->youSum = $this->round->getYouSum();
        $this->compSum = $this->round->getCompSum();
        $this->tempSum = 0;
    }

    /**
    * New dicehand
    *
    * @return string
    */

    public function newDicehand()
    {
        $this->dicehand = new Dicehand($this->tempSum);
        $this->diceArray = $this->dicehand->getDice();
        foreach ($this->diceArray as $dice) {
            $this->histogram->roll($dice);
        }
        $this->one = $this->dicehand->isOne();
        $this->dicehand->storeTemp($this->tempSum);
        $this->tempSum = $this->dicehand->getTemp();
    }

    /**
    * Returns if round is lost
    *
    * @return array
    */

    public function getOne()
    {
        return $this->one;
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

    public function compAction()
    {
        $action = $this->round->compAction($this->tempSum, $this->youSum, $this->compSum);

        return $action;
    }
}
