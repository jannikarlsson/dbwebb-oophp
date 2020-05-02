<?php

// /**
//  * Show all movies.
//  */
//
// $app->router->get("movie/index", function () use ($app) {
//     $title = "Movie database | oophp";
//
//     $app->db->connect();
//     $sql = "SELECT * FROM movie;";
//     $res = $app->db->executeFetchAll($sql);
//
//     $app->page->add("movie/header");
//     $app->page->add("movie/index", [
//         "resultset" => $res
//     ]);
//
//     return $app->page->render([
//         "title" => $title,
//     ]);
// });

/**
 * Show SELECT *
 */

// $app->router->get("movie/select", function () use ($app) {
//     $title = "Select all | oophp";
//
//     // $db = new Janni\Movie\Database();
//     $app->db->connect();
//     $sql = "SELECT * FROM movie;";
//     $res = $app->db->executeFetchAll($sql);
//
//     $app->page->add("movie/header");
//     $app->page->add("movie/select", [
//         "resultset" => $res,
//         "sql" => $sql
//     ]);
//
//     return $app->page->render([
//         "title" => $title,
//     ]);
// });

/**
 * Search movies by title
 */

// $app->router->get("movie/search-title", function () use ($app) {
//     $title = "Search title | oophp";
//
//     $app->db->connect();
//     $searchTitle = getGet("searchTitle");
//
//     $app->page->add("movie/header");
//     $app->page->add("movie/search-title", [
//         "searchTitle" => $searchTitle
//     ]);
//
//     if ($searchTitle) {
//         $sql = "SELECT * FROM movie WHERE title LIKE ?;";
//         $res = $app->db->executeFetchAll($sql, [$searchTitle]);
//         $app->page->add("movie/index", [
//             "resultset" => $res
//         ]);
//     }
//
//     return $app->page->render([
//         "title" => $title,
//     ]);
// });


/**
 * Search movies by year
 */

// $app->router->get("movie/search-year", function () use ($app) {
//     $title = "Search year | oophp";
//
//     $app->db->connect();
//     $year1 = getGet("year1");
//     $year2 = getGet("year2");
//
//     $app->page->add("movie/header");
//     $app->page->add("movie/search-year", [
//         "year1" => $year1,
//         "year2" => $year2
//     ]);
//
//     if ($year1 && $year2) {
//         $sql = "SELECT * FROM movie WHERE year >= ? AND year <= ?;";
//         $resultset = $app->db->executeFetchAll($sql, [$year1, $year2]);
//         $app->page->add("movie/index", [
//             "resultset" => $resultset
//         ]);
//     } elseif ($year1) {
//         $sql = "SELECT * FROM movie WHERE year >= ?;";
//         $resultset = $app->db->executeFetchAll($sql, [$year1]);
//         $app->page->add("movie/index", [
//             "resultset" => $resultset
//         ]);
//     } elseif ($year2) {
//         $sql = "SELECT * FROM movie WHERE year <= ?;";
//         $resultset = $app->db->executeFetchAll($sql, [$year2]);
//         $app->page->add("movie/index", [
//             "resultset" => $resultset
//         ]);
//     }
//
//     return $app->page->render([
//         "title" => $title,
//     ]);
// });

/**
 * Reset the database
 */

// $app->router->get("movie/reset", function () use ($app) {
//     $title = "Resets the database | oophp";
//
//     $dbConfig = $app->configuration->load("database");
//
//     $app->page->add("movie/header");
//     $app->page->add("movie/reset", [
//         "dbConfig" => $dbConfig
//     ]);
//
//     return $app->page->render([
//         "title" => $title,
//     ]);
// });

/**
 * Select movie to edit or delete
 */

// $app->router->get("movie/movie-select", function () use ($app) {
//     $title = "Select a movie | oophp";
//
//     $app->db->connect();
//     $sql = "SELECT id, title FROM movie;";
//     $movies = $app->db->executeFetchAll($sql);
//
//     $app->page->add("movie/header");
//     $app->page->add("movie/movie-select", [
//         "movies" => $movies
//     ]);
//
//     return $app->page->render([
//         "title" => $title,
//     ]);
// });

/**
 * Delete movie
 */

// $app->router->post("movie/delete", function () use ($app) {
//     $movieId = getPost("movieId");
//     $app->db->connect();
//     $sql = "DELETE FROM movie WHERE id = ?;";
//     $app->db->execute($sql, [$movieId]);
//
//     return $app->response->redirect("movie/movie-select");
// });

/**
 * Add movie
 */

// $app->router->post("movie/movie-add", function () use ($app) {
//     $title = "Add a movie | oophp";
//
//     $app->db->connect();
//     $sql = "INSERT INTO movie (title, year, image) VALUES (?, ?, ?);";
//     $app->db->execute($sql, ["A title", 2017, "img/noimage.png"]);
//     $movieId = $app->db->lastInsertId();
//
//     return $app->response->redirect("movie/movie-edit?movieId=$movieId");
// });


// /**
//  * Edit movie POST
//  */
//
// $app->router->post("movie/movie-edit", function () use ($app) {
//     $title = "Edit a movie | oophp";
//
//     $movieId = getPost("movieId");
//
//     $app->db->connect();
//     $sql = "SELECT * FROM movie WHERE id = ?;";
//     $movie = $app->db->executeFetchAll($sql, [$movieId]);
//     $movie = $movie[0];
//
//     $app->page->add("movie/header");
//     $app->page->add("movie/movie-edit", [
//         "movie" => $movie
//     ]);
//
//     return $app->page->render([
//         "title" => $title,
//     ]);
// });
//
// /**
//  * Edit movie GET
//  */
//
// $app->router->get("movie/movie-edit", function () use ($app) {
//     $title = "Edit a movie | oophp";
//
//     $movieId = getGet("movieId");
//     $app->db->connect();
//
//     $sql = "SELECT * FROM movie WHERE id = ?;";
//     $movie = $app->db->executeFetchAll($sql, [$movieId]);
//     $movie = $movie[0];
//
//     $app->page->add("movie/header");
//     $app->page->add("movie/movie-edit", [
//         "movie" => $movie
//     ]);
//
//     return $app->page->render([
//         "title" => $title,
//         "movieId" => $movieId
//     ]);
// });
//
// /**
//  * Save edits
//  */
//
// $app->router->post("movie/save", function () use ($app) {
//     $movieId    = getPost("movieId");
//     $movieTitle = getPost("movieTitle");
//     $movieYear  = getPost("movieYear");
//     $movieImage = getPost("movieImage");
//
//     $app->db->connect();
//     $sql = "UPDATE movie SET title = ?, year = ?, image = ? WHERE id = ?;";
//     $app->db->execute($sql, [$movieTitle, $movieYear, $movieImage, $movieId]);
//
//     return $app->response->redirect("movie/movie-edit?movieId=$movieId");
// });
