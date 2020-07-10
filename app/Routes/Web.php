<?php

/**
 *  Use function like this to make a route => Route::web('url','controller_name','method_name');
 */

// __________________________________________ Auth __________________________________________
Route::web('login', 'UserController', 'formLogin');
Route::web('login/store', 'UserController', 'login');
Route::web('logout', 'UserController', 'logout');

Route::web('register', 'UserController', 'formRegister');
Route::web('register/store', 'UserController', 'register');

Route::web('admin', 'UserController', 'loginAdmin');
Route::web('admin/login', 'UserController', 'checkLoginAdmin');

// __________________________________________ MAPS __________________________________________

Route::web('maps', 'MapsController', 'maps');
Route::web('maps/kecamatan', 'MapsController', 'showKecamatan');
Route::web('maps/village', 'MapsController', 'showDataVillage');

Route::web('maps/mosque', 'MapsController', 'showMosque');
Route::web('maps/mosque/marker', 'MapsController', 'indexMosqueMarker');
Route::web('maps/mosque/radius', 'MapsController', 'radius');

Route::web('maps/gallery', 'MapsController', 'gallery');

Route::web('maps/filter', 'MapsController', 'filter');
Route::web('maps/filter/facility', 'MapsController', 'filterFacility');
Route::web('maps/filter/event', 'MapsController', 'filterEvent');

// __________________________________________ Guest __________________________________________
Route::web('/', 'UserController', 'index');

Route::web('qurban', 'QurbanController', 'index');
Route::web('qurban/detail', 'QurbanController', 'show');

// __________________________________________ Jamaah __________________________________________
Route::web('jamaah/dashboard', 'UserController', 'dashboardJamaah');
Route::web('jamaah/dashboard/mosque/new', 'UserController', 'addNewMosque');

Route::web('jamaah/avatar/store', 'UserController', 'storeAvatarJamaah');
Route::web('jamaah/password/update', 'UserController', 'updatePasswordJamaah');
Route::web('jamaah/profile/update', 'UserController', 'updateProfileJamaah');

Route::web('qurban/store', 'QurbanController', 'store');

Route::web('jamaah/qurban', 'UserController', 'historyQurban');
Route::web('jamaah/qurban/checking', 'QurbanController', 'checkQurban');

Route::web('jamaah/about', 'WorshipPlaceController', 'about');

//  __________________________________________ Stewardship __________________________________________
Route::web('stewardship/dashboard', 'UserController', 'dashboardStewardship');
Route::web('stewardship/account/update', 'UserController', 'updateAccountStewardship');
Route::web('stewardship/account/store', 'UserController', 'storeAccountBank');
Route::web('stewardship/account/destroy', 'UserController', 'destroyAccountBank');
Route::web('stewardship/dashboard/changeMosque', 'UserController', 'changeMosque');

Route::web('stewardship/qurban', 'QurbanController', 'animalStewardship');
Route::web('stewardship/qurban/store', 'QurbanController', 'storeAnimalStewardship');
Route::web('stewardship/qurban/destroy', 'QurbanController', 'destroyAnimalStewardship');

Route::web('stewardship/qur/detail', 'QurbanController', 'transactionStewardship');
Route::web('stewardship/qur/confirm', 'QurbanController', 'confirmTransactionStewardship');

Route::web('stewardship/qurb/group', 'QurbanController', 'indexGroupAnimalStewardship');
Route::web('stewardship/qurb/group/change', 'QurbanController', 'changeGroupAnimalStewardship');
Route::web('stewardship/qurb/animal/change', 'QurbanController', 'changeAnimalStewardship');

Route::web('stewardship/mosque/event', 'EventController', 'index');
Route::web('stewardship/mosque/event/store', 'EventController', 'store');
Route::web('stewardship/mosque/event/update', 'EventController', 'update');
Route::web('stewardship/mosque/event/delete', 'EventController', 'delete');

Route::web('stewardship/mosque/schedule', 'EventController', 'indexSchedule');
Route::web('stewardship/mosque/schedule/store', 'EventController', 'storeSchedule');
Route::web('stewardship/mosque/schedule/destroy', 'EventController', 'destroySchedule');

Route::web('stewardship/mosque/jamaah', 'UserController', 'jamaahStewardship');

Route::web('stewardship/mosque/facility', 'FacilityController', 'facilityStewardship');
Route::web('stewardship/mosque/facility/store', 'FacilityController', 'storeFacilityStewardship');
Route::web('stewardship/mosque/facility/update', 'FacilityController', 'updateFacilityStewardship');
Route::web('stewardship/mosque/facility/destroy', 'FacilityController', 'destroyFacilityStewardship');

Route::web('stewardship/recipient/ustad', 'RecipientController', 'indexUstad');
Route::web('stewardship/recipient/ustad/store', 'RecipientController', 'storeUstad');
Route::web('stewardship/recipient/ustad/update', 'RecipientController', 'updateUstad');

Route::web('stewardship/report', 'QurbanController', 'report');

// __________________________________________ Admin __________________________________________
Route::web('admin/dashboard', 'UserController', 'dashboardAdmin');

Route::web('admin/mosque', 'WorshipPlaceController', 'listMosque');
Route::web('admin/mosque/add', 'WorshipPlaceController', 'addMosque');
Route::web('admin/mosque/store', 'WorshipPlaceController', 'storeMosque');
Route::web('admin/mosque/destroy', 'WorshipPlaceController', 'destroyMosque');
Route::web('admin/mosque/gallery', 'WorshipPlaceController', 'galleryMosque');
Route::web('admin/mosque/gallery/store', 'WorshipPlaceController', 'storeGalleryMosque');
Route::web('admin/mosque/gallery/destroy', 'WorshipPlaceController', 'destroyGalleryMosque');

Route::web('admin/facility-type', 'FacilityController', 'indexFacility');
Route::web('admin/facility-type/store', 'FacilityController', 'storeFacility');
Route::web('admin/facility-type/destroy', 'FacilityController', 'destroyFacility');

Route::web('admin/stewardship', 'UserController', 'indexStewardship');

Route::web('admin/jamaah', 'UserController', 'indexJamaah');
Route::web('admin/jamaah/store', 'UserController', 'storeStewardship');

// __________________________________________ API __________________________________________
Route::web('api/login', 'ApiUserController', 'login');
Route::web('api/_users', 'ApiUserController', 'getDataLogin');

Route::web('api/facility', 'ApiFacilityController', 'index');

Route::web('api/qurban', 'ApiQurbanController', 'index');
Route::web('api/qurban/detail', 'ApiQurbanController', 'show');
Route::web('api/qurban/store', 'ApiQurbanController', 'store');
Route::web('api/qurban/history', 'ApiQurbanController', 'history');
Route::web('api/qurban/invoice', 'ApiQurbanController', 'invoice');

Route::web('api/qurban/transaction', 'ApiQurbanController', 'transaction');
Route::web('api/qurban/confirmation', 'ApiQurbanController', 'confirm');

Route::web('api/getfacility', 'ApiMapsController', 'data');
Route::web('api/maps', 'ApiMapsController', 'index');
