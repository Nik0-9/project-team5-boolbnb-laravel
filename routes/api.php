 <?php
/*
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Api\ApartmentController;
use App\Http\Controllers\Api\MessageController;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('apartments', [ApartmentController::class, 'index']);
Route::get('apartments/sponsored', [ApartmentController::class, 'getSponsoredApartments']);
Route::get('apartments/search/{address}/{lat}/{lon}', [ApartmentController::class, 'search']);
Route::get('apartments/{id}', [ApartmentController::class, 'show']);
Route::get('apartments/{slug}/services', [ApartmentController::class, 'services']);
Route::post('apartments', [ApartmentController::class, 'store']);
Route::put('apartments/{id}', [ApartmentController::class, 'update']);
Route::delete('apartments/{id}', [ApartmentController::class, 'destroy']);
Route::post('/apartments/{apartment}/send-message', [MessageController::class, 'sendMessage']); */
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Api\ApartmentController;
use App\Http\Controllers\Api\MessageController;

Route::post('api-register', [RegisteredUserController::class, 'store'])->name('api.register');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

Route::get('apartments', [ApartmentController::class, 'index']);
Route::get('apartments/search/{address}/{lat}/{lon}', [ApartmentController::class, 'search']);
Route::get('apartments/sponsored', [ApartmentController::class, 'sponsored']);
Route::get('apartments/{id}', [ApartmentController::class, 'show']);
Route::post('apartments', [ApartmentController::class, 'store']);
Route::put('apartments/{id}', [ApartmentController::class, 'update']);
Route::delete('apartments/{id}', [ApartmentController::class, 'destroy']);
Route::post('apartments/{apartment}/send-message', [MessageController::class, 'sendMessage']);
