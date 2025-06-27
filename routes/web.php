<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NasabahController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\SchemaController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', fn () => view('home'))->name('dashboard');

    /**
     * ADMIN ONLY ROUTES
     */
    Route::middleware('role:admin')->group(function () {
        Route::resource('nasabah', NasabahController::class)
            ->except(['show'])
            ->parameters([
                'nasabah' => 'user'
            ]);

        Route::resource('criterias', CriteriaController::class)
            ->except(['show']);

        Route::get('/schema/tables', [SchemaController::class, 'getTables']);
        Route::get('/schema/columns/{table}', [SchemaController::class, 'getColumns']);

        // Khusus admin juga
        Route::post('/loans/evaluations/normalize', [LoanController::class, 'normalize'])->name('pinjaman.normalize');
        Route::patch('/loans/{loan}/approve', [LoanController::class, 'approve'])->name('pinjaman.approve');
        Route::patch('/loans/{loan}/reject', [LoanController::class, 'reject'])->name('loans.reject');
        Route::get('/pinjaman/export/{hash}/{type}', [LoanController::class, 'export'])->name('pinjaman.export');
    });

    /**
     * NASABAH (atau semua user login)
     */
    Route::resource('pinjaman', LoanController::class)
        ->only(['index', 'create', 'store'])
        ->parameters([
            'pinjaman' => 'loan'
        ]);
});

require __DIR__.'/auth.php';
