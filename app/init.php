<?php

spl_autoload_register(function($class){
  require_once 'Core/'.$class.'.php';
});

require_once 'Core/Database.php';

require_once 'Helpers/Helper.php';

require_once 'Routes/Web.php';

Route::web('lastpage','lastpage','lastpage');
