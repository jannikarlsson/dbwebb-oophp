<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Init and start the game from a link
 */
$app->router->get("guess/init", function () use ($app) {
    $game = new Janni\Guess\Guess();
    $_SESSION["number"] = $game->number();
    $_SESSION["tries"] = $game->tries();
    return $app->response->redirect("guess/play");
});

/**
 * Init and start the game from a button
 */
$app->router->post("guess/init", function () use ($app) {
    $game = new Janni\Guess\Guess();
    $_SESSION["number"] = $game->number();
    $_SESSION["tries"] = $game->tries();
    return $app->response->redirect("guess/play");
});

/**
 * Cheat and show the number
 */
$app->router->post("guess/cheat", function () use ($app) {
    $doCheat = $_POST["doCheat"] ?? null;

    $_SESSION["doCheat"] = $doCheat;

    return $app->response->redirect("guess/play");
});

/**
 * Show game status
 */
$app->router->get("guess/play", function () use ($app) {
    $title = "Guess my number";

    $tries = $_SESSION["tries"] ?? null;
    $res = $_SESSION["res"] ?? null;
    $number = $_SESSION["number"] ?? null;
    $_SESSION["res"] = null;
    $doCheat = $_SESSION["doCheat"] ?? null;
    $_SESSION["doCheat"] = null;

    $data = [
        "guess" => $guess ?? null,
        "doGuess" => $doGuess ?? null,
        "doCheat" => $doCheat ?? null,
        "number" => $number ?? null,
        "tries" => $tries,
        "res" => $res
    ];

    $app->page->add("guess/play", $data);
    // $app->page->add("guess/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Make a guess
 */
$app->router->post("guess/play", function () use ($app) {
    $guess = $_POST["guess"] ?? null;
    $doGuess = $_POST["doGuess"] ?? null;
    $number = $_SESSION["number"] ?? null;
    $tries = $_SESSION["tries"] ?? null;
    $res = null;

    try {
            $game = new Janni\Guess\Guess($number, $tries);
            $res = $game->makeGuess((int)$guess);
            $tries = $game->tries();
    } catch (Janni\Guess\GuessException $e) {
        $res = "It will have to be between 1 and 100.";
    }
    $_SESSION["tries"] = $tries;
    $_SESSION["res"] = $res;

    return $app->response->redirect("guess/play");
});
