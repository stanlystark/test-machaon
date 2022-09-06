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

// Создать короткую ссылку
Route::post('/short', [\App\Http\Controllers\API\LinkUserController::class, 'makeLink']);
// Получить полный адрес короткой ссылки
Route::post('/link', [\App\Http\Controllers\API\LinkUserController::class, 'getLink']);

// token
Route::middleware('token')->prefix('admin')->group(function() {
    // Получить список всех созданных ссылок
    Route::post('/list', [\App\Http\Controllers\API\LinkAdminController::class, 'getLinks']);
    // Получить данные конкретной ссылки
    Route::post('/link', [\App\Http\Controllers\API\LinkAdminController::class, 'getLink']);
    // Изменить конкретную ссылку
    Route::post('/update', [\App\Http\Controllers\API\LinkAdminController::class, 'updateLink']);
    // Удалить ссылку
    Route::post('/remove', [\App\Http\Controllers\API\LinkAdminController::class, 'removeLink']);
    // Получить список всех переходов по ссылкам
    Route::post('/transitions', [\App\Http\Controllers\API\LinkAdminController::class, 'getTransitions']);
});

// Если нет маршрута - ошибка
Route::any('/{any}', [\App\Http\Controllers\API\LinkUserController::class, 'fail']);
