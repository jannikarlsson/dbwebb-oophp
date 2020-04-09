<link rel="stylesheet" href="css/style.css">
<?php

/**
* Guess my number game
*/

include(__DIR__ . "/config.php");
include(__DIR__ . "/autoload.php");

/**
* Get current from the session
*/
$guess = $_SESSION["guess"] ?? null;
$doInit = $_SESSION["doInit"] ?? null;
$doGuess = $_SESSION["doGuess"] ?? null;
$doCheat = $_SESSION["doCheat"] ?? null;
$number = $_SESSION["number"] ?? null;
$tries = $_SESSION["tries"] ?? null;

if ($doInit || $number === null) {
    session_destroy();
    session_start();
    $object = new Guess();
    $_SESSION["number"] = $object->number();
    $_SESSION["tries"] = $object->tries();
} elseif ($doGuess) {
    try {
        $object = new Guess($number, $tries);
        $_SESSION["res"] = $object->makeGuess((int)$guess);
        $_SESSION["tries"] = $object->tries();
    } catch (GuessException $e) {
        $_SESSION["res"] = "It will have to be between 1 and 100.";
    }
    $_SESSION["doGuess"] = null;
};

require __DIR__ . "/view/guess_number.php";
