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
    return redirect()->route('login');
});

/**
 * Se deshabilita la opción de registro
 */
Auth::routes(['register' => false]);

/**
 * Luego del login exitoso se muestra la modal de bienvenida
 */
Route::get('/success-login', function(){
    return view('auth.partials.success-login');
})->name('success-login');


/**
 * Ruta home para usuarios autorizados
 */
Route::get('/home', 'HomeController@index')->name('home');

/**
 * Rutas para gestionar los resource list
 */
Route::get('/resource-list/{page?}', 'ResourceListController@index');
Route::get('/resource-search/{page?}/{text?}', 'ResourceListController@search');

/**
 * Rutas para gestionar el tiempo restante por intentos fallidos de login
 */
Route::get('/get-timer', 'Auth\TimerLoginAttemtsController@get');
Route::get('/update-timer', 'Auth\TimerLoginAttemtsController@update');
Route::get('/reset-timer', 'Auth\TimerLoginAttemtsController@reset');

