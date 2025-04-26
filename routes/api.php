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
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Protected routes (require auth:sanctum middleware)
Route::middleware('auth:sanctum')->group(function () {

    Route::post('logout', [AuthController::class, 'logout']); // Changed to POST for RESTfulness

    Route::get('user', function (Request $request) {
        return $request->user();
    });

    Route::get('/test-gate', [AuthController::class, 'testGate']);

    Route::resource('documents', DocumentController::class)->except(['create', 'edit']);
    Route::resource('representatives', RepresentativeController::class)->except(['create', 'edit']);
    Route::resource('users', UserController::class)->except(['create', 'edit']);
    Route::resource('partnerships', PartnershipController::class)->except(['create', 'edit']);
    Route::resource('partners', PartnerController::class)->except(['create', 'edit']);
    Route::resource('addresses', AddressController::class)->except(['create', 'edit']);
    Route::resource('agreementterms', AgreementtermController::class)->except(['create', 'edit']);
    Route::resource('services', ServiceController::class)->except(['create', 'edit']);

    Route::get('partners/{id}/representatives',[PartnerController::class ,'representatives']);
    Route::get('partners/{id}/addresses',[PartnerController::class ,'addresses']);
    Route::get('partners/{id}/partnerships',[PartnerController::class ,'partnerships']);
    Route::get('partnerships/{id}/documents',[PartnershipController::class ,'documents']);
    Route::get('partnerships/{id}/services',[PartnershipController::class ,'services']);
    Route::get('partnerships/{id}/agreementterms',[PartnershipController::class ,'agreementterms']);


});
