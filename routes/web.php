<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\PhotoController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/photos');

Route::get('/photos', [PhotoController::class, 'index'])->name('photos.index');
Route::post('/photos', [PhotoController::class, 'store'])->name('photos.store');
Route::put('/photos/{photo}', [PhotoController::class, 'update'])->name('photos.update');
Route::delete('/photos/{photo}', [PhotoController::class, 'destroy'])->name('photos.destroy');

Route::get('/docs', [DocumentController::class, 'index'])->name('docs.index');
Route::post('/docs', [DocumentController::class, 'store'])->name('docs.store');
Route::put('/docs/{document}', [DocumentController::class, 'update'])->name('docs.update');
Route::delete('/docs/{document}', [DocumentController::class, 'destroy'])->name('docs.destroy');
