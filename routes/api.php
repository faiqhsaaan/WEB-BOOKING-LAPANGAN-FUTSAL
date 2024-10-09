<?php

use App\Http\Controllers\api\LocationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('provinces', [LocationController::class,'provinces'])->name('api-provinces');
Route::get('regencies/{provinces_id}', [LocationController::class,'regencies'])->name('api-regencies');