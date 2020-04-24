<?php

namespace Janni\Dice;

/**
 * Showing off a standard class with methods and properties.
 */
class Dice
{
    /**
    * @var string  $name   The name of the person.
    * @var integer $age    The age of the person.
    */

    private $dice;

    /**
    * Constructor to create a Person.
    *
    * @param null|string $name The name of the person.
    * @param null|int    $age  The age of the person.
    */
    public function __construct()
    {
    }

    /**
    * Roll the dice.
    *
    * @param int $dice      Rolls the dice.
    *
    * @return void
    */
    public function rollDice()
    {
        $this->dice = rand(1, 6);
        return $this->dice;
    }

    /**
    * Returns the dice
    *
    * @param int $dice      Rolls the dice.
    *
    * @return void
    */
    public function returnDice()
    {
        return $this->dice;
    }
}
