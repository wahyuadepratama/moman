<?php

spl_autoload_register(function($class){
  require_once 'Core/'.$class.'.php';
});

require_once 'Routes/Web.php';
require_once 'Routes/Api.php';

// $GLOBALS['dbport']      = '5432';
// $GLOBALS['dbname']      = 'phpmini';
// $GLOBALS['dbusername']  = 'postgres';
// $GLOBALS['dbpassword']  = 'postgre';
