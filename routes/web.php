<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\DashboardControler;
use App\Http\Controllers\CharacterCheck\CharacterCheckControler;
use App\Http\Controllers\Dropdown\DropdownControler;
use App\Http\Controllers\Master\ProductController;
use App\Http\Controllers\Master\SalesPersonController;
use App\Http\Controllers\Sales\SalesController;
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
    return view('welcome');
});

Route::get('/', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/', [LoginController::class, 'autenticate'])->name('login.auth')->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout.auth')->middleware('auth');

Route::get('/dashboard', [DashboardControler::class, 'index'])->middleware('auth');
Route::get('/dropdown', [DropdownControler::class, 'index'])->middleware('auth');
Route::get('/character-check', [CharacterCheckControler::class, 'index'])->middleware('auth');
Route::resource('/sales', SalesController::class)->middleware('auth');
Route::resource('/sales-person', SalesPersonController::class)->middleware('auth');
Route::resource('/product', ProductController::class)->middleware('auth');
