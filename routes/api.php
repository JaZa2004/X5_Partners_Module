<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AgreementtermController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\PartnershipController;
use App\Http\Controllers\RepresentativeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (require auth:sanctum middleware)
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']); // Changed to POST for RESTfulness

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/test-gate', [AuthController::class, 'testGate']);

    Route::resource('documents', DocumentController::class);
    Route::resource('representatives', RepresentativeController::class);
    Route::resource('users', UserController::class);
    Route::resource('partnerships', PartnershipController::class);
    Route::resource('partners', PartnerController::class);
    Route::resource('addresses', AddressController::class);
    Route::resource('agreementterms', AgreementtermController::class);
    Route::resource('services', ServiceController::class);
    Route::get('partners/{id}/representatives',[PartnerController::class ,'representatives']);
    Route::get('partners/{id}/addresses',[PartnerController::class ,'addresses']);
    Route::get('partners/{id}/partnerships',[PartnerController::class ,'partnerships']);
    Route::get('partnerships/{id}/documents',[PartnershipController::class ,'documents']);
    Route::get('partnerships/{id}/services',[PartnershipController::class ,'services']);
    Route::get('partnerships/{id}/agreementterms',[PartnershipController::class ,'agreementterms']);


});
