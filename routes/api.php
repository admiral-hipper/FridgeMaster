<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlocksController;
use App\Http\Controllers\CustomerController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login', [AuthController::class, 'signIn']);
Route::post('/register', [AuthController::class, 'signUp']);
Route::get('/logout', [AuthController::class, 'signOut']);
Route::prefix('customers')->middleware('auth:apiAccess')->group(function () {
    Route::prefix('orders')->group(function () {
        Route::get('/', [CustomerController::class, 'index']);
        Route::post('/', [CustomerController::class, 'book']);
        Route::delete('/{id}', [CustomerController::class, 'terminateBook']);
        Route::get('/{id}', [CustomerController::class, 'singleBook']);
        Route::put('/{id}', [CustomerController::class, 'changeBook']);
    });
});
Route::post('/calculation', [CustomerController::class, 'calculate']);
Route::get('/locations', [BlocksController::class, 'index']);
