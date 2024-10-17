<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('register',[AuthController::class, 'register'])->name('register');
Route::get('login',[AuthController::class, 'login'])->name('login');
Route::get('logout',[AuthController::class, 'logout'])->name('logout');


