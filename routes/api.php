<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Transaction\TransactionsController;
use App\Http\Controllers\Api\Subscription\SubscriptionsController;
use App\Http\Controllers\Api\User\UsersController;
use Illuminate\Support\Facades\Route;

Route::group([], function () {
    Route::post('/register', [RegisterController::class, 'register'])->name('register');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::group(['prefix' => 'users/{user}', 'as' => 'users.'], function () {

        Route::get('/', [UsersController::class, 'index'])->name('index');

        Route::group(['prefix' => 'subscriptions', 'as' => 'subscriptions.'], function () {
            Route::get('/', [SubscriptionsController::class, 'index'])->name('index');
            Route::post('/', [SubscriptionsController::class, 'store'])->name('store');
            Route::put('/{subscription}', [SubscriptionsController::class, 'update'])->name('update');
            Route::delete('/{subscription}', [SubscriptionsController::class, 'destroy'])->name('destroy');
        });

        Route::group(['prefix' => 'transactions', 'as' => 'transactions.'], function () {
            Route::get('/', [TransactionsController::class, 'index'])->name('index');
            Route::post('/', [TransactionsController::class, 'store'])->name('store');
        });
    });
});
