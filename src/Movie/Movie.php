<?php

namespace Janni\Movie;

/**
* Movie database
*/
class Movie
{
    /**
    * Resets database to original
    */
    public function resetDatabase($dbConfig)
    {
        $file   = "../view/movie/sql/setup.sql";
        $mysql = "C:/xampp/mysql/bin/mysql.exe";

        $dsnDetail = [];
        preg_match("/mysql:host=(.+);dbname=([^;.]+)/", $dbConfig["config"]["dsn"], $dsnDetail);
        $host = $dsnDetail[1];
        $database = $dsnDetail[2];
        if ($database == "jaka19") {
            $mysql = "mysql";
        }
        $login = $dbConfig["config"]["username"];
        $password = $dbConfig["config"]["password"];

        $command = "$mysql -h{$host} -u{$login} -p{$password} $database < $file 2>&1";
        $commandclean = "$mysql -h{$host} -u{$login} -pxxxxxx $database < $file 2>&1";
        $output = [];
        $status = null;
        exec($command, $output, $status);
        $output = "<p>The command was: <code>$commandclean</code>.<br>The command exit status was $status."
            . "<br>The output from the command was:</p><pre>"
            . print_r($output, 1);

        return $output;
    }

    /**
    * Checks which years to search between
    */

    public function searchYear($db, $year1, $year2)
    {
        $resultset = null;

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
        return $resultset;
    }

    /**
    * Get max number of pages
    */

    public function getMax($db, $hits)
    {
        $sql = "SELECT COUNT(id) AS max FROM movie;";
        $max = $db->executeFetchAll($sql);
        $max = ceil($max[0]->max / $hits);

        return $max;
    }
}
