<?php
/**
* Guess my number, a class supporting the game through GET, POST and SESSION.
*/
class Guess
{
    /**
    * @var int $number   The current secret number.
    * @var int $tries    Number of tries left.
    */

    private $number;
    private $tries;
    public $res;
    public $guess;

    /**
    * Constructor to initiate the object with current game settings,
    * if available. Randomize the current number if no value is sent in.
    *
    * @param int $number The current secret number, default -1 to initiate
    *                    the number from start.
    * @param int $tries  Number of tries a guess has been made,
    *                    default 6.
    */

    public function __construct(int $number = -1, int $tries = 6)
    {
        $this->number = $number;
        if ($this->number === -1) {
            $this->random();
        }
        $this->tries = $tries;
    }



    /**
    * Randomize the secret number between 1 and 100 to initiate a new game.
    *
    * @return void
    */

    public function random()
    {
        $this->number = rand(1, 100);
    }



    /**
    * Get number of tries left.
    *
    * @return int as number of tries made.
    */
    public function tries()
    {
        return $this->tries;
    }


    /**
    * Get the secret number.
    *
    * @return int as the secret number.
    */

    public function number()
    {
        return $this->number;
    }


    /**
    * Make a guess, decrease remaining guesses and return a string stating
    * if the guess was correct, too low or to high or if no guesses remains.
    *
    * @throws GuessException when guessed number is out of bounds.
    *
    * @return string to show the status of the guess made.
    */

    public function makeGuess(int $guess)
    {
        if (!(is_int($guess) && $guess > 0 && $guess <= 100)) {
            throw new GuessException();
        } else {
            $this->tries -= 1;
            if ($this->number === $guess) {
                $this->res = "Your guess ({$guess}) is CORRECT.";
                $this->tries = 0;
            } elseif ($guess > $this->number) {
                $this->res = "Your guess ({$guess}) is too high.";
            } else {
                $this->res = "Your guess ({$guess}) is too low.";
            }
            return $this->res;
        }
    }
}
