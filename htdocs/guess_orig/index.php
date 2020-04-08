<?php

include(__DIR__ . "/config.php");
include(__DIR__ . "/autoload.php");

//Start a named session
session_name("liba19");
session_start();


$guessNum = $_POST["guessNum"] ?? null;
$doInit = $_POST["doInit"] ?? null;
$doGuess = $_POST["doGuess"] ?? null;
$doCheat = $_POST["doCheat"] ?? null;

$number = $_SESSION["number"] ?? null;
$tries = $_SESSION["tries"] ?? null;
$game = null;
$res = null;


if ($doInit || $number === null) {
    // Init the game
    $game = new Guess();
    $_SESSION["number"] = $game->number();
    $_SESSION["tries"] = $game->tries();
} elseif ($doGuess) {
    // Make a guess
    $game = new Guess($number, $tries);
    $res = $game->makeGuess($guessNum);
    $_SESSION["tries"] = $game->tries();
}



require __DIR__ . "/view/guess_number.php";
