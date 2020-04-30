<?php

namespace liba19\Movie;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;
use liba19\HandleGlobalVariables\HandleGlobalVariablesTrait;

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
class MovieController implements AppInjectableInterface
{
    use AppInjectableTrait;
    use HandleGlobalVariablesTrait;



    /**
     * @var string $db a sample member variable that gets initialised
     */
    //private $db = "not active";



    /**
     * Initialize and connect to database
     *
     * @return void
     */
    public function initialize() : void
    {
        $this->app->db->connect();
    }



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
        $response = $this->app->response;

        $_SESSION["year1"] = null;
        $_SESSION["year2"] = null;
        $_SESSION["resSearchYear"] = null;
        $_SESSION["searchTitle"] = null;
        $_SESSION["resSearchTitle"] = null;

        return $response->redirect("movie/show-movies");
    }



    /**
     * Show movies
     * Show search results or all movies
     *
     * @return object
     */
    public function showMoviesAction() : object
    {
        $db = $this->app->db;
        $page = $this->app->page;

        $title = "Show movies";

        if (isset($_SESSION["resSearchTitle"])) {
            $resultset = $this->getSession("resSearchTitle");
            $searchTitle = $this->getSession("searchTitle");
        } elseif (isset($_SESSION["resSearchYear"])) {
            $year1 = $this->getSession("year1");
            $year2 = $this->getSession("year2");
            $resultset = $this->getSession("resSearchYear");
        } else {
            $sql = "SELECT * FROM movie;";
            $resultset = $db->executeFetchAll($sql);
        }

        $page->add("movie/sidebar");
        $page->add("movie/article-header");
        $page->add("movie/search-title", [
            "searchTitle" => $searchTitle ?? null,
        ]);
        $page->add("movie/search-year", [
            "year1" => $year1 ?? null,
            "year2" => $year2 ?? null,
        ]);
        $page->add("movie/show-movies", [
            "resultset" => $resultset,
        ]);
        $page->add("movie/article-footer");

        return $page->render([
            "title" => $title,
        ]);
    }



    /**
     * Search in movie database on title and redirect to movie/show-movies
     *
     * @return void
     */
    public function searchTitleAction()
    {
        $db = $this->app->db;
        $response = $this->app->response;

        $_SESSION["year1"] = null;
        $_SESSION["year2"] = null;
        $_SESSION["resSearchYear"] = null;
        $_SESSION["searchTitle"] = null;
        $_SESSION["resSearchTitle"] = null;

        $searchTitle = $this->getGet("searchTitle");
        $searchTitle = $this->esc($searchTitle);

        if ($searchTitle) {
            $sql = "SELECT * FROM movie WHERE title LIKE ?;";
            $resultset = $db->executeFetchAll($sql, [$searchTitle]);
        }

        $_SESSION["searchTitle"] = $searchTitle;
        $_SESSION["resSearchTitle"] = $resultset;

        return $response->redirect("movie/show-movies");
    }



    /**
     * Search in movie database on year and redirect to movie/show-movies
     *
     * @return void
     */
    public function searchYearAction()
    {
        $db = $this->app->db;
        $response = $this->app->response;

        $_SESSION["year1"] = null;
        $_SESSION["year2"] = null;
        $_SESSION["resSearchYear"] = null;
        $_SESSION["searchTitle"] = null;
        $_SESSION["resSearchTitle"] = null;

        $year1 = $this->getGet("year1");
        $year2 = $this->getGet("year2");

        if ($year1 && $year2) {
            $sql = "SELECT * FROM movie WHERE year >= ? AND year <= ?;";
            $resultset = $db->executeFetchAll($sql, [$year1, $year2]);
        } elseif ($year1) {
            $sql = "SELECT * FROM movie WHERE year >= ?;";
            $resultset = $db->executeFetchAll($sql, [$year1]);
        } elseif ($year2) {
            $sql = "SELECT * FROM movie WHERE year <= ?;";
            $resultset = $db->executeFetchAll($sql, [$year2]);
        }

        $_SESSION["year1"] = $year1;
        $_SESSION["year2"] = $year2;
        $_SESSION["resSearchYear"] = $resultset;

        return $response->redirect("movie/show-movies");
    }



    /**
     * Select a movie in order to edit or delete
     *
     * @return object
     */
    public function movieSelectAction() : object
    {
        $db = $this->app->db;
        $page = $this->app->page;

        $title = "Select a movie";

        $sql = "SELECT id, title FROM movie;";
        $movies = $db->executeFetchAll($sql);

        $page->add("movie/sidebar");
        $page->add("movie/article-header");
        $page->add("movie/movie-select", [
            "movies" => $movies,
        ]);
        $page->add("movie/article-footer");

        return $page->render([
            "title" => $title,
        ]);
    }



    /**
     * Add a new movie and redirect to movie-edit in order to edit its details
     *
     * @return void
     */
    public function movieAddProcessAction()
    {
        $db = $this->app->db;
        $response = $this->app->response;

        if ($this->getPost("doAdd")) {
            $sql = "INSERT INTO movie (title, year, image) VALUES (?, ?, ?);";
            $db->execute($sql, ["A title", 2020, "img/noimage.png"]);
            $movieId = $db->lastInsertId();
        }

        return $response->redirect("movie/movie-edit?movieId=$movieId");
    }



    /**
     * Show a movies details in order to update or delete it
     *
     * @return object
     */
    public function movieEditAction() : object
    {
        $db = $this->app->db;
        $page = $this->app->page;
        $response = $this->app->response;

        $title = "Edit movie";
        $movieId = $this->getPost("movieId") ?: $this->getGet("movieId");

        if (!$movieId) {
            return $response->redirect("movie/movie-select");
        }

        $sql = "SELECT * FROM movie WHERE id = ?;";
        $movie = $db->executeFetchAll($sql, [$movieId]);
        $movie = $movie[0];

        $page->add("movie/sidebar");
        $page->add("movie/article-header");
        $page->add("movie/movie-edit", [
            "movie" => $movie,
        ]);
        $page->add("movie/article-footer");

        return $page->render([
            "title" => $title,
        ]);
    }



    /**
     * Delete or update a movie
     *
     * @return void
     */
    public function movieEditProcessAction()
    {
        $db = $this->app->db;
        $response = $this->app->response;

        $movieId = $this->getPost("movieId") ?: $this->getGet("movieId");
        $movieTitle = $this->getPost("movieTitle");
        $movieYear  = $this->getPost("movieYear");
        $movieImage = $this->getPost("movieImage");

        if ($this->getPost("doDelete")) {
            $sql = "DELETE FROM movie WHERE id = ?;";
            $db->execute($sql, [$movieId]);
        } elseif ($this->getPost("doSave")) {
            $sql = "UPDATE movie SET title = ?, year = ?, image = ? WHERE id = ?;";
            $db->execute($sql, [$movieTitle, $movieYear, $movieImage, $movieId]);
        }

        return $response->redirect("movie/movie-select");
    }



    /**
     * Sanitize value for output in view.
     *
     * @param string $value to sanitize
     *
     * @return string beeing sanitized
     */
    private function esc($value)
    {
        return htmlentities($value);
    }
}
