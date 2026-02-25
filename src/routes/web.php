<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
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


Route::get('/', [ItemController::class, 'index']);
Route::get('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'login']);

Route::get('/profile', function () {
    return view('items.profile');
})->middleware('auth');

Route::get('/dashboard', [ItemController::class, 'index'])->middleware('auth');