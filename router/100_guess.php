<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Init the game and redirect to play the game
 */
$app->router->get("guess/init", function () use ($app) {
    // Delete incoming values from SESSION
    $_SESSION["res"] = null;
    $_SESSION["guessNum"] = null;

    // Init the game
    $game = new liba19\Guess\Guess();
    $_SESSION["number"] = $game->number();
    $_SESSION["tries"] = $game->tries();
    return $app->response->redirect("guess/play");
});



/**
 * Play the game - show game status
 */
$app->router->get("guess/play", function () use ($app) {
    $title = "Play the game";

    // Get current settings from the SESSION
    $tries = $_SESSION["tries"] ?? null;
    $number = $_SESSION["number"] ?? null;
    $res = $_SESSION["res"] ?? null;
    $guessNum = $_SESSION["guessNum"] ?? null;
    $doCheat = $_SESSION["doCheat"] ?? null;

    // Delete values from the session
    $_SESSION["res"] = null;
    $_SESSION["guessNum"] = null;
    $_SESSION["doCheat"] = null;

    $data = [
        "guessNum" => $guessNum ?? null,
        "res" => $res,
        "doCheat" => $doCheat ?? null,
        "doGuess" => $doGuess ?? null,
        "number" => $number ?? null,
        "tries" => $tries
    ];

    $app->page->add("guess/play", $data);
    $app->page->add("guess/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});



/**
 * Play the game - make a guess
 */
$app->router->post("guess/make-guess", function () use ($app) {

    // Deal with incoming variables
    $guessNum = $_POST["guessNum"] ?? null;

    // Get current settings from the SESSION
    $number = $_SESSION["number"] ?? null;
    $tries = $_SESSION["tries"] ?? null;

    // Make a guess
    if ($guessNum) {
        $game = new liba19\Guess\Guess($number, $tries);
        $res = $game->makeGuess($guessNum);
        $_SESSION["tries"] = $game->tries();
        $_SESSION["res"] = $res;
        $_SESSION["guessNum"] = $guessNum;
    }

    if ($res == "CORRECT") {
        return $app->response->redirect("guess/correct-guess");
    } elseif ($guessNum && $res !== "CORRECT" && $tries === 1) {
        return $app->response->redirect("guess/failed");
    }
    return $app->response->redirect("guess/play");
});



/**
 * Play the game - cheat
 */
$app->router->get("guess/cheat", function () use ($app) {
    // Set SESSION variable in order to show the correct number
    $_SESSION["doCheat"] = $_GET["doCheat"];

    return $app->response->redirect("guess/play");
});



/**
 * Play the game - game won
 */
$app->router->get("guess/correct-guess", function () use ($app) {
    $title = "You won!";

    // Get current settings from the SESSION
    $res = $_SESSION["res"] ?? null;
    $guessNum = $_SESSION["guessNum"] ?? null;

    $data = [
        "guessNum" => $guessNum,
        "res" => $res
    ];

    $app->page->add("guess/correct-guess", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});



/**
 * Play the game - game lost
 */
$app->router->get("guess/failed", function () use ($app) {
    $title = "You lost!";

    // Get current settings from the SESSION
    $tries = $_SESSION["tries"] ?? null;
    $res = $_SESSION["res"] ?? null;
    $guessNum = $_SESSION["guessNum"] ?? null;
    $number = $_SESSION["number"] ?? null;

    $data = [
        "guessNum" => $guessNum,
        "res" => $res,
        "tries" => $tries,
        "number" => $number
    ];

    $app->page->add("guess/failed", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});
