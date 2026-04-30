<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\BusinessUnitController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImportBatchController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProductLineController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SalesTransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImportConflictController;

Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::middleware(['role:super_admin,admin'])->group(function () {
        Route::resource('branches', BranchController::class);
        Route::resource('business-units', BusinessUnitController::class)->except(['destroy']);
        Route::resource('locations', LocationController::class)->except(['destroy']);
        Route::resource('product-lines', ProductLineController::class)->except(['destroy']);
        Route::resource('categories', CategoryController::class)->except(['destroy']);
        Route::resource('brands', BrandController::class)->except(['destroy']);
    });

    Route::middleware(['role:super_admin,admin,importer'])->group(function () {
        Route::resource('import-batches', ImportBatchController::class)->only(['index', 'create', 'store', 'show']);

        Route::get(
            'import-batches/{import_batch}/sheets/{sheet}/preview',
            [ImportBatchController::class, 'previewSheet']
        )->name('import-batches.sheets.preview');

        Route::post(
            'import-batches/{import_batch}/sheets/{sheet}/parse',
            [ImportBatchController::class, 'parseSheet']
        )->name('import-batches.sheets.parse');

        Route::post(
            'import-batches/{import_batch}/parse-all',
            [ImportBatchController::class, 'parseAllSheets']
        )->name('import-batches.parse-all');

        Route::post(
            'import-batch-sheets/{import_batch_sheet}/reset',
            [ImportBatchController::class, 'resetSheet']
        )->name('import-batch-sheets.reset');

        Route::get('/import-conflicts', [ImportConflictController::class, 'index'])
            ->name('import-conflicts.index');

        Route::get('/import-conflicts/{importConflict}', [ImportConflictController::class, 'show'])
            ->name('import-conflicts.show');

        Route::patch('/import-conflicts/{importConflict}/mark-reviewed', [ImportConflictController::class, 'markReviewed'])
            ->name('import-conflicts.mark-reviewed');

        Route::patch('/import-conflicts/{importConflict}/mark-ignored', [ImportConflictController::class, 'markIgnored'])
            ->name('import-conflicts.mark-ignored');

        Route::patch('/import-conflicts/{importConflict}/accept-update', [ImportConflictController::class, 'acceptIncomingUpdate'])
            ->name('import-conflicts.accept-update');

        Route::patch('/import-conflicts/{importConflict}/mark-resolved', [ImportConflictController::class, 'markResolved'])
            ->name('import-conflicts.mark-resolved');

        Route::delete('/import-conflicts/{importConflict}', [ImportConflictController::class, 'destroy'])
            ->name('import-conflicts.destroy');

        
    });

    Route::middleware(['role:super_admin,admin,importer,viewer'])->group(function () {
        Route::get('/sales-transactions', [SalesTransactionController::class, 'index'])
            ->name('sales-transactions.index');

        Route::get('/sales-transactions/export', [SalesTransactionController::class, 'export'])
            ->name('sales-transactions.export');

        Route::get('/sales-transactions/{salesTransaction}', [SalesTransactionController::class, 'show'])
            ->name('sales-transactions.show');
    });

    Route::middleware(['role:super_admin'])->group(function () {
        Route::resource('users', UserController::class)->except(['destroy']);
    });
});

require __DIR__.'/auth.php';