<?php

use App\Http\Controllers\Admin\GeneralController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'verified', 'admin'], 'prefix' => 'admin'], function () {
    Route::get('/', [GeneralController::class, 'index']);
});
