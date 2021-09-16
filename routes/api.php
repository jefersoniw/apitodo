<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/ping', function () {
    return [
        'pong' => true
    ];
});

Route::post('/todo', [ApiController::class, 'createTodo'])->middleware('auth:api');
Route::get('/todos', [ApiController::class, 'readAllTodos']);
Route::get('/todo/{id}', [ApiController::class, 'readTodo']);
Route::put('/todo/{id}', [ApiController::class, 'updateTodo'])->middleware('auth:api');
Route::delete('/todo/{id}', [ApiController::class, 'deleteTodo'])->middleware('auth:api');

Route::post('/user', [AuthController::class, 'create']);


//jwt
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/logout', [AuthController::class, 'logout'])->middleware('auth:api');
Route::get('/auth/me', [AuthController::class, 'me'])->middleware('auth:api');

Route::get('/unauthenticated', function () {
    return ['error' => 'O usuário não está logado'];
})->name('login');
