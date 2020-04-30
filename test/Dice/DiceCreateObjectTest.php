<?php

namespace Janni\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 * @SuppressWarnings(PHPMD)
 */
class GuessCreateObjectTest extends TestCase
{
    /**
     * Construct game object and verify that an active player is set
     */
    public function testCreateObjectGame()
    {
        $game = new Game();
        $this->assertInstanceOf("\Janni\Dice\Game", $game);

        $res = $game->returnActive();
        $this->assertNotEmpty($res);
    }

    /**
     * Test that both players can be active
     */
    public function testSetActiveGame()
    {
        $game = new Game();

        $game->diceArray[0] = 3;
        $game->diceArray[1] = 4;
        $game->activePlayer();
        $res = $game->returnActive();
        $exp = "Computer";
        $this->assertEquals($exp, $res);

        $game->diceArray[0] = 5;
        $game->activePlayer();
        $res = $game->returnActive();
        $exp = "You";
        $this->assertEquals($exp, $res);
    }

    /**
     * Test that diceArray can be returned
     */
    public function testRollFirstDices()
    {
        $game = new Game();
        $this->assertIsArray($game->returnDiceArray());
    }

    /**
     * Construct game object and verify that the dice is between 1 and 6
     */
    public function testCreateDice()
    {
        $dice = new Dice();
        $this->assertInstanceOf("\Janni\Dice\Dice", $dice);

        $dice->rollDice();
        $res = $dice->returnDice();
        $this->assertGreaterThanOrEqual(1, $res);
        $this->assertLessThanOrEqual(6, $res);
    }

    /**
     * Construct dicehand object and veryfy that the value is more than 0.
     */
    public function testCreateDicehand()
    {
        $dicehand = new Dicehand();
        $this->assertInstanceOf("\Janni\Dice\Dicehand", $dicehand);

        $dicehand->rollDices();
        $dice = 5;
        $dicehand->addTemp($dice);
        $res = $dicehand->getTemp();
        $this->assertGreaterThanOrEqual(0, $res);
    }

    /**
     * Construct dicehand object from Game class
     */
    public function testCreateDicehandFromGame()
    {
        $game = new Game();
        $game->newDicehand();
        $res = $game->returnDiceArray();
        $this->assertIsArray($res);

        $res = $game->getOne();
        $this->assertIsBool($res);

        $res = $game->histogram->getHistogramSerie();
        $this->assertIsArray($res);

        $res = $game->histogram->printHistogram();
        $this->assertIsString($res);
    }

    // /**
    //  * Check if the dice value is one
    //  */
    // public function testCheckForOne()
    // {
    //     $dicehand = new Dicehand();
    //
    //     $dicehand->checkForOne(1);
    //     $res = $dicehand->isOne();
    //     $exp = true;
    //     $this->assertEquals($exp, $res);
    //
    //     $dicehand->storeTemp(5);
    //     $res = $dicehand->getTemp();
    //     $exp = 0;
    //     $this->assertEquals($exp, $res);
    //
    //     $dicehand->checkForOne(2);
    //     $dicehand->addTemp(2);
    //     $res = $dicehand->isOne();
    //     $exp = false;
    //     $this->assertEquals($exp, $res);
    //
    //     $dicehand->storeTemp(5);
    //     $res = $dicehand->getTemp();
    //     $this->assertGreaterThanOrEqual(5, $res);
    // }

    /**
     * Check if the dice value is one
     */
    public function checkStoreTemp()
    {
        $dicehand = new Dicehand();

        $dicehand->checkForOne(5);
        $dicehand->storeTemp(5);
        $res = $dicehand->getTemp();
        $exp = 5;
        $this->assertEquals($exp, $res);
    }

    /**
     * Switch active player in round and back again
     */
    public function testSwitchActive()
    {
        $round = new Round();
        $round->switchActive("You");
        $res = $round->returnActive();
        $exp = "Computer";
        $this->assertEquals($exp, $res);

        $round->switchActive("Computer");
        $res = $round->returnActive();
        $exp = "You";
        $this->assertEquals($exp, $res);
    }

    /**
     * Switch active player in round and back again
     */
    public function testSave()
    {
        $round = new Round();

        $round->save("You", 40, 10, 20);
        $res = $round->getYouSum();
        $exp = 50;
        $this->assertEquals($exp, $res);

        $round->save("Computer", 40, 10, 20);
        $res = $round->getCompSum();
        $exp = 60;
        $this->assertEquals($exp, $res);
    }

    /**
     * Switch active player in round and back again
     */
    public function testCompAction()
    {
        $round = new Round();

        $res = $round->compAction(10, 50, 91);
        $exp = 1;
        $this->assertEquals($exp, $res);

        $res = $round->compAction(9, 60, 50);
        $exp = 2;
        $this->assertEquals($exp, $res);

        $res = $round->compAction(40, 10, 10);
        $exp = 1;
        $this->assertEquals($exp, $res);

        $res = $round->compAction(10, 10, 20);
        $exp = 2;
        $this->assertEquals($exp, $res);
    }

    /**
     * Returns things
     */
    public function testReturns()
    {
        $game = new Game();

        $res = $game->getTemp();
        $exp = 0;
        $this->assertEquals($exp, $res);

        $res = $game->getYouSum();
        $exp = 0;
        $this->assertEquals($exp, $res);

        $res = $game->getCompSum();
        $exp = 0;
        $this->assertEquals($exp, $res);

        $game->newRound();
        $res = $game->compAction();
        $exp = 2;
        $this->assertEquals($exp, $res);

        // $game->newRound();
        $game->switchActive();
        $res = $game->returnActive();
        // $exp = "You";
        $this->assertNotNull($res);

        // $hand = new Dicehand();
        //
        // $hand->rollDices();
        // $res = $hand->returnDice();
        // $this->assertIsArray($res);
    }
}
