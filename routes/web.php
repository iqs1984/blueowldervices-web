<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\User;
Auth::routes();

Route::group(['middleware' => 'auth', 'admin'], function () {
Route::get('/vendors-details', function () {
    return view('vendors-details');
});
Route::get('/transactions', function () {
    return view('transactions');
});
Route::get('/settings', function () {
    return view('settings');
});

//Route::post('/change_password', function () {
//    return view('settings');
//});

Route::get('vendors', 'VendorController@vendors');
Route::post('change_password', 'UserController@change_password')->name('change_password');
Route::get('vendors-details/{id}', 'VendorController@vendordetail');
});

Route::post('/login_admin', function () {
    $email = request()->email;
    $password = request()->password;

    if (Auth::attempt(['email' => $email, 'password' => $password, 'role' => 'admin'])) {
        //return back()->withError('Logged in successfully.');
        return redirect('/vendors');
    } else {
        return back()->withError('Login credential are invalid. Please try another credential.');
    }
})->name('login_admin');



Route::get('/login', function () {
    //return view('login');
	return Redirect('/login');
})->name('login');

Route::get('/logout', function () {
    Auth::logout();
    return Redirect('/login');
});
