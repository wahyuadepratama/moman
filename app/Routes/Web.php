<?php

Route::web('/', 'DatabaseController', 'index');
Route::web('coba@get', 'DatabaseController', 'cobaGet');
Route::api('coba@get', 'DatabaseController', 'index');
