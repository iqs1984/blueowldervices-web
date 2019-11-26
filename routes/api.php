<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//
//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['namespace'=>'Api'],function () {
    Route::post('login', 'UserController@login');
    Route::post('logout', 'UserController@logout');
    Route::post('register', 'UserController@register');
    Route::post('passwordUpdate', 'UserController@passwordUpdate');
    Route::post('getdetail', 'UserController@getdetail');
    Route::post('AddEmployee', 'UserController@AddEmployee');
    Route::post('profileImage', 'UserController@profileImage');
    Route::post('editemployee', 'UserController@editemployee');
    Route::post('employeelist', 'UserController@employeelist');
    Route::post('deleteemployee', 'UserController@deleteemployee');
    Route::post('addarea', 'AreaController@addarea');
    Route::post('allarea', 'AreaController@allarea');
    Route::post('editarea', 'AreaController@editarea');
    Route::post('deletearea', 'AreaController@deletearea');
    Route::post('area_module', 'AreaController@area_module');
    Route::post('subscription', 'UserController@register');
    Route::post('getlocationdetail', 'UserController@getlocationdetail');

    Route::post('cancelsubscription', 'SubscriptionController@cancelsubscription');
    Route::post('servicecategory', 'ServiceController@servicecategory');
    Route::post('serviceoffered', 'ServiceController@serviceoffered');
    Route::post('getservicequestion', 'ServiceController@getservicequestion');
    Route::post('getserviceallquestion', 'ServiceController@getserviceallquestion');
    Route::post('updateservicedetail', 'ServiceController@updateservicedetail');
    Route::post('resubscribe', 'SubscriptionController@resubscribe');
    Route::post('getdetail', 'UserController@getdetail');
    Route::post('gettoken', 'UserController@gettoken');
    Route::post('getinvoice', 'UserController@getinvoice');
	Route::post('customerrequest', 'CustomerController@customerrequest');
	Route::post('enquirylist', 'CustomerController@enquirylist');
	Route::post('markcomplete', 'CustomerController@markcomplete');

    Route::post('gettransaction', 'UserController@gettransaction');


});
