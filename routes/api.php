<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Api\ApartmentController;

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

Route::get('apartments', [ApartmentController::class, 'index']);
Route::get('apartment/{id}', [ApartmentController::class, 'show']);
Route::get('apartment/{slug}/services', [ApartmentController::class, 'services']);
Route::get('apartments/sponsored', [ApartmentController::class, 'getSponsoredApartments']);



