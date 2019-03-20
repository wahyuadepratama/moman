<?php

/**
 *  Route:web('url','controller_name','method_name');
 */

// ____________ Guest
Route::web('/', 'UserController', 'index');
Route::web('maps', 'MapsController', 'maps');

Route::web('login', 'UserController', 'login');

Route::web('donation', 'DonationController', 'donation');
Route::web('donation@confirmation', 'DonationController', 'donationConfirmation');

Route::web('qurban', 'QurbanController', 'qurban');
Route::web('qurban@confirmation', 'QurbanController', 'qurbanConfirmation');

// ____________ Jamaah
Route::web('jamaah-dashboard', 'UserController', 'dashboardJamaah');
Route::web('jamaah-dashboard@update', 'UserController', 'updateDashboardJamaah');

Route::web('jamaah-event', 'WorshipPlaceController', 'eventJamaah');
Route::web('jamaah-report', 'WorshipPlaceController', 'reportJamaah');

//  ____________ Caretaker
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
Route::web('admin-dashboard', 'UserController', 'dashboardAdmin');

Route::web('admin-management-mosque-new', 'WorshipPlaceController', 'mosqueNewAdmin');
Route::web('admin-management-mosque-list', 'WorshipPlaceController', 'mosqueListAdmin');

Route::web('admin-management-caretaker-new', 'UserController', 'caretakerNewAdmin');
Route::web('admin-management-caretaker-list', 'UserController', 'caretakerListAdmin');

Route::web('admin-management-transaction-donation', 'DonationController', 'transactionDonationAdmin');
Route::web('admin-management-transaction-qurban', 'QurbanController', 'transactionQurbanAdmin');

Route::web('admin-management-jamaah', 'UserController', 'jamaahAdmin');
Route::web('admin-event', 'EventController', 'eventAdmin');
Route::web('admin-facility', 'FacilityController', 'facilityAdmin');
Route::web('admin-report', 'WorshipPlaceController', 'reportAdmin');
