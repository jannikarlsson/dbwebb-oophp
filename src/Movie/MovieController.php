<?php

namespace Janni\Movie;

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
class MovieController implements AppInjectableInterface
{
    use AppInjectableTrait;



    /**
     * @var string $db a sample member variable that gets initialised
     */
    // private $db = "not active";



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
     * @return string
     * @SuppressWarnings(PHPMD.ExitExpression)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function indexActionGet() : object
    {
        $title = "Movie database | oophp";

        $db = $this->app->db->connect();
        $movie = new Movie();

        // Get number of hits per page
        $hits = getGet("hits", 4);
        if (!(is_numeric($hits) && $hits > 0 && $hits <= 8)) {
            die("Not valid for hits.");
        }

        // Get max number of pages
        $max = $movie->getMax($db, $hits);

        // Get current page
        $page = getGet("page", 1);
        if (!(is_numeric($hits) && $page > 0 && $page <= $max)) {
            die("Not valid for page.");
        }
        $offset = $hits * ($page - 1);

        // Get settings from GET or use defaults
        $orderBy = getGet("orderby") ?: "id";
        $order = getGet("order") ?: "asc";

        // Only these values are valid
        $columns = ["id", "title", "year", "image"];
        $orders = ["asc", "desc"];

        // Incoming matches valid value sets
        if (!(in_array($orderBy, $columns) && in_array($order, $orders))) {
            die("Not valid input for sorting.");
        }

        $sql = "SELECT * FROM movie ORDER BY $orderBy $order LIMIT $hits OFFSET $offset;";
        $resultset = $this->app->db->executeFetchAll($sql);

        $this->app->page->add("movie/header");
        $this->app->page->add("movie/index", [
            "resultset" => $resultset,
            "max" => $max
        ]);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * Show SELECT *
     */
    public function selectActionGet() : object
    {
        $title = "Select all | oophp";

        $this->app->db->connect();
        $sql = "SELECT * FROM movie;";
        $res = $this->app->db->executeFetchAll($sql);

        $this->app->page->add("movie/header");
        $this->app->page->add("movie/select", [
            "resultset" => $res,
            "sql" => $sql
        ]);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * Search movies by title
     */
    public function searchTitleActionGet() : object
    {
        $title = "Search title | oophp";

        $this->app->db->connect();
        $searchTitle = getGet("searchTitle");

        $this->app->page->add("movie/header");
        $this->app->page->add("movie/search-title", [
            "searchTitle" => $searchTitle
        ]);

        if ($searchTitle) {
            $sql = "SELECT * FROM movie WHERE title LIKE ?;";
            $res = $this->app->db->executeFetchAll($sql, [$searchTitle]);
            $this->app->page->add("movie/result", [
                "resultset" => $res
            ]);
        }

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * Search movies by year
     */
    public function searchYearActionGet() : object
    {
        $title = "Search year | oophp";

        $db = $this->app->db->connect();
        $year1 = getGet("year1");
        $year2 = getGet("year2");

        $this->app->page->add("movie/header");
        $this->app->page->add("movie/search-year", [
            "year1" => $year1,
            "year2" => $year2
        ]);

        $movie = new Movie();
        $resultset = $movie->searchYear($db, $year1, $year2);

        $this->app->page->add("movie/result", [
            "resultset" => $resultset
        ]);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * Reset the database
     */
    public function resetActionGet() : object
    {
        $title = "Resets the database | oophp";

        $output = null;
        $dbConfig = $this->app->configuration->load("database");
        $reset = getGet("reset", null);

        if ($reset != null) {
            $movie = new Movie();
            $output = $movie->resetDatabase($dbConfig);
        }

        $this->app->page->add("movie/header");
        $this->app->page->add("movie/reset", [
            "output" => $output
        ]);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * Select movie to edit or delete
     */
    public function movieSelectActionGet() : object
    {
        $title = "Select a movie | oophp";

        $this->app->db->connect();
        $sql = "SELECT id, title FROM movie;";
        $movies = $this->app->db->executeFetchAll($sql);

        $this->app->page->add("movie/header");
        $this->app->page->add("movie/movie-select", [
            "movies" => $movies
        ]);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * Delete movie
     */
    public function deleteActionPost() : object
    {
        $movieId = getPost("movieId");
        $this->app->db->connect();
        $sql = "DELETE FROM movie WHERE id = ?;";
        $this->app->db->execute($sql, [$movieId]);

        return $this->app->response->redirect("movie/movie-select");
    }

    /**
     * Add movie
     */
    public function movieAddActionPost() : object
    {
        $this->app->db->connect();
        $sql = "INSERT INTO movie (title, year, image) VALUES (?, ?, ?);";
        $this->app->db->execute($sql, ["A title", 2017, "img/noimage.png"]);
        $movieId = $this->app->db->lastInsertId();

        return $this->app->response->redirect("movie/movie-edit?movieId=$movieId");
    }

    /**
     * Edit movie
     */
    public function movieEditAction() : object
    {
        $title = "Edit a movie | oophp";

        $movieId = getPost("movieId") ?: getGet("movieId");

        $this->app->db->connect();
        $sql = "SELECT * FROM movie WHERE id = ?;";
        $movie = $this->app->db->executeFetchAll($sql, [$movieId]);
        $movie = $movie[0];

        $this->app->page->add("movie/header");
        $this->app->page->add("movie/movie-edit", [
            "movie" => $movie
        ]);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * Save edits
     */
    public function saveActionPost() : object
    {
        $movieId    = getPost("movieId");
        $movieTitle = getPost("movieTitle");
        $movieYear  = getPost("movieYear");
        $movieImage = getPost("movieImage");

        $this->app->db->connect();
        $sql = "UPDATE movie SET title = ?, year = ?, image = ? WHERE id = ?;";
        $this->app->db->execute($sql, [$movieTitle, $movieYear, $movieImage, $movieId]);

        return $this->app->response->redirect("movie/movie-edit?movieId=$movieId");
    }
}
