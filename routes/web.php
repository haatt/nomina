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

Route::get('/', function () {
    //return view('welcome');
    return view('.auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/employes/get', 'employeController@getEmployees');

Route::get('/employes/get/code', 'employeController@veriFyCode');
Route::get('/employes/get/email', 'employeController@veriFyEmail');

Route::post('/employes/storage', 'employeController@storage');

Route::put('/employes/update', 'employeController@updateEmployee');

Route::put('/employes/activate', 'employeController@activate');
Route::put('/employes/deactivate', 'employeController@deactivate');
