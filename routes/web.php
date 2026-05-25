<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect()->route('photos.index');
});

Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::resource('photos', PhotoController::class);
Route::post('photos/{photo}/like', [PhotoController::class, 'like'])->name('photos.like');

Route::middleware('auth')->get('favorites', function () {
    return view('photos.favorites');
})->name('favorites');

Route::post('inquiries', [InquiryController::class, 'store'])->name('inquiries.store');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('inquiries', InquiryController::class)->except(['create', 'store', 'edit']);
});
