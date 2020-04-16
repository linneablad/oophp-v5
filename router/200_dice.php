<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Init the game and decide who should start playing
 */
$app->router->get("dice100/init", function () use ($app) {
    $title = "Tärningsspelet 100";

    // Get current settings from the SESSION
    $resPlayer1 = $_SESSION["resPlayer1"] ?? null;
    $resComputer = $_SESSION["resComputer"] ?? null;
    $currentPlayer = $_SESSION["currentPlayer"] ?? null;

    $data = [
        "resPlayer1" => $resPlayer1 ?? null,
        "resComputer" => $resComputer ?? null,
        "currentPlayer" => $currentPlayer ?? null
    ];

    $app->page->add("dice100/init", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});



/**
 * Delete values from the SESSION in order to
 * roll the dice and start a new game
 */
$app->router->get("dice100/do-init", function () use ($app) {
    // Delete values from the SESSION
    $_SESSION["resPlayer1"] = null;
    $_SESSION["resComputer"] = null;
    $_SESSION["currentPlayer"] = null;
    $_SESSION["previousPlayer"] = null;
    $_SESSION["game"] = null;
    $_SESSION["valuesDiceRolls"] = null;
    $_SESSION["sumGameRound"] = null;
    $_SESSION["canContinue"] = null;

    return $app->response->redirect("dice100/init");
});



/**
 * Roll dice for player1 and computer,
 * decide the currentPlayer and redirect to route init
 */
$app->router->get("dice100/roll", function () use ($app) {
    // Delete values from the SESSION
    $_SESSION["resPlayer1"] = null;
    $_SESSION["resComputer"] = null;
    $_SESSION["currentPlayer"] = null;

    // Create a new Dice object, roll the dice and save it in the SESSION
    $rollPlayer1 = new liba19\Dice100\Dice();
    $resPlayer1 = $rollPlayer1->roll();
    $_SESSION["resPlayer1"] = $resPlayer1;

    $rollComputer = new liba19\Dice100\Dice();
    $resComputer = $rollComputer->roll();
    $_SESSION["resComputer"] = $resComputer;

    // Decide who the current player is and save it in the SESSION
    $currentPlayer = $resPlayer1 > $resComputer ? "Spelare1" : "Dator";
    $_SESSION["currentPlayer"] = $currentPlayer;
    $_SESSION["previousPlayer"] = $currentPlayer;

    // Create a new Game object and save it in the SESSION
    $game = new liba19\Dice100\Game(0, 0, $currentPlayer);
    $_SESSION["game"] = $game;

    return $app->response->redirect("dice100/init");
});



/**
 * Play the game
 */
$app->router->get("dice100/play", function () use ($app) {
    $title = "Tärningsspelet 100";

    // Get current settings from the SESSION
    $previousPlayer = $_SESSION["previousPlayer"] ?? null;
    $valuesDiceRolls = $_SESSION["valuesDiceRolls"] ?? null;
    $sumGameRound = $_SESSION["sumGameRound"] ?? null;
    $canContinue = $_SESSION["canContinue"] ?? null;
    $game = $_SESSION["game"] ?? null;

    // Set values for the SESSION
    $_SESSION["previousPlayer"] = $game->getCurrentPlayer();

    // Get values from game object
    $pointsPlayer1 = $game->getPointsPlayer1();
    $pointsComputer = $game->getPointsComputer();
    $currentPlayer = $game->getCurrentPlayer();

    // Count how many elements $valuesDiceRolls contains
    // in order to present them in view play
    if ($valuesDiceRolls) {
        $amountDiceRolls = count($valuesDiceRolls);
    }

    $data = [
        "currentPlayer" => $currentPlayer ?? null,
        "previousPlayer" => $previousPlayer ?? null,
        "sumGameRound" => $sumGameRound ?? null,
        "pointsPlayer1" => $pointsPlayer1 ?? null,
        "pointsComputer" => $pointsComputer ?? null,
        "valuesDiceRolls" => $valuesDiceRolls ?? null,
        "amountDiceRolls" => $amountDiceRolls ?? null,
        "canContinue" => $canContinue ?? null
    ];

    $app->page->add("dice100/play", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});



/**
 * Roll a handful of dices
 */
$app->router->get("dice100/roll-dices", function () use ($app) {
    // Get current settings from the SESSION
    $game = $_SESSION["game"] ?? null;

    // Roll dices and check if it contained number 1
    $game->roll();
    $canContinue = $game->canContinue();

    // Set values for the SESSION
    $_SESSION["valuesDiceRolls"] = $game->getValuesDiceRolls();
    $_SESSION["canContinue"] = $canContinue;
    $_SESSION["sumGameRound"] = $game->sumCurrentGameRound();

    // Check if the last roll contained number 1
    // and start a new game round if it does
    if (!$canContinue) {
        $game->newGameRound("Dator");
    }
    return $app->response->redirect("dice100/play");
});



/**
 * Roll a handful of dices for computer
 */
$app->router->get("dice100/roll-dices-computer", function () use ($app) {
    // Get current settings from the SESSION
    $game = $_SESSION["game"] ?? null;

    // Delete values from the SESSION
    $_SESSION["canContinue"] = null;

    // Roll dices and set values for the SESSION
    $game->rollComputer();
    $_SESSION["valuesDiceRolls"] = $game->getValuesDiceRolls();
    $_SESSION["sumGameRound"] = $game->sumCurrentGameRound();

    // Check total points and redirect if they are over 100
    if ($game->checkGameStatus()) {
        return $app->response->redirect("dice100/winner");
    }

    // New game round
    $game->newGameRound("Spelare1");

    return $app->response->redirect("dice100/play");
});



/**
 * Save points from current game round
 */
$app->router->get("dice100/save", function () use ($app) {
    // Get current settings from the SESSION
    $game = $_SESSION["game"] ?? null;

    // Save the points
    $currentPlayer = $game->getCurrentPlayer();
    $game->savePoints($currentPlayer);

    // Check total points and redirect if they are over 100
    if ($game->checkGameStatus()) {
        return $app->response->redirect("dice100/winner");
    }

    // New game round
    $game->newGameRound("Dator");

    return $app->response->redirect("dice100/play");
});



/**
 * Play the game - game won
 */
$app->router->get("dice100/winner", function () use ($app) {
    $title = "Tärningsspelet 100";

    // Get current settings from the SESSION
    $valuesDiceRolls = $_SESSION["valuesDiceRolls"] ?? null;
    $game = $_SESSION["game"] ?? null;

    // Get values from game object
    $pointsPlayer1 = $game->getPointsPlayer1();
    $pointsComputer = $game->getPointsComputer();
    $currentPlayer = $game->getCurrentPlayer();

    // Count how many elements $valuesDiceRolls contains
    if ($valuesDiceRolls) {
        $amountDiceRolls = count($valuesDiceRolls);
    }

    $data = [
        "currentPlayer" => $currentPlayer ?? null,
        "pointsPlayer1" => $pointsPlayer1 ?? null,
        "pointsComputer" => $pointsComputer ?? null,
        "valuesDiceRolls" => $valuesDiceRolls ?? null,
        "amountDiceRolls" => $amountDiceRolls ?? null
    ];

    $app->page->add("dice100/winner", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});
