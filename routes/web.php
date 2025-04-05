<?php

use App\Http\Controllers\DocumentController;
use App\Models\Partner;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $partners = Partner::with(['representatives', 'addresses','partnerships','partnerships.agreementterms','partnerships.documents'])->get();
    return response()->json($partners, 200);
});


//Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
