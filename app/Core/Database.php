<?php

error_reporting(E_ALL); // ubah jadi 0 utk off
ini_set('display_errors', 1); // ubah jadi 0 utk off
date_default_timezone_set("Asia/Jakarta");

$GLOBALS['url']   = $_SERVER['HTTP_HOST'];

$database = "moman";
$username = "postgres";
$password = "root";

$GLOBALS['pdo'] = new PDO("pgsql:host=127.0.0.1;dbname=". $database .";port=5432", $username, $password);
