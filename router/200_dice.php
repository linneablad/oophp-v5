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

    // Get current settings from the session
    $resPlayer1 = $_SESSION["resPlayer1"] ?? null;
    $resComputer = $_SESSION["resComputer"] ?? null;
    $winner = $_SESSION["winner"] ?? null;

    $data = [
        "resPlayer1" => $resPlayer1 ?? null,
        "resComputer" => $resComputer ?? null,
        "winner" => $winner ?? null
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
$app->router->get("dice100/doInit", function () use ($app) {
    // Delete values from the SESSION
    $_SESSION["resPlayer1"] = null;
    $_SESSION["resComputer"] = null;
    $_SESSION["winner"] = null;

    return $app->response->redirect("dice100/init");
});



/**
 * Roll dice for player1 and computer,
 * decide the winner and redirect to route init
 */
$app->router->get("dice100/roll", function () use ($app) {
    // Delete values from the SESSION
    $_SESSION["resPlayer1"] = null;
    $_SESSION["resComputer"] = null;
    $_SESSION["winner"] = null;

    // Create a new Dice object, roll the dice and save it in the SESSION
    $rollPlayer1 = new Liba19\Dice100\Dice();
    $resPlayer1 = $rollPlayer1->roll();
    $_SESSION["resPlayer1"] = $resPlayer1;

    $rollComputer = new Liba19\Dice100\Dice();
    $resComputer = $rollComputer->roll();
    $_SESSION["resComputer"] = $resComputer;

    // Decide who the winner is and save it in the SESSION
    if ($resPlayer1 > $resComputer) {
        $winner = "Spelare 1";
    } else {
        $winner = "Datorn";
    }
    $_SESSION["winner"] = $winner;
    $dice100 = new Liba19\Dice100\Dice100();
    $_SESSION["dice100"] = $dice100;

    return $app->response->redirect("dice100/init");
});
