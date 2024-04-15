<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::put('/stores/{store}', [StoreController::class, 'update'])->name('stores.update');
