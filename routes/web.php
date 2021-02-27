<?php

//general settings
Auth::routes(['verify' => true]);

Route::get('send', 'DashboardController@sendNotification');
Route::get('admin', 'DashboardController@index')->name('admin_home');
Route::get('change_password', 'DashboardController@change_password');
Route::post('update_password', 'DashboardController@update_password');

//start general settings
Route::resource('admin/settings/preferences', 'PreferenceController');
Route::resource('admin/settings/preference_categories', 'PreferenceCategoryController');
Route::get('admin/settings', 'SettingsController@index')->name('settings');
Route::post('admin/settings/update', 'SettingsController@Update')->name('update_settings');
Route::resource('admin/users', 'UserController');
Route::get('user_photos/{name}', 'UserController@photo')->name('user_photo');
Route::get('list_users/{id}', 'UserController@list_users')->name('list_users');
Route::resource('admin/roles', 'RoleController');
//End general settings


//master
Route::resource('admin/settings/master_aravind_centres', 'MasterCentreController');
Route::resource('admin/settings/master_id_proof', 'MasterIdProofController');
Route::resource('admin/settings/master_payments', 'MasterPaymentController');
Route::resource('admin/settings/master_room_tariff', 'MasterRoomTariffController');
Route::resource('admin/settings/master_room_types', 'MasterRoomTypeController');
Route::resource('admin/settings/master_training', 'MasterTrainingController');
Route::resource('admin/settings/master_settings', 'MasterSettingsController');
Route::resource('admin/settings/master_room_details', 'MasterRoomDetailsController');
//end of master


//reports
Route::get('admin/dependonroom/{type}', 'ReportController@dependonroomstatus')->name('dependonroom');

Route::get('admin/reports/categorywiserooms', 'ReportController@categorywiserooms')->name('categorywiserooms');
Route::get('admin/reports/guestdetails', 'ReportController@guestdetails')->name('guestdetails');
Route::get('admin/reports/alltransactions', 'ReportController@alltransactions')->name('alltransactions');
Route::get('admin/reports/monthwisesummary', 'ReportController@monthwisesummary')->name('monthwisesummary');
Route::get('admin/reports/monthwiseguest', 'ReportController@monthwiseguest')->name('monthwiseguest');


//end of reports
Route::resource('admin/reservation_control', 'ReservationController');
Route::get('admin/reservation_availability_check/{id}', 'ReservationController@availability_check')->name('room_availability');
Route::post('admin/reservation_availability_check/{id}', 'ReservationController@availability_check_submit');
Route::resource('{id}/bookings', 'BookingController');
Route::resource('{id}/transaction_details', 'ReservationTransactionController');
Route::resource('enquiries', 'EnquiryController');

Route::get('admin/checkin/{id}', 'CheckInController@index')->name('today_checkin_checkout');


//ajax login
Route::get('ajax_login/{id}', 'FrontController@ajax_login_register')->name('ajax_login_register');
Route::post('ajax_login/{id}', 'FrontController@ajax_submit')->name('ajax_submit');
Route::get('resend_otp', 'FrontController@resend_otp')->name('resend_otp');
//end ajax login


Route::get('/', 'FrontController@index')->name('home');
Route::get('myprofile', 'ProfileController@index')->name('show_profile');
Route::post('myprofile', 'ProfileController@update')->name('update_profile');
Route::get('reservation', 'FrontController@reservation')->name('reservation')->middleware('auth');
Route::post('reservation', 'FrontController@submit_reservation')->name('submit_reservation')->middleware('auth');
Route::post('getRents', 'FrontController@getRents')->name('getRents')->middleware('auth');
Route::post('getBeneficiary', 'FrontController@getBeneficiary')->name('getBeneficiary')->middleware('auth');
Route::get('myreservations', 'FrontController@myreservations')->name('myreservations')->middleware('auth');
Route::get('mybookings', 'FrontController@mybookings')->name('mybookings')->middleware('auth');
Route::get('view_receipt/{id}', 'FrontController@view_receipt')->name('view_receipt')->middleware('auth');
Route::get('view_invoice/{id}/{key}', 'FrontController@view_invoice')->name('view_invoice');
Route::get('paynow/{id}', 'FrontController@paynow')->name('paynow')->middleware('auth');
Route::get('partialamount/{id}', 'FrontController@partialamount')->name('partialamount')->middleware('auth');


Route::post('iob/response', 'FrontController@payresponse')->name('payresponse')->middleware('auth');





Route::get('get_states/{id}', 'FrontController@getStates')->name('getStates');
Route::get('get_cities/{id}', 'FrontController@getCities')->name('getCities');
Route::post('contact_submit', 'FrontController@contact_submit')->name('contact_submit');


//Route::get('get_user_data', 'FrontController@get_user_data')->name('get_user_data')->middleware('auth');
Route::get('{page}', 'FrontController@show_page')->name('pages');

