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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['prefix' => 'admin','namespace' => 'Admin','middleware' => ['adminVerify']],function ($router)
{
    $router->get('login', 'LoginController@login');
    $router->post('login', 'LoginController@store')->name('admin_login');
    $router->get('logout', 'LoginController@logout')->name('admin_logout');
    $router->get('login-success', 'LoginController@success')->name('admin_success');

    $router->get('companies/export','CompanyController@export')->name('companies.export');
    $router->resource('companies','CompanyController');

    $router->get('employees/export','EmployeeController@export')->name('employees.export');
    $router->resource('employees','EmployeeController');


    $router->get('pdftest','EmployeeController@pdftest')->name('pdftest');
    $router->post('uploadtest','EmployeeController@uploadtest')->name('uploadtest');

    /* do the upload*/
    $router->post('uploader', 'UploadController@upload')->name('uploader');
    $router->get('upload_page', 'UploadController@show')->name('upload_page');

});