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
Route::get('apartments/search/{address}/{lat}/{lon}/{serviceId?}', [ApartmentController::class, 'search']);
Route::get('apartments/{id}', [ApartmentController::class, 'show']);
Route::get('apartments/{slug}/services', [ApartmentController::class, 'services']);
Route::post('apartments', [ApartmentController::class, 'store']);
Route::put('apartments/{id}', [ApartmentController::class, 'update']);
Route::delete('apartments/{id}', [ApartmentController::class, 'destroy']);
Route::post('/apartments/{apartment}/send-message', [MessageController::class, 'sendMessage']);
Route::get('/apartments/filter-by-service/{serviceId}/{latitude}/{longitude}', [ApartmentController::class, 'filterByService']);
