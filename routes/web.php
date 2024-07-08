<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ApartmentController;
use App\Http\Controllers\Admin\ViewController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\SponsorController;
use App\Http\Controllers\Admin\ApartmentSponsorController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->name('admin.')->prefix('admin')->group(function(){
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('apartments', ApartmentController::class)->parameters(['apartments' => 'apartment:slug']);
    Route::post('/apartments/{id}/upload-images', [ApartmentController::class, 'uploadImages'])->name('apartments.uploadImages');
    Route::resource('views', ViewController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('messages', MessageController::class);
    Route::resource('images', ImageController::class);
    Route::resource('sponsors', SponsorController::class);
    Route::resource('apartment_sponsors', ApartmentSponsorController::class);
    Route::get('apartments/{apartment}/sponsor', [SponsorController::class, 'create'])->name('sponsor.create');
    Route::post('apartments/{apartment}/sponsor', [SponsorController::class, 'store'])->name('sponsor.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::fallback(function(){
    return redirect()->route('admin.dashboard');
});