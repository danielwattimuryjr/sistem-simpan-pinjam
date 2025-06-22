<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NasabahController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\SchemaController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('home');
    })->name('dashboard');

    Route::group(['middleware' => ['role:admin']], function() {
        Route::resource('nasabah', NasabahController::class)
            ->except(['show'])
            ->parameters([
                'nasabah' => 'user'
            ]);

        Route::resource('criterias', CriteriaController::class)
            ->except(['show']);

        Route::resource('pinjaman', LoanController::class)
            ->except(['index', 'show', 'create', 'store'])
            ->parameters([
                'pinjaman' => 'loan'
            ]);

        Route::get('/schema/tables', [SchemaController::class, 'getTables']);
        Route::get('/schema/columns/{table}', [SchemaController::class, 'getColumns']);
    });

    Route::resource('pinjaman', LoanController::class)
        ->only(['index', 'show', 'create', 'store'])
        ->parameters([
            'pinjaman' => 'loan'
        ]);
    Route::patch('pinjaman/{loan}/cancel', [LoanController::class, 'cancel'])->name('pinjaman.cancel');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
