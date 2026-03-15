<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MylistController;
use App\Http\Controllers\ProfileController;

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


Route::get('/', [ItemController::class, 'index'])->name('items.index');
Route::get('/item/{item}', [ItemController::class, 'show'])->name('item.show');

Route::middleware('auth')->group(function () {
    Route::get('/?tab=mylist', [MyListController::class, 'index'])->name('mylist.index');
});

Route::get('/register', [AuthController::class, 'register']);
// Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/mypage', [ItemController::class, 'mypage'])->name('mypage');
});

// Route::get('/mypage/profile', [ItemController::class, 'profile'])->middleware('auth');
// Route::get('/mypage/profile', function () {
//     return view('items.profile');
// })->middleware('auth');

// Route::get('/mypage/profile', [ProfileController::class, 'edit'])->middleware('auth');


Route::middleware('auth')->group(function () {
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::get('/dashboard', [ItemController::class, 'index'])->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::post('/item/{item}/like', [LikeController::class, 'toggle'])->name('items.like.toggle');
});