<?php

use App\Http\Controllers\RankfreeConnectionController;
use App\Http\Middleware\RankfreeConnectionApi;
use Illuminate\Support\Facades\Route;

Route::prefix('api/account/rankfree-connection')->name('account.rankfree-connection.')
    ->middleware(['auth', RankfreeConnectionApi::class])->group(function () {
        Route::get('/', [RankfreeConnectionController::class, 'show'])->middleware('throttle:rankfree-connection-read')->name('show');
        Route::put('/', [RankfreeConnectionController::class, 'update'])->middleware('throttle:rankfree-connection-write')->name('update');
        Route::delete('/', [RankfreeConnectionController::class, 'destroy'])->middleware('throttle:rankfree-connection-write')->name('destroy');
    });
