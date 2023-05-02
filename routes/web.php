<?php

use App\Http\Controllers\DataController;
use App\Http\Controllers\FormController;
use Illuminate\Support\Facades\Route;

Route::get('/', DataController::class)->name('data.view'); # Invokable controller
Route::post('/store', [FormController::class, 'store'])->name('data.store');
