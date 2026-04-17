<?php

use App\Http\Controllers\BranchController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusinessUnitController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProductLineController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ImportBatchController;
use App\Http\Controllers\SalesTransactionController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('branches', BranchController::class);
    Route::resource('business-units', BusinessUnitController::class)->except(['destroy']);
    Route::resource('locations', LocationController::class)->except(['destroy']);
    Route::resource('product-lines', ProductLineController::class)->except(['destroy']);
    Route::resource('categories', CategoryController::class)->except(['destroy']);
    Route::resource('brands', BrandController::class)->except(['destroy']);
    Route::resource('import-batches', ImportBatchController::class)->only(['index', 'create', 'store', 'show']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('import-batches/{import_batch}/sheets/{sheet}/preview',[ImportBatchController::class, 'previewSheet'])->name('import-batches.sheets.preview');
    Route::post('import-batches/{import_batch}/sheets/{sheet}/parse',[ImportBatchController::class, 'parseSheet'])->name('import-batches.sheets.parse');
    Route::get('/sales-transactions', [SalesTransactionController::class, 'index'])->name('sales-transactions.index');
    Route::get('/sales-transactions/{salesTransaction}', [SalesTransactionController::class, 'show'])->name('sales-transactions.show');
    Route::post('import-batches/{import_batch}/parse-all',[ImportBatchController::class, 'parseAllSheets'])->name('import-batches.parse-all');
    Route::post('import-batch-sheets/{import_batch_sheet}/reset',[ImportBatchController::class, 'resetSheet'])->name('import-batch-sheets.reset');
    
});

require __DIR__.'/auth.php';