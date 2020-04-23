<?php

namespace liba19\Dice100Controller;

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
class Dice100Controller implements AppInjectableInterface
{
    use AppInjectableTrait;



    /**
     * @var string $db a sample member variable that gets initialised
     */
    //private $db = "not active";



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
     * @return object
     */
    public function indexAction() : object
    {
        $page = $this->app->page;
        $title = "Tärningsspelet 100";

        $page->add("dice100controller/index");

        return $page->render([
            "title" => $title,
        ]);
    }



    /**
     * Init the game and decide who should start playing
     *
     * @return object
     */
    public function initAction() : object
    {
        $page = $this->app->page;
        $session = $this->app->session;
        $title = "Tärningsspelet 100";

        // Get current settings from the SESSION
        $resPlayer1 = $session->get("resPlayer1");
        $resComputer = $session->get("resComputer");
        $currentPlayer = $session->get("currentPlayer");


        $data = [
            "resPlayer1" => $resPlayer1 ?? null,
            "resComputer" => $resComputer ?? null,
            "currentPlayer" => $currentPlayer ?? null
        ];

        $page->add("dice100controller/init", $data);

        return $page->render([
            "title" => $title,
        ]);
    }



    /**
     * Delete values from the SESSION in order to
     * roll the dice and start a new game
     *
     * @return object
     */
    public function doinitAction() : object
    {
        $response = $this->app->response;
        $session = $this->app->session;

        // Delete values from the SESSION
        $session->set("resPlayer1", null);
        $session->set("resComputer", null);
        $session->set("currentPlayer", null);
        $session->set("game", null);
        $session->set("valuesDiceRolls", null);
        $session->set("sumGameRound", null);
        $session->set("canContinue", null);

        return $response->redirect("dice100controller/init");
    }



    /**
     * Roll dice for player1 and computer,
     * decide the currentPlayer and redirect to route init
     *
     * @return object
     */
    public function rollAction() : object
    {
        $response = $this->app->response;
        $session = $this->app->session;

        // Delete values from the SESSION
        $session->set("resPlayer1", null);
        $session->set("resComputer", null);

        // Create a new Dice object, roll the dice and save it in the SESSION
        $rollPlayer1 = new Dice();
        $resPlayer1 = $rollPlayer1->roll();
        $session->set("resPlayer1", $resPlayer1);

        $rollComputer = new Dice();
        $resComputer = $rollComputer->roll();
        $session->set("resComputer", $resComputer);

        // Decide who the current player is and save it in SESSION
        // If it was a tie then roll the dices again
        if ($resPlayer1 == $resComputer) {
            return $response->redirect("dice100controller/roll");
        } else {
            $currentPlayer = $resPlayer1 > $resComputer ? "Spelare1" : "Dator";
            $session->set("currentPlayer", $currentPlayer);

            // Create a new Game object and save it in the SESSION
            $game = new Game(3, 6, 0, 0, $currentPlayer, $currentPlayer);
            $session->set("game", $game);

            // Create a new Histogram object and save it in the SESSION
            $histogramObj = new Histogram();
            $session->set("histogramObj", $histogramObj);


            return $response->redirect("dice100controller/init");
        }
    }



    /**
     * Play the game
     *
     * @return object
     */
    public function playAction() : object
    {
        $page = $this->app->page;
        $session = $this->app->session;
        $title = "Tärningsspelet 100";

        // Get current settings from the SESSION
        $valuesDiceRolls = $session->get("valuesDiceRolls");
        $sumGameRound = $session->get("sumGameRound");
        $canContinue = $session->get("canContinue");
        $game = $session->get("game");
        $histogramObj = $session->get("histogramObj");

        // Get values from game object
        $pointsPlayer1 = $game->getPointsPlayer1();
        $pointsComputer = $game->getPointsComputer();
        $currentPlayer = $game->getCurrentPlayer();
        $previousPlayer = $game->getPreviousPlayer();

        // Get values from histogram object and array length of valuesDiceRolls
        if ($valuesDiceRolls) {
            $histogram = $histogramObj->getAsText();
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
            "canContinue" => $canContinue ?? null,
            "histogram" => $histogram ?? null
        ];

        $page->add("dice100controller/play", $data);

        return $page->render([
            "title" => $title,
        ]);
    }



    /**
     * Roll a handful of dices
     *
     * @return object
     */
    public function rollDicesAction() : object
    {
        $response = $this->app->response;
        $session = $this->app->session;

        // Get current settings from the SESSION
        $game = $session->get("game");
        $histogramObj = $session->get("histogramObj");

        // Roll dices and check if they contain number 1
        $game->roll();
        $canContinue = $game->canContinue();

        // Inject values from the dice roll into histogram object
        $histogramObj->injectData($game);

        // Set values for the SESSION
        $session->set("valuesDiceRolls", $game->getValuesDiceRolls());
        $session->set("canContinue", $canContinue);
        $session->set("sumGameRound", $game->sumCurrentGameRound());
        $session->set("histogramObj", $histogramObj);

        // Check if the last roll contained number 1
        // and start a new game round if it does
        if (!$canContinue) {
            $game->newGameRound("Dator", "Spelare1");
        } else {
            // Set previousPlayer in order to display Spelare1's latest dice-rolls
            $game->setPreviousPlayer("Spelare1");
        }

        return $response->redirect("dice100controller/play");
    }



    /**
     * Roll a handful of dices for computer
     *
     * @return object
     */
    public function rollDicesComputerAction() : object
    {
        $response = $this->app->response;
        $session = $this->app->session;

        // Get current settings from the SESSION
        $game = $session->get("game");
        $histogramObj = $session->get("histogramObj");

        // Delete values from the SESSION
        $session->set("canContinue", null);

        // Roll dices
        $game->rollComputer();

        // Inject values from the dice roll into histogram object
        // and put it into SESSION
        $histogramObj->injectData($game);
        $session->set("histogramObj", $histogramObj);

        // Check total points and redirect if they are over 100
        if ($game->checkGameStatus()) {
            return $response->redirect("dice100controller/winner");
        } else {
            // Set values for the SESSION
            $session->set("valuesDiceRolls", $game->getValuesDiceRolls());
            $session->set("sumGameRound", $game->sumCurrentGameRound());

            // New game round
            $game->newGameRound("Spelare1", "Dator");
            return $response->redirect("dice100controller/play");
        }
    }



    /**
     * Save points from current game round
     *
     * @return object
     */
    public function saveAction() : object
    {
        $response = $this->app->response;
        $session = $this->app->session;

        // Get current settings from the SESSION
        $game = $session->get("game");

        // Save the points
        $currentPlayer = $game->getCurrentPlayer();
        $game->savePoints($currentPlayer);

        // Check total points and redirect if they are over 100
        if ($game->checkGameStatus()) {
            return $response->redirect("dice100controller/winner");
        } else {
            // New game round
            $game->newGameRound("Dator", "Spelare1");
            return $response->redirect("dice100controller/play");
        }
    }



    /**
     * Play the game - game won
     *
     * @return object
     */
    public function winnerAction() : object
    {
        $page = $this->app->page;
        $session = $this->app->session;
        $title = "Tärningsspelet 100";

        // Get current settings from the SESSION
        $game = $session->get("game");
        $histogramObj = $session->get("histogramObj");

        // Get values from game object
        $pointsPlayer1 = $game->getPointsPlayer1();
        $pointsComputer = $game->getPointsComputer();
        $currentPlayer = $game->getCurrentPlayer();
        $valuesDiceRolls = $game->getValuesDiceRolls();

        // Get values from histogram object and array length of valuesDiceRolls
        if ($valuesDiceRolls) {
            $histogram = $histogramObj->getAsText();
            $amountDiceRolls = count($valuesDiceRolls);
        }

        $data = [
            "currentPlayer" => $currentPlayer ?? null,
            "pointsPlayer1" => $pointsPlayer1 ?? null,
            "pointsComputer" => $pointsComputer ?? null,
            "valuesDiceRolls" => $valuesDiceRolls ?? null,
            "amountDiceRolls" => $amountDiceRolls ?? null,
            "histogram" => $histogram ?? null
        ];

        $page->add("dice100controller/winner", $data);

        return $page->render([
            "title" => $title,
        ]);
    }
}
