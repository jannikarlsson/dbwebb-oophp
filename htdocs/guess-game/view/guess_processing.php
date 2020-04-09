<?php
include("../config.php");

// if ($_POST["guess"] = '') {
//     $_SESSION["guess"] = 0;
// } else {
//     $_SESSION["guess"] = $_POST["guess"] ?? null;
// }
$_SESSION["guess"] = $_POST["guess"] ?? null;
$_SESSION["doInit"] = $_POST["doInit"] ?? null;
$_SESSION["doGuess"] = $_POST["doGuess"] ?? null;
$_SESSION["doCheat"] = $_POST["doCheat"] ?? null;

header('Location: ../index.php');
