<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ContactController;

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

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/registration_success', [ContactController::class, 'registration_success']);

Route::get('/home', [ContactController::class, 'index']);

Route::get('/create', [ContactController::class, 'create']);

Route::post('/store', [ContactController::class, 'store'])->name('store');

Route::get('/edit/{contact}', [ContactController::class, 'edit']);

Route::put('/update/{contact}', [ContactController::class, 'update'])->name('update');

Route::delete('/delete/{contact}', [ContactController::class, 'destroy'])->name('delete');

Route::get('search', [ContactController::class, 'search']);

// Route::patch('/update/{contact}', [ContactController::class, 'update'])->name('update');

// Route::post('/updatesya/{contact}', [ContactController::class, 'update'])->name('updatesya');

// Route::put('/update', [ContactController::class, 'update'])->name('update');

// Route::get();