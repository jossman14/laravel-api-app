<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GithubController;
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


// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    // Route::resource('profile', UserController::class);
    // Route::resource('address', AddressController::class);
    //profile
    Route::get('/profile', [UserController::class, 'index']);
    Route::put('/profile', [UserController::class, 'update']);
    Route::delete('/profile', [UserController::class, 'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']);
    //address
    Route::get('/address', [AddressController::class, 'index']);
    Route::post('/address', [AddressController::class, 'store']);
    Route::put('/address', [AddressController::class, 'update']);
    Route::delete('/address', [AddressController::class, 'destroy']);
    //github repo
    Route::get('/getApi', [GithubController::class, 'getApi']);



});

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
