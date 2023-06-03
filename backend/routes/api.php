<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', 'App\Http\Controllers\AuthController@login');
Route::post('/login/admin', 'App\Http\Controllers\AuthController@login_admin');
Route::post('/register', 'App\Http\Controllers\AuthController@register');
// get all kelas
Route::get('/kelas', 'App\Http\Controllers\UserController@get_all_kelas');

Route::middleware('admin.api')->prefix('/admin')->group(function () {
    Route::get('/profile', 'App\Http\Controllers\AdminController@profile');
    Route::get('/dashboard', 'App\Http\Controllers\AdminController@dashboard');

    Route::get('/pemilihan', 'App\Http\Controllers\AdminController@get_all_pemilihan');
    Route::get('/pemilihan/{id}', 'App\Http\Controllers\AdminController@get_pemilihan');
    Route::post('/pemilihan', 'App\Http\Controllers\AdminController@create_pemilihan');
    Route::post('/pemilihan/{id}', 'App\Http\Controllers\AdminController@update_pemilihan');
    Route::delete('/pemilihan/{id}', 'App\Http\Controllers\AdminController@delete_pemilihan');

    Route::get('/kandidat', 'App\Http\Controllers\AdminController@get_all_kandidat');
    Route::get('/kandidat/{id}', 'App\Http\Controllers\AdminController@get_kandidat');
    Route::post('/kandidat', 'App\Http\Controllers\AdminController@create_kandidat');
    Route::post('/kandidat/{id}', 'App\Http\Controllers\AdminController@update_kandidat');
    Route::delete('/kandidat/{id}', 'App\Http\Controllers\AdminController@delete_kandidat');

    Route::get('/user', 'App\Http\Controllers\AdminController@get_all_user');
    Route::get('/user/{id}', 'App\Http\Controllers\AdminController@get_user');
    Route::post('/user', 'App\Http\Controllers\AdminController@create_user');
    Route::put('/user/{id}', 'App\Http\Controllers\AdminController@update_user');
    Route::delete('/user/{id}', 'App\Http\Controllers\AdminController@delete_user');

    Route::get('/kelas', 'App\Http\Controllers\AdminController@get_all_kelas');
    Route::get('/kelas/{id}', 'App\Http\Controllers\AdminController@get_kelas');
    Route::post('/kelas', 'App\Http\Controllers\AdminController@create_kelas');
    Route::put('/kelas/{id}', 'App\Http\Controllers\AdminController@update_kelas');
    Route::delete('/kelas/{id}', 'App\Http\Controllers\AdminController@delete_kelas');

    Route::get('/jurusan', 'App\Http\Controllers\AdminController@get_all_jurusan');
    Route::get('/jurusan/{id}', 'App\Http\Controllers\AdminController@get_jurusan');
    Route::post('/jurusan', 'App\Http\Controllers\AdminController@create_jurusan');
    Route::put('/jurusan/{id}', 'App\Http\Controllers\AdminController@update_jurusan');
    Route::delete('/jurusan/{id}', 'App\Http\Controllers\AdminController@delete_jurusan');
});

Route::middleware('user.api')->group(function () {
    Route::get('/profile', 'App\Http\Controllers\UserController@profile');
    Route::put('/profile', 'App\Http\Controllers\UserController@update_profile');

    Route::get('/pemilihan', 'App\Http\Controllers\UserController@get_all_pemilihan');
    Route::get('/pemilihan/status', 'App\Http\Controllers\UserController@get_all_pemilihan_status');
    Route::get('/pemilihan/{id}', 'App\Http\Controllers\UserController@get_pemilihan');
    Route::post('/pemilihan/{id}/vote/{id_kandidat}', 'App\Http\Controllers\UserController@vote');
});