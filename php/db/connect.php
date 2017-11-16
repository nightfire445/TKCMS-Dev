<?php
$url = getenv('JAWSDB_MARIA_URL');
$dbparts = parse_url($url);
$connection_result;
$hostname = $dbparts['host'];
$username = $dbparts['user'];
$password = $dbparts['pass'];
$database = ltrim($dbparts['path'],'/');
$error;

try {
    $dbconn = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    // set the PDO error mode to exception
    $dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connection_result = TRUE;
    }
catch(PDOException $e)
    {
     $connection_result = FALSE;
        $error = $e->getMessage();
    }
?>