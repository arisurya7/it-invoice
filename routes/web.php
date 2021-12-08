<?php

use Illuminate\Support\Facades\Route;

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

//Login
Route::get('/login', 'LoginController@index')->name('login')->middleware('guest');
Route::post('/login/authenticate', 'LoginController@authenticate')->name('login.authenticate');
Route::get('/forgotpassword','ForgotPasswordController@index')->name('forgotpassword');
Route::post('/forgotpassword/validatepassword','ForgotPasswordController@validatepassword')->name('forgotpassword.validatepassword');
Route::get('/resetpassword/{token}','ForgotPasswordController@resetpassword')->name('resetpassword');
Route::post('/resetpassword/{token}','ForgotPasswordController@updatepassword')->name('updatepassword');


Route::middleware(['auth', 'checkrole:Admin,Manager'])->group(function () {
    Route::get('/logout', 'LoginController@logout')->name('logout'); 
    Route::match(['get', 'post'],'/', 'DashboardController@index')->name('dashboard')->middleware('auth');
    //Dashboard
    Route::get('/showstatus', 'DashboardController@showStatus')->name('showstatus');
    //Customer
    Route::get('/customer', 'CustomerController@index')->name('customer');
    Route::get('/customer/show', 'CustomerController@show')->name('customer.show');
    //Project
    Route::get('/project', 'ProjectController@index')->name('project');
    Route::get('/project/show', 'ProjectController@show')->name('project.show');
    // Invoice  
    Route::match(['get', 'post'],'/invoice', 'InvoiceController@index')->name('invoice');
    Route::get('/invoice/status', 'InvoiceController@status')->name('invoice.status');
    Route::match(['get', 'post'], '/invoice/revisi/{id}', 'InvoiceController@revisi')->name('invoice.revisi');
    Route::get('/invoice/exportpdf/{id}', 'InvoiceController@exportpdf')->name('invoice.exportpdf');
    Route::get('/invoice/show', 'InvoiceController@show')->name('invoice.show');
    Route::get('/invoice/showRevisi', 'InvoiceController@showRevisi')->name('invoice.showrevisi');
    Route::get('/invoice/getDetailProject', 'InvoiceController@getDetailProject')->name('invoice.getdetailproject');
    //Report
    Route::match(['get', 'post'], '/report', 'ReportController@index')->name('report');
    Route::post('/report/printpdf', 'ReportController@printpdf')->name('report.printpdf');
});

Route::middleware(['checkrole:Admin'])->group(function () {
    //Customer
    Route::match(['get', 'post'], '/customer/add', 'CustomerController@add')->name('customer.add');
    Route::match(['get', 'post'], '/customer/edit/{id}', 'CustomerController@edit')->name('customer.edit');
    Route::post('/customer/delete', 'CustomerController@delete')->name('customer.delete');
    Route::get('/customer/getkota', 'CustomerController@getKota')->name('customer.getkota');
    Route::get('/customer/getkecamatan', 'CustomerController@getKecamatan')->name('customer.getkecamatan');
    Route::get('/customer/getkodepos', 'CustomerController@getKodepos')->name('customer.getkodepos');
    //Project
    Route::match(['get', 'post'], '/project/add', 'ProjectController@add')->name('project.add');
    Route::match(['get', 'post'], '/project/edit/{id}', 'ProjectController@edit')->name('project.edit');
    Route::post('/project/delete', 'ProjectController@delete')->name('project.delete');
    //Invoice
    Route::match(['get', 'post'], '/invoice/add', 'InvoiceController@add')->name('invoice.add');
    Route::match(['get', 'post'], '/invoice/edit/{id}', 'InvoiceController@edit')->name('invoice.edit');
    Route::post('/invoice/delete', 'InvoiceController@delete')->name('invoice.delete');
    //Users
    Route::match(['get', 'post'], '/users', 'UserController@index')->name('users');
    Route::match(['get', 'post'], '/users/add', 'UserController@add')->name('users.add');
    Route::post('/users/delte', 'UserController@delete')->name('users.delete');
    Route::get('/users/show', 'UserController@show')->name('users.show');
   
});

Route::middleware(['auth', 'profileOwner'])->group(function () {
    Route::match(['get', 'post'], '/users/edit/{id}', 'UserController@edit')->name('users.edit');
    Route::match(['get', 'post'],'/users/changepassword/{id}', 'UserController@changepassword')->name('users.changepassword');
});
