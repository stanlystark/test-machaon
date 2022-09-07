<?php

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

// Создать короткую ссылку
Route::put('/link', [\App\Http\Controllers\API\LinkUserController::class, 'makeLink']);
// Получить полный адрес короткой ссылки
Route::get('/link', [\App\Http\Controllers\API\LinkUserController::class, 'getLink']);

Route::middleware('token')->prefix('admin')->group(function () {
    // Получить список всех созданных ссылок
    Route::get('/links', [\App\Http\Controllers\API\LinkAdminController::class, 'getLinks']);
    // Получить данные конкретной ссылки
    Route::get('/link', [\App\Http\Controllers\API\LinkAdminController::class, 'getLink']);
    // Изменить конкретную ссылку
    Route::patch('/link', [\App\Http\Controllers\API\LinkAdminController::class, 'updateLink']);
    // Удалить ссылку
    Route::delete('/link', [\App\Http\Controllers\API\LinkAdminController::class, 'removeLink']);
    // Получить список всех переходов по ссылкам
    Route::get('/transitions', [\App\Http\Controllers\API\LinkAdminController::class, 'getTransitions']);
});

// Если нет маршрута - ошибка
Route::any('/{any}', [\App\Http\Controllers\API\LinkUserController::class, 'fail']);
