<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Init and start the game from a link
 */
$app->router->get("dice/init", function () use ($app) {
    session_destroy();
    session_start();
    $app->session->set("tempSum", 0);
    $game = new Janni\Dice\Game();
    // $app->session->set("dices", $game->diceArray);
    // $app->session->set("active", $game->active);

    return $app->response->redirect("dice/play");
});

/**
 * Roll dices for new hand
 */
$app->router->post("dice/roll", function () use ($app) {
    $app->session->delete("action");
    $temp = $app->session->get("tempSum");
    $hand = new Janni\Dice\Dicehand($temp);
    $app->session->set("tempSum", $hand->tempSum);
    $app->session->set("dices", $hand->diceArray);
    $app->session->set("loss", $hand->one);
    return $app->response->redirect("dice/roll");
});

/**
 * Computer's automatic round
 */
$app->router->get("dice/auto", function () use ($app) {
    $temp = $app->session->get("tempSum");
    $hand = new Janni\Dice\Dicehand($temp);
    $app->session->set("tempSum", $hand->tempSum);
    $app->session->set("dices", $hand->diceArray);
    $app->session->set("loss", $hand->one);
    $app->session->set("action", "Computer rolled.");
    return $app->response->redirect("dice/roll");
});

/**
 * Start new round in a new game
 */
$app->router->get("dice/round", function () use ($app) {
    $app->session->delete("dices");
    $round = new Janni\Dice\Round();
    $round->active = $app->session->get("active");
    $active = $round->returnActive();
    $app->session->set("active", $active);
    if ($active == "Computer") {
        return $app->response->redirect("dice/auto");
    } else {
        return $app->response->redirect("dice/roll");
    }
});

/**
 * Start new round
 */
$app->router->post("dice/round", function () use ($app) {
    $app->session->set("loss", false);
    $round = new Janni\Dice\Round();
    $round->active = $app->session->get("active");
    $round->switchActive();
    $app->session->set("active", $round->active);
    $active = $app->session->get("active");
    if ($active == "Computer") {
        return $app->response->redirect("dice/auto");
    } else {
        return $app->response->redirect("dice/roll");
    }
});

/**
 * Computer's turn
 */
$app->router->post("dice/continue", function () use ($app) {
    $loss = $app->session->get("loss");
    $action = rand(1, 3);
    if ($loss == true) {
        $app->session->set("loss", false);
        $app->session->delete("dices");
        $round = new Janni\Dice\Round();
        $round->active = $app->session->get("active");
        $round->switchActive();
        $app->session->set("active", $round->active);
        $app->session->set("action", "Computer rolled a 1 and lost. Your turn to roll.");
    } elseif ($action < 3) {
        $temp = $app->session->get("tempSum");
        $hand = new Janni\Dice\Dicehand($temp);
        $app->session->set("tempSum", $hand->tempSum);
        $app->session->set("dices", $hand->diceArray);
        $app->session->set("loss", $hand->one);
        $app->session->set("action", "Computer rolled.");
    } else {
        $app->session->delete("dices");
        $round = new Janni\Dice\Round();
        $round->active = $app->session->get("active");
        $round->switchActive();
        $round->save();
        $app->session->set("active", $round->active);
        $app->session->set("action", "Computer saved. Your turn to roll.");
    }
    return $app->response->redirect("dice/roll");
});

/**
 * Save value and give over turn
 */
$app->router->post("dice/save", function () use ($app) {
    $app->session->delete("dices");
    $round = new Janni\Dice\Round();
    $round->active = $app->session->get("active");
    $round->switchActive();
    $round->save();
    $app->session->set("active", $round->active);
    $active = $app->session->get("active");
    if ($active == "Computer") {
        return $app->response->redirect("dice/auto");
    } else {
        return $app->response->redirect("dice/roll");
    }
});

/**
 * Show game status
 */
$app->router->get("dice/play", function () use ($app) {
    $title = "Guess my number";

    $active = $app->session->get("active", null);
    $dices = $app->session->get("dices", null);

    $data = [
        "begins" => $begins ?? null,
        "active" => $active ?? null,
        "dices" => $dices ?? null
    ];

    $app->page->add("dice/play", $data);
    // $app->page->add("dice/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Start playing
 */
$app->router->get("dice/roll", function () use ($app) {
    $title = "Roll the dice";

    $active = $app->session->get("active", null);
    $dices = $app->session->get("dices", null);
    $tempSum = $app->session->get("tempSum", null);
    $youSum = $app->session->get("youSum", 0);
    $compSum = $app->session->get("compSum", 0);
    $loss = $app->session->get("loss", null);
    $action = $app->session->get("action", null);

    $data = [
        "active" => $active,
        "dices" => $dices,
        "sum" => $tempSum,
        "youSum" => $youSum,
        "compSum" => $compSum,
        "loss" => $loss,
        "action" => $action
    ];

    $app->page->add("dice/roll", $data);
    // $app->page->add("dice/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});
