<?php

/**
 *  Use function like this to make a route: Route:web('url','controller_name','method_name');
 */

// ____________ Guest
Route::web('/', 'UserController', 'index');
Route::web('maps', 'MapsController', 'maps');

Route::web('login', 'UserController', 'login');

Route::web('donation', 'DonationController', 'donation');
Route::web('donation/detail', 'DonationController', 'donationDetail');
Route::web('donation/confirmation', 'DonationController', 'donationConfirmation');

Route::web('donation/orphans', 'DonationController', 'donationOrphan');
Route::web('donation/orphans/detail', 'DonationController', 'donationOrphanDetail');

Route::web('donation/poor-people', 'DonationController', 'donationPoorPeople');
Route::web('donation/poor-people/detail', 'DonationController', 'donationPoorPeopleDetail');

Route::web('admin', 'UserController', 'loginAdmin');
Route::web('admin/login', 'UserController', 'checkLoginAdmin');
Route::web('admin/logout', 'UserController', 'checkLogoutAdmin');

//---------------------------------------------------------------

Route::web('qurban', 'QurbanController', 'qurban');
Route::web('qurban@confirmation', 'QurbanController', 'qurbanConfirmation');

// ____________ Jamaah
Route::web('jamaah-dashboard', 'UserController', 'dashboardJamaah');
Route::web('jamaah-dashboard@update', 'UserController', 'updateDashboardJamaah');

Route::web('jamaah-event', 'EventController', 'eventJamaah');
Route::web('jamaah-report', 'WorshipPlaceController', 'reportJamaah');

//  ____________ Stewardship
Route::web('caretaker-dashboard', 'UserController', 'dashboardCaretaker');
Route::web('caretaker-dashboard@update', 'UserController', 'updateDashboardCaretaker');
Route::web('caretaker-dashboard-account@update', 'UserController', 'updateAccountDashboardCaretaker');

Route::web('caretaker-event', 'EventController', 'eventCaretaker');
Route::web('caretaker-report', 'WorshipPlaceController', 'reportCaretaker');

Route::web('caretaker-management-donation-collection', 'DonationController', 'donationDanaCaretaker');
Route::web('caretaker-management-donation-transaction', 'DonationController', 'donationTransactionCaretaker');
Route::web('caretaker-management-donation-type', 'DonationController', 'donationTypeCaretaker');

Route::web('caretaker-management-qurban-collection', 'QurbanController', 'qurbanDanaCaretaker');
Route::web('caretaker-management-qurban-transaction', 'QurbanController', 'qurbanTransactionCaretaker');
Route::web('caretaker-management-qurban-type', 'QurbanController', 'qurbanTypeCaretaker');

Route::web('caretaker-management-event-schedule', 'EventController', 'eventScheduleCaretaker');
Route::web('caretaker-management-event-financial', 'EventController', 'eventFinancialCaretaker');

Route::web('caretaker-management-facility', 'FacilityController', 'facilityCaretaker');

// ____________ Admin
Route::web('admin/dashboard', 'UserController', 'dashboardAdmin');
Route::web('admin/mosque', 'WorshipPlaceController', 'listMosque');
Route::web('admin/mosque/add', 'WorshipPlaceController', 'addMosque');

// ____________ API
Route::web('api/tes', 'ApiWorshipPlace', 'tes');
