<?php

error_reporting(E_ALL); // ubah jadi 0 utk off
ini_set('display_errors', 1); // ubah jadi 0 utk off

$GLOBALS['url']   = $_SERVER['HTTP_HOST'];

$GLOBALS['pdo'] = new PDO("pgsql:host=127.0.0.1;dbname=moman;port=5432", "postgres", "root");
