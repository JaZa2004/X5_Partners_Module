<?php

use App\Http\Controllers\DocumentController;
use App\Models\Partner;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
