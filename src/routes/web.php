<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MylistController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;

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
Route::get('/item/{item}', [ItemController::class, 'show'])->name('items.show');

Route::middleware('auth')->group(function () {
    Route::get('/sell', [ItemController::class, 'create'])->name('items.create');
    Route::post('/sell', [ItemController::class, 'store'])->name('items.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/mypage', [MypageController::class, 'index'])->name('mypage');
});


Route::middleware('auth')->group(function () {
    Route::get('/?tab=mylist', [MyListController::class, 'index'])->name('mylist.index');
});

Route::get('/register', [AuthController::class, 'register']);
// Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'login'])->name('login');

// Route::middleware('auth')->group(function () {
//     Route::get('/mypage', [ItemController::class, 'mypage'])->name('mypage');
// });

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

// Route::middleware('auth')->group(function () {
//     Route::post('/item/{item}/comments', [CommentController::class, 'store'])
//         ->name('items.comments.store');
// });
Route::middleware('auth')->group(function () {
    Route::post('/item/{item}/comments', [CommentController::class, 'store'])
        ->name('items.comments.store');
});


Route::middleware('auth')->group(function() {
    Route::get('/purchase/{item}', [PurchaseController::class, 'show'])
        ->name('purchase.show');
});