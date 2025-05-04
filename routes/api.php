<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HeroFaqController;

Route::middleware('auth')->get('/user', function (Request $request) {
    return response()->json($request->user());
});

// Route FAQ API (pastikan di luar middleware 'auth')
Route::get('/faq', [HeroFaqController::class, 'api']);
