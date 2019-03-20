<?php

spl_autoload_register(function($class){
  require_once 'Core/'.$class.'.php';
});

require_once 'Core/Database.php';

require_once 'Middleware/Auth.php';

require_once 'Routes/Web.php';
require_once 'Routes/Api.php';

Route::web('lastpage','lastpage','lastpage');
Route::api('api/lastpage','lastpage','lastpage');
