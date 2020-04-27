<?php

namespace Janni\Dice;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class DiceController implements AppInjectableInterface
{
    use AppInjectableTrait;



    /**
     * @var string $db a sample member variable that gets initialised
     */
    // private $db = "not active";



    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    // public function initialize() : void
    // {
    //     // Use to initialise member variables.
    //     $this->db = "active";
    //
    //     // Use $this->app to access the framework services.
    // }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function indexAction() : string
    {
        // Deal with the action and return a response.
        return "Index!";
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function debugAction() : string
    {
        // Deal with the action and return a response.
        return "Debug my game!";
    }

    /**
     * Initialize and start the game from a link
     */
    public function initAction() : object
    {
        session_destroy();
        session_start();
        $game = new Game();
        $this->app->session->set("game", $game);

        return $this->app->response->redirect("dice1/play");
    }

    /**
     * Roll dices for new hand
     */
    public function rollActionPost() : object
    {
        $this->app->session->delete("action");
        $game = $this->app->session->get("game");
        $game->newDicehand();

        return $this->app->response->redirect("dice1/roll");
    }

    /**
     * Computer's automatic round
     */
    public function autoAction() : object
    {
        $game = $this->app->session->get("game");
        $game->newDicehand();
        $this->app->session->set("action", "Computer rolled.");
        return $this->app->response->redirect("dice1/roll");
    }

    /**
     * Start new round in a new game
     */
    public function roundActionGet() : object
    {
        $game = $this->app->session->get("game");
        $game->newRound();
        $active = $game->returnActive();

        if ($active == "Computer") {
            return $this->app->response->redirect("dice1/auto");
        } else {
            return $this->app->response->redirect("dice1/roll");
        }
    }

    /**
     * Start new round
     */
    public function roundActionPost() : object
    {
        $game = $this->app->session->get("game");
        $game->newRound();
        $game->switchActive();
        $active = $game->returnActive();

        if ($active == "Computer") {
            return $this->app->response->redirect("dice1/auto");
        } else {
            return $this->app->response->redirect("dice1/roll");
        }
    }

    /**
     * Computer's turn
     */
    public function continueAction() : object
    {
        $game = $this->app->session->get("game");
        $loss = $game->getOne();
        $action = $game->compAction();
        if ($loss == true) {
            $game->newRound();
            $game->switchActive();
            $this->app->session->set("action", "Computer rolled a 1 and lost. Your turn to roll.");
        } elseif ($action == 2) {
            $game->newDicehand();
            $this->app->session->set("action", "Computer rolled.");
        } else {
            $game->newRound();
            $game->save();
            $game->switchActive();
            $this->app->session->set("action", "Computer saved. Your turn to roll.");
        }
        return $this->app->response->redirect("dice1/roll");
    }

    /**
     * Save value and give over turn
     */
    public function saveActionPost() : object
    {
        $game = $this->app->session->get("game");
        $game->newRound();
        $game->save();
        $game->switchActive();
        $active = $game->returnActive();
        if ($active == "Computer") {
            return $this->app->response->redirect("dice1/auto");
        } else {
            return $this->app->response->redirect("dice1/roll");
        }
    }

    /**
     * Show game status
     */
    public function playActionGet() : object
    {
        $title = "Guess my number";

        $game = $this->app->session->get("game", null);
        $active = $game->returnActive();
        $dices = $game->returnDiceArray();

        $data = [
            "active" => $active ?? null,
            "dices" => $dices ?? null
        ];

        $this->app->page->add("dice1/play", $data);
        // $this->app->page->add("dice/debug");

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * Start playing
     */
    public function rollActionGet() : object
    {
        $title = "Roll the dice";

        $game = $this->app->session->get("game", null);
        $active = $game->returnActive();
        $dices = $game->returnDiceArray();
        $tempSum = $game->getTemp() ?? null;
        $youSum = $game->getYouSum();
        $compSum = $game->getCompSum();
        $loss = $game->getOne();
        $action = $this->app->session->getOnce("action", null);
        $histogram = $game->histogram;

        $data = [
            "active" => $active,
            "dices" => $dices,
            "sum" => $tempSum,
            "youSum" => $youSum,
            "compSum" => $compSum,
            "loss" => $loss,
            "action" => $action,
            "histogram" => $histogram
        ];

        $this->app->page->add("dice1/roll", $data);
        $this->app->page->add("dice/debug");

        return $this->app->page->render([
            "title" => $title,
        ]);
    }
}
