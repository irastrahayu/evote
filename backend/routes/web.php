<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KandidatController;
use App\Http\Controllers\PemilihanController;
use Illuminate\Support\Facades\Auth;


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

Route::get('dashboard',[HomeController::class,'dashboard'])->name('dashboard');

Route::get('pemilihan',[PemilihanController::class,'index'])->name('pemilihan');
Route::get('pemilihan/create',[PemilihanController::class,'create'])->name('pemilihan.create');
Route::post('pemilihan/store',[PemilihanController::class,'store'])->name('pemilihan.store');
Route::get('pemilihan/{id}/show',[PemilihanController::class,'show'])->name('pemilihan.show');
Route::get('pemilihan/{id}/edit',[PemilihanController::class,'edit'])->name('pemilihan.edit');
Route::put('pemilihan/{id}/update',[PemilihanController::class,'update'])->name('pemilihan.update');
Route::get('pemilihan/{id}/delete',[PemilihanController::class,'destroy'])->name('pemilihan.delete');
Route::post('pemilihan/{id_pemilihan}/vote/{id_kandidat}',[PemilihanController::class,'vote'])->name('pemilihan.vote');

Route::get('kandidat',[KandidatController::class,'index'])->name('kandidat');
Route::get('kandidat/create',[KandidatController::class,'create'])->name('kandidat.create');
Route::post('kandidat/store',[KandidatController::class,'store'])->name('kandidat.store');
Route::get('kandidat/{id}/show',[KandidatController::class,'show'])->name('kandidat.show');
Route::get('kandidat/{id}/edit',[KandidatController::class,'edit'])->name('kandidat.edit');
Route::post('kandidat/{id}/update',[KandidatController::class,'update'])->name('kandidat.update');
Route::get('kandidat/{id}/delete',[KandidatController::class,'destroy'])->name('kandidat.delete');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
