<?php

namespace Anax\View;

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= $title . $titleExtended ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<navbar class="navbar">
    <a href=<?= url("movie/select") ?>>SELECT *</a> |
    <a href=<?= url("movie/index") ?>>Show all movies</a> |
    <a href=<?= url("movie/reset") ?>>Reset database</a> |
    <a href=<?= url("movie/search-title") ?>>Search title</a> |
    <a href=<?= url("movie/search-year") ?>>Search year</a> |
    <a href=<?= url("movie/movie-select") ?>>Select</a> |
</navbar>

<h1>My Movie Database</h1>

<main>
