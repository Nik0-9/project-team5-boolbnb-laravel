<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ApartmentController;
use App\Http\Controllers\Admin\ViewController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\SponsorController;
use App\Http\Controllers\Admin\ApartmentSponsorController;
use App\Http\Controllers\Admin\BraintreeController;

Route::middleware('auth')->name('admin.')->prefix('admin')->group(function(){
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('apartments', ApartmentController::class)->parameters(['apartments' => 'apartment:slug']);
    Route::get('/apartments/messages/{slug}', [ApartmentController::class, 'showMessages'])->name('apartments.messages');
    Route::post('/apartments/{id}/upload-images', [ApartmentController::class, 'uploadImages'])->name('apartments.uploadImages');
    Route::delete('/apartments/images/{image}', [ApartmentController::class, 'deleteImage'])->name('apartments.deleteImage');
    Route::resource('views', ViewController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('messages', MessageController::class);
    Route::get('messages/{message}', [MessageController::class, 'show'])->name('messages.show');
    Route::resource('images', ImageController::class);
    Route::resource('sponsors', SponsorController::class);
    Route::resource('apartment_sponsors', ApartmentSponsorController::class);
    Route::get('payment', [BraintreeController::class, 'index'])->name('payment.page');
    Route::post('/braintree/checkout', [BraintreeController::class, 'checkout'])->name('braintree.checkout');
    Route::get('/braintree/token', [BraintreeController::class, 'token'])->name('braintree.token');
    Route::get('apartments/{apartment:slug}/sponsor', [SponsorController::class, 'create'])->name('sponsor.create');
    Route::post('apartments/{apartment:slug}/sponsor', [SponsorController::class, 'store'])->name('sponsor.store');

});

Route::middleware('auth')->group(function () {
    //Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    //Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::fallback(function(){
    return redirect()->route('admin.dashboard');
});