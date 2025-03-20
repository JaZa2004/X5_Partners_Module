<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\PartnershipController;
use App\Http\Controllers\RepresentativeController;
use App\Http\Controllers\UserController;
use App\Models\Representative;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::resource('documents', DocumentController::class);
Route::resource('representatives', RepresentativeController::class);
Route::resource('users', UserController::class);
Route::resource('partnerships', PartnershipController::class);
Route::resource('partners', PartnerController::class);
