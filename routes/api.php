<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Resources\LocationResource;
use App\Models\Locations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
Route::prefix('customer')->middleware('auth:apiAccess')->group(function () {
    Route::prefix('orders')->group(function () {
        Route::delete('/{id}', [CustomerController::class, 'terminateBook']);
        Route::get('/{id}', [CustomerController::class, 'singleBook']);
        Route::post('/', [CustomerController::class, 'book']);
        Route::put('/{id}', [CustomerController::class, 'changeBook']);
    });
    Route::get('/', [CustomerController::class, 'index']);
});
Route::post('/calculation', [CustomerController::class, 'calculate']);
