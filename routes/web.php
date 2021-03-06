<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

/* Route::get('/', function () {
#    return view('welcome');
#});

Auth::routes();

Route::get('/home', 'HomeController@index');
*/

/*Route::group(['middleware'=>['auth']],function(){
Route::get('/',function(){
	return view ('welcome');
});
Auth::routes();
/*Route::auth();*/
/*Route::get('/home', 'HomeController@index');
Route::get('/operator','OperatorController@index');
});
*/

Route::post('landing/test', 'LandingPage@test');

Route::post('landing/index_single', 'LandingPage@index_single');
Route::get('landing/index_single', 'LandingPage@indexget_single');
Route::post('landing/login_single', 'LandingPage@login_single');
Route::get('landing/login_single', 'LandingPage@loginget_single');
Route::post('landing/logout_single', 'LandingPage@logout_single');
Route::get('landing/logout_single', 'LandingPage@logoutget_single');
Route::post('landing/alogin_single', 'LandingPage@alogin_single');
Route::get('landing/alogin_single', 'LandingPage@aloginget_single');
Route::post('landing/status_single', 'LandingPage@status_single');


Route::post('landing/index_mice', 'LandingPage@index_mice');
Route::get('landing/index_mice', 'LandingPage@indexget_mice');
Route::get('landing/login_mice', 'LandingPage@loginget_mice');
Route::get('landing/alogin_mice', 'LandingPage@aloginget_mice');
Route::get('landing/logout_mice', 'LandingPage@logoutget_mice');
Route::get('landing/status_mice', 'LandingPage@statusget_mice');
Route::post('landing/login_mice', 'LandingPage@login_mice');
Route::post('landing/alogin_mice', 'LandingPage@alogin_mice');
Route::post('landing/status_mice', 'LandingPage@status_mice');
Route::post('landing/logout_mice', 'LandingPage@logout_mice');


Route::post('landing/index', 'LandingPage@index');
Route::get('landing/index', 'LandingPage@indexget');
Route::post('landing/alogin', 'LandingPage@alogin');
Route::get('landing/alogin', 'LandingPage@aloginget');
Route::post('landing/logout', 'LandingPage@logout');
Route::get('landing/logout', 'LandingPage@logoutget');
Route::post('landing/login', 'LandingPage@login');
Route::get('landing/login', 'LandingPage@loginget');
Route::post('landing/status', 'LandingPage@status');


Route::post('landing/resetpass', 'LandingPage@resetpass');
Route::get('landing/resetpassword/{username}/{password}', 'LandingPage@resetpassword');


Route::Auth();
Route::group(['middleware' => ['auth']], function () {
    Route::get('/operator', ['as' => 'operator', 'uses' => 'GuestInHouseController@index']);
    Route::get('/guestinhouse', 'GuestInHouseController@index');
    Route::get('/', 'GuestInHouseController@dashboard');
    Route::get('guestinhouse/macauth', ['as' => 'guestinhouse.macauth', 'uses' => 'GuestInHouseController@macauth']);
    Route::get('/guestinhouse/online', 'GuestInHouseController@online');
    Route::get('/guestinhouse/addroom', 'GuestInHouseController@addroom');
    Route::get('/guestinhouse/room', 'GuestInHouseController@roomlist');
    Route::get('/guestinhouse/dashboard', 'GuestInHouseController@dashboard');
    Route::get('/guestinhouse/{username}/roomedit', 'GuestInHouseController@roomedit');
    Route::post('/guestinhouse/roomeditstore', 'GuestInHouseController@roomeditstore');
    Route::get('/guestinhouse/{username}/roomdelete', 'GuestInHouseController@roomdelete');
    Route::get('/voucher/searchvoucher', 'VoucherController@searchvoucher');
    Route::get('/voucher/expiredvoucher', 'VoucherController@expiredvoucher');
    Route::get('/voucher/{id}/exdeleteuser', 'VoucherController@exdeleteuser');
    Route::get('/voucher/{name}/expired/delete/', 'VoucherController@exdeletevoucher');
    Route::get('/voucher/{name}/expired', 'VoucherController@expireduser');
    Route::get('/voucher/voucherlist', ['as' => 'voucherlist', 'uses' => 'VoucherController@voucherlist']);
    Route::get('/voucher/voucherhistory', ['as' => 'voucherhistory', 'uses' => 'VoucherController@voucherhistory']);
    Route::get('/voucher/addvoucher', 'VoucherController@addvoucher');
    Route::resource('voucher', 'VoucherController');
    Route::resource('guestinhouse', 'GuestInHouseController', ['except' => ['show']]);
    Route::get('/guestinhouse/{guestinhouse}/checkin', 'GuestInHouseController@checkin');
    Route::get('/voucher/{name}/listuser', 'VoucherController@listuser');
    Route::get('/voucher/{name}/listuserexp', 'VoucherController@listuserexp');
    Route::get('/guestinhouse/{user}/{ip}/checkout', 'GuestInHouseController@checkout');
    Route::get('/guestinhouse/{id}/details', 'GuestInHouseController@details');
    Route::get('/guestinhouse/{guestinhouse}/enable', 'GuestInHouseController@enable');
    Route::get('/guestinhouse/{guestinhouse}/disable', 'GuestInHouseController@disable');
    Route::get('/guestinhouse/{mac}/{ip}/deletemac', 'GuestInHouseController@deletemac');
    Route::get('/guestinhouse/{user}/resetpassword', 'GuestInHouseController@resetpass');
    Route::get('/guestinhouse/{user}/extend', 'GuestInHouseController@extend');
    Route::get('/guestinhouse/{user}/{ip}/disconnect', 'GuestInHouseController@disconnect');
    Route::get('/guestinhouse/{user}/{ip}/disconnect_mac', 'GuestInHouseController@disconnectmac');
    Route::put('/guestinhouse/{guestinhouse}/checkinpost', ['as' => 'guestinhouse.checkin', 'uses' => 'GuestInHouseController@checkinStore']);
    Route::post('/guestinhouse/gcheckinstore', ['as' => 'guestinhouse.gcheckinstore', 'uses' => 'GuestInHouseController@gcheckinstore']);
    Route::post('/voucher/voucherstore', ['as' => 'voucher.voucherstore', 'uses' => 'VoucherController@voucherstore']);
    Route::post('/guestinhouse/macauthstore', ['as' => 'guestinhouse.macauthstore', 'uses' => 'GuestInHouseController@macauthStore']);
    Route::post('/guestinhouse/roomstore', ['as' => 'guestinhouse.roomstore', 'uses' => 'GuestInHouseController@roomstore']);
    Route::post('/guestinhouse/extendstore', ['as' => 'guestinhouse.extendstore', 'uses' => 'GuestInHouseController@extendstore']);
    Route::post('/guestinhouse/groupcheck', 'GuestInHouseController@groupcheck');
    Route::post('/voucher/usercheck', 'VoucherController@usercheck');
    Route::post('/voucher/exusercheck', 'VoucherController@exusercheck');
    Route::post('/guestinhouse/passstore', ['as' => 'guestinhouse.passstore', 'uses' => 'GuestInHouseController@passstore']);

    Route::get('/voucher/{name}/deletevoucher', 'VoucherController@deletevoucher');
    Route::get('/voucher/{name}/disable', 'VoucherController@disable');
    Route::get('/voucher/{id}/deleteuser', 'VoucherController@deleteuser');
    Route::get('/voucher/{id}/activate', 'VoucherController@activate');
    Route::get('/voucher/{name}/activategroup', 'VoucherController@activategroup');
    Route::get('/voucher/{id}/assign', 'VoucherController@assign');
    Route::post('/voucher/assignstore', 'VoucherController@assignstore');
    Route::post('/voucher/searchpost', 'VoucherController@searchpost');
    Route::get('/voucher/{name}/print', 'PrintController@printvoucher');
    Route::get('/guestinhouse/{id}/print', 'GuestInHouseController@print');
    Route::get('/voucher/{id}/printguest', ['as' => 'view.print', 'uses' => 'PrintController@printvoucherguest']);
    Route::get('/voucher/{name}/details', 'VoucherController@details');
    Route::get('test', 'PrintController@test');
    Route::get('/user/manage', 'UserController@index');
    Route::get('/user/{id}/edit', 'UserController@showedit');
    Route::post('/user/{id}/edit', ['as' => 'user.edit', 'uses' => 'UserController@storeedit']);
    Route::get('/user/add', 'UserController@useradd');
    Route::post('user/add', ['as' => 'user.add', 'uses' => 'UserController@userstore']);
    Route::get('user/{id}/delete', 'UserController@destroy');
    Route::get('password/resetpass/{id}', 'UserController@restepass');
    Route::post('password/resetpass/{id}', 'UserController@restepassPost');
    Route::get('/mice', 'MiceController@index');
    Route::get('/mice/addform', 'MiceController@add');
    Route::post('/mice/addstore', 'MiceController@addstore');
    Route::get('mice/{id}/delete', 'MiceController@delete');
    Route::get('mice/{id}/approve', 'MiceController@approve');
    Route::get('mice/{id}/approvestore', ['middleware' => ['role:mice'], 'uses' => 'MiceController@approvestore', 'role' => 'mice']);
    Route::get('mice/{id}/activatepost', ['middleware' => ['role:mice'], 'uses' => 'MiceController@activatepost', 'role' => 'mice']);
    Route::get('logs', 'LogController@index');
    Route::post('logs/groupcheck', 'LogController@groupcheck');
    Route::get('logs/{id}/delete', 'LogController@delete');


});

Auth::routes();

Route::get('/home', 'GuestInHouseController@index');
