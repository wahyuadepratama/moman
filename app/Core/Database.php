<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$GLOBALS['url']   = $_SERVER['HTTP_HOST'];

$GLOBALS['pdo'] = new PDO("pgsql:host=127.0.0.1;dbname=moman;port=5432", "postgres", "root");
