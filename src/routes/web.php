<?php

use Illuminate\Support\Facades\Auth;
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

// Авторизация от Laravel
Auth::routes();

// Главная
Route::get('/', [App\Http\Controllers\IndexController::class, 'index'])->name('index');

// Страница с токеном
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Создание ссылки
Route::post('/make', [\App\Http\Controllers\LinkController::class, 'makeLink'])->name('makeLink');

// Обработка кода
Route::any('/{any}', [\App\Http\Controllers\LinkController::class, 'goLink'])->where('any', '^(?!api).*$')->name('go');
