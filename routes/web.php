<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NasabahController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('nasabah')->name('nasabah.')->group(function() {
    Route::get('/', [NasabahController::class, 'index'])->name('index');
    Route::get('create', [NasabahController::class, 'create'])->name('create');
    Route::post('create', [NasabahController::class, 'store'])
    ->name('store');
    Route::get('edit/{user}', [NasabahController::class, 'edit'])->name('edit');
    Route::put('edit/{user}', [NasabahController::class, 'update'])->name('update');
    Route::delete('destroy/{user}', [NasabahController::class, 'destroy'])->name('destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
