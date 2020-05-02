<?php
// Restore the database to its original settings
// $file   = "../view/movie/sql/setup.sql";
// $mysql = "C:/xampp/mysql/bin/mysql.exe";
// $output = null;
//
// // Extract hostname and databasename from dsn
// // $dsnDetail = [];
// // preg_match("/mysql:host=(.+);dbname=([^;.]+)/", $databaseConfig["dsn"], $dsnDetail);
// // $host = $dsnDetail[1];
// // $database = $dsnDetail[2];
// // $login = $databaseConfig["login"];
// // $password = $databaseConfig["password"];
//
// $dsnDetail = [];
// preg_match("/mysql:host=(.+);dbname=([^;.]+)/", $dbConfig["config"]["dsn"], $dsnDetail);
// $host = $dsnDetail[1];
// $database = $dsnDetail[2];
// if ($database == "jaka19") {
//     $mysql = "mysql";
// }
// $login = $dbConfig["config"]["username"];
// $password = $dbConfig["config"]["password"];
//
// if (isset($_POST["reset"]) || isset($_GET["reset"])) {
//     $command = "$mysql -h{$host} -u{$login} -p{$password} $database < $file 2>&1";
//     $commandclean = "$mysql -h{$host} -u{$login} -pxxxxxx $database < $file 2>&1";
//     $output = [];
//     $status = null;
//     $res = exec($command, $output, $status);
//     $output = "<p>The command was: <code>$commandclean</code>.<br>The command exit status was $status."
//         . "<br>The output from the command was:</p><pre>"
//         . print_r($output, 1);
// }

?>
<form method="get">
    <input type="submit" name="reset" value="Reset database">
    <?= $output ?>
</form>
