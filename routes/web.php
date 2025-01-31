<?php

use Illuminate\Support\Facades\Route;

// Public Controllers
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\ImageController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StorageSettingController;
use App\Http\Controllers\Admin\ImageController as AdminImageController;

require __DIR__ . '/auth.php';

// Home Screen

Route::get('/', [HomeController::class, 'index'])->name('index');

// Image

Route::controller(ImageController::class)
    ->group(function () {
        $filenameRegex = '^[a-zA-Z0-9_-]+\.(jpg|jpeg|png)$';

        Route::get('/{filename}', 'show')
            ->where('filename', $filenameRegex)
            ->name('images.show');
    });

// Admin Dashboard

Route::middleware(['auth'])->get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Admin Dashboard - Images

Route::prefix('admin/dashboard')
    ->middleware(['auth'])
    ->controller(AdminImageController::class)
    ->group(function () {
        $filenameRegex = '^[a-zA-Z0-9_-]+\.(jpg|jpeg|png)$';

        Route::get('/image-create', 'create')->name('auth.images.create');

        Route::get('/image-edit/{filename}', 'edit')
            ->where('filename', $filenameRegex)
            ->name('auth.images.edit');

        Route::post('/image-upload', 'store')->name('auth.images.upload');

        Route::put('/image-update/{filename}', 'update')
            ->where('filename', $filenameRegex)
            ->name('auth.images.update');

        Route::delete('/image-delete/{filename}', 'destroy')
            ->where('filename', $filenameRegex)
            ->name('auth.images.delete');
    });

// Admin Dashboard - Storage Setting

Route::prefix('admin/dashboard')
    ->middleware(['auth'])
    ->controller(StorageSettingController::class)
    ->group(function () {
        Route::post('/storage-mode', 'update')->name('auth.storage.update');
    });
