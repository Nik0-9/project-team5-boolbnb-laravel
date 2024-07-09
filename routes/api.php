<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Api\ApartmentController;
use App\Http\Controllers\Api\MessageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rotte per gli appartamenti
Route::get('apartments', [ApartmentController::class, 'index']);
Route::get('apartments/sponsored', [ApartmentController::class, 'getSponsoredApartments']);
Route::get('apartments/base', [ApartmentController::class, 'getBaseApartments']);
Route::get('apartments/{slug}', [ApartmentController::class, 'show']);
Route::post('apartments', [ApartmentController::class, 'store']);
Route::post('/apartments/{apartment}/send-message', [MessageController::class, 'sendMessage']);
Route::get('apartments/search/{address}/{latitude}/{longitude}', [ApartmentController::class, 'search']);