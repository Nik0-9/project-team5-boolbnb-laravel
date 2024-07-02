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

Route::get('apartments', [\App\Http\Controllers\Api\ApartmentController::class, 'index'])->name('apartments.index');
Route::get('apartment/{id}', [\App\Http\Controllers\Api\ApartmentController::class, 'show'])->name('apartments.show');
Route::get('apartment/{slug}/services', [\App\Http\Controllers\Api\ApartmentController::class, 'services'])->name('apartments.services');


