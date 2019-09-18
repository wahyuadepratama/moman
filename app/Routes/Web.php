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

Route::web('maps/mosque', 'MapsController', 'showMosque');
Route::web('maps/mosque/marker', 'MapsController', 'indexMosqueMarker');
Route::web('maps/mosque/radius', 'MapsController', 'radius');

Route::web('maps/gallery', 'MapsController', 'gallery');

Route::web('maps/filter', 'MapsController', 'filter');
Route::web('maps/filter/facility', 'MapsController', 'filterFacility');
Route::web('maps/filter/event', 'MapsController', 'filterEvent');

// __________________________________________ Guest __________________________________________
Route::web('/', 'UserController', 'index');

Route::web('donation', 'DonationController', 'donation');
Route::web('donation/detail', 'DonationController', 'donationDetail');

Route::web('donation/orphans', 'DonationController', 'orphans');
Route::web('donation/orphans/detail', 'DonationController', 'orphanDetail');

Route::web('donation/poor', 'DonationController', 'poor');
Route::web('donation/poor/detail', 'DonationController', 'poorDetail');

Route::web('donation/tpa', 'DonationController', 'tpa');
Route::web('donation/tpa/detail', 'DonationController', 'tpaDetail');

Route::web('qurban', 'QurbanController', 'index');
Route::web('qurban/detail', 'QurbanController', 'show');

// __________________________________________ Jamaah __________________________________________
Route::web('jamaah/dashboard', 'UserController', 'dashboardJamaah');

Route::web('jamaah/avatar/store', 'UserController', 'storeAvatarJamaah');
Route::web('jamaah/password/update', 'UserController', 'updatePasswordJamaah');
Route::web('jamaah/profile/update', 'UserController', 'updateProfileJamaah');

Route::web('donation/detail/store', 'DonationController', 'storeDonation');
Route::web('orphan/detail/store', 'DonationController', 'storeOrphan');
Route::web('poor/detail/store', 'DonationController', 'storePoor');
Route::web('tpa/detail/store', 'DonationController', 'storeTpa');

Route::web('qurban/store', 'QurbanController', 'store');

Route::web('jamaah/history', 'UserController', 'history');
Route::web('jamaah/checking', 'DonationController', 'checkDonation');

Route::web('jamaah/qurban', 'UserController', 'historyQurban');
Route::web('jamaah/qurban/checking', 'QurbanController', 'checkQurban');

Route::web('jamaah/about', 'WorshipPlaceController', 'about');

//  __________________________________________ Stewardship __________________________________________
Route::web('stewardship/dashboard', 'UserController', 'dashboardStewardship');
Route::web('stewardship/account/update', 'UserController', 'updateAccountStewardship');
Route::web('stewardship/account/store', 'UserController', 'storeAccountStewardship');
Route::web('stewardship/account/destroy', 'UserController', 'destroyAccountStewardship');

Route::web('stewardship/donation/project', 'DonationController', 'projectStewardship');
Route::web('stewardship/donation/project/store', 'DonationController', 'storeProjectStewardship');
Route::web('stewardship/donation/project/progress', 'DonationController', 'updateProjectStewardship');

Route::web('stewardship/donation/transaction', 'DonationController', 'transactionStewardship');
Route::web('stewardship/donation/transaction/confirm', 'DonationController', 'confirmTransactionStewardship');
Route::web('stewardship/donation/transaction/store', 'DonationController', 'storeAllInfaq');

Route::web('stewardship/donation/payment', 'FinancialController', 'indexPayment');
Route::web('stewardship/donation/payment/project/store', 'FinancialController', 'storeProject');
Route::web('stewardship/donation/payment/orphans/store', 'FinancialController', 'storeOrphans');
Route::web('stewardship/donation/payment/poor/store', 'FinancialController', 'storePoor');
Route::web('stewardship/donation/payment/tpa/store', 'FinancialController', 'storeTpa');
Route::web('stewardship/donation/payment/event/store', 'FinancialController', 'storeEvent');
Route::web('stewardship/donation/payment/cash/store', 'FinancialController', 'storeCashMosque');

Route::web('stewardship/qurban', 'QurbanController', 'animalStewardship');
Route::web('stewardship/qurban/store', 'QurbanController', 'storeAnimalStewardship');
Route::web('stewardship/qur/detail', 'QurbanController', 'transactionStewardship');
Route::web('stewardship/qur/confirm', 'QurbanController', 'confirmTransactionStewardship');
Route::web('stewardship/qurban/destroy', 'QurbanController', 'destroyAnimalStewardship');

Route::web('stewardship/mosque/event', 'EventController', 'index');
Route::web('stewardship/mosque/event/store', 'EventController', 'store');
Route::web('stewardship/mosque/event/update', 'EventController', 'update');

Route::web('stewardship/mosque/schedule', 'EventController', 'indexSchedule');
Route::web('stewardship/mosque/schedule/store', 'EventController', 'storeSchedule');
Route::web('stewardship/mosque/schedule/destroy', 'EventController', 'destroySchedule');

Route::web('stewardship/mosque/jamaah', 'UserController', 'jamaahStewardship');

Route::web('stewardship/mosque/facility', 'FacilityController', 'facilityStewardship');
Route::web('stewardship/mosque/facility/store', 'FacilityController', 'storeFacilityStewardship');
Route::web('stewardship/mosque/facility/update', 'FacilityController', 'updateFacilityStewardship');
Route::web('stewardship/mosque/facility/destroy', 'FacilityController', 'destroyFacilityStewardship');

Route::web('stewardship/recipient/poor', 'RecipientController', 'indexPoor');
Route::web('stewardship/recipient/poor/store', 'RecipientController', 'storePoor');
Route::web('stewardship/recipient/poor/update', 'RecipientController', 'updatePoor');

Route::web('stewardship/recipient/tpa', 'RecipientController', 'indexTpa');
Route::web('stewardship/recipient/tpa/store', 'RecipientController', 'storeTpa');
Route::web('stewardship/recipient/tpa/update', 'RecipientController', 'updateTpa');

Route::web('stewardship/recipient/orphanage', 'RecipientController', 'indexOrphanage');
Route::web('stewardship/recipient/orphanage/store', 'RecipientController', 'storeOrphanage');
Route::web('stewardship/recipient/orphanage/update', 'RecipientController', 'updateOrphanage');

Route::web('stewardship/recipient/store', 'RecipientController', 'indexStore');
Route::web('stewardship/recipient/store/store', 'RecipientController', 'storeStore');
Route::web('stewardship/recipient/store/update', 'RecipientController', 'updateStore');

Route::web('stewardship/recipient/builder', 'RecipientController', 'indexBuilder');
Route::web('stewardship/recipient/builder/store', 'RecipientController', 'storeBuilder');
Route::web('stewardship/recipient/builder/update', 'RecipientController', 'updateBuilder');

Route::web('stewardship/recipient/ustad', 'RecipientController', 'indexUstad');
Route::web('stewardship/recipient/ustad/store', 'RecipientController', 'storeUstad');
Route::web('stewardship/recipient/ustad/update', 'RecipientController', 'updateUstad');

Route::web('stewardship/report', 'FinancialController', 'report');

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
Route::web('admin/stewardship/store', 'UserController', 'storeStewardship');

// __________________________________________ API __________________________________________
Route::web('api/login', 'ApiUserController', 'login');
Route::web('api/_users', 'ApiUserController', 'getDataLogin');

Route::web('api/facility', 'ApiFacilityController', 'index');

Route::web('api/donation', 'ApiDonationController', 'index');
Route::web('api/donation/detail', 'ApiDonationController', 'show');
Route::web('api/donation/store', 'ApiDonationController', 'store');

Route::web('api/qurban', 'ApiQurbanController', 'index');

Route::web('api/maps', 'ApiMapsController', 'index');

Route::web('api/mosque', 'ApiDonationController', 'listMosque');
Route::web('api/mosque/detail', 'ApiDonationController', 'detailMosqueForDonation');
Route::web('api/mosque/orphan/store', 'ApiDonationController', 'storeOrphan');
Route::web('api/mosque/poor/store', 'ApiDonationController', 'storePoor');
Route::web('api/mosque/tpa/store', 'ApiDonationController', 'storeTpa');

Route::web('api/history', 'ApiDonationController', 'history');
Route::web('api/history/detail', 'ApiDonationController', 'historyDetail');
